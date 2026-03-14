<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    public function generateCertificate(User $user, Course $course): Certificate
    {
        $certificate = Certificate::firstOrNew([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        if ($certificate->exists) {
            return $certificate;
        }

        $certificate->certificate_code = strtoupper(Str::random(12));
        $certificate->issued_at = now();
        $filename = "certificate_{$user->id}_{$course->id}_{$certificate->certificate_code}.pdf";
        $path = "certificates/{$filename}";

        $course->load('instructor');
        $pdf = Pdf::loadView('certificates.template', [
            'user' => $user,
            'course' => $course,
            'certificate' => $certificate,
        ]);

        Storage::disk('public')->put($path, $pdf->output());
        $certificate->certificate_file = $path;
        $certificate->save();

        return $certificate;
    }
}
