<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course): RedirectResponse
    {
        if (! auth()->user()->hasEnrolledIn($course)) {
            return back()->with('error', 'You must complete the course to leave a review.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'course_id' => $course->id,
            ],
            $validated
        );

        return back()->with('success', 'Thank you for your review!');
    }
}
