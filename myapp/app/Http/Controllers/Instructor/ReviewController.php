<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Course $course): View
    {
        $this->authorize('update', $course);
        $reviews = $course->reviews()->with('user')->latest()->paginate(20);

        return view('instructor.reviews.index', compact('course', 'reviews'));
    }
}
