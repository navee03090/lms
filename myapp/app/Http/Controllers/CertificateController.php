<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function download(string $code): Response
    {
        $certificate = Certificate::where('certificate_code', $code)->firstOrFail();

        if ($certificate->user_id !== auth()->id() && ! auth()->user()?->isAdmin()) {
            abort(403, 'Unauthorized to download this certificate.');
        }

        $path = Storage::disk('public')->path($certificate->certificate_file);

        if (! file_exists($path)) {
            abort(404, 'Certificate file not found.');
        }

        return response()->download($path, "certificate-{$certificate->course->slug}.pdf", [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
