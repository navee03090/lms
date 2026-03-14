<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseLearningController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Instructor\EnrollmentController as InstructorEnrollmentController;
use App\Http\Controllers\Instructor\LessonController as InstructorLessonController;
use App\Http\Controllers\Instructor\QuizController as InstructorQuizController;
use App\Http\Controllers\Instructor\ReviewController as InstructorReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [HomeController::class, 'catalog'])->name('courses.catalog');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show')->where('course', '[0-9]+');
Route::get('/instructor/{user}', function ($user) {
    return redirect()->route('courses.catalog', ['instructor_id' => $user]);
})->where('user', '[0-9]+')->name('instructor.profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Course enrollment
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::get('/courses/{course}/learn/{lesson?}', [CourseLearningController::class, 'show'])->name('courses.learn');
    Route::post('/courses/{course}/lessons/{lesson}/complete', [CourseLearningController::class, 'completeLesson'])->name('lessons.complete');

    // Quiz
    Route::get('/quizzes/{quiz}/start', [QuizController::class, 'start'])->name('quizzes.start');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::get('/quiz-attempts/{attempt}', [QuizController::class, 'result'])->name('quizzes.result');

    // Reviews
    Route::post('/courses/{course}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Certificates
    Route::get('/certificates/{code}/download', [CertificateController::class, 'download'])->name('certificates.download');

    // Student dashboard
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', StudentDashboardController::class)->name('dashboard');
    });

    // Instructor routes
    Route::middleware('role:instructor')->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/dashboard', InstructorDashboardController::class)->name('dashboard');
        Route::resource('courses', InstructorCourseController::class)->except(['show']);
        Route::get('courses/{course}/analytics', [InstructorCourseController::class, 'analytics'])->name('courses.analytics');
        Route::resource('courses.lessons', InstructorLessonController::class)->shallow()->except(['show']);
        Route::get('courses/{course}/lessons', [InstructorLessonController::class, 'index'])->name('courses.lessons.index');
        Route::get('courses/{course}/lessons/create', [InstructorLessonController::class, 'create'])->name('courses.lessons.create');
        Route::post('courses/{course}/lessons', [InstructorLessonController::class, 'store'])->name('courses.lessons.store');
        Route::get('lessons/{lesson}/edit', [InstructorLessonController::class, 'edit'])->name('lessons.edit');
        Route::put('lessons/{lesson}', [InstructorLessonController::class, 'update'])->name('lessons.update');
        Route::delete('lessons/{lesson}', [InstructorLessonController::class, 'destroy'])->name('lessons.destroy');
        Route::post('lessons/{lesson}/materials', [InstructorLessonController::class, 'addMaterial'])->name('lessons.materials.store');
        Route::delete('lessons/{lesson}/materials/{material}', [InstructorLessonController::class, 'removeMaterial'])->name('lessons.materials.destroy')->scopeBindings();
        Route::get('courses/{course}/quizzes', [InstructorQuizController::class, 'index'])->name('quizzes.index');
        Route::get('courses/{course}/quizzes/create', [InstructorQuizController::class, 'create'])->name('quizzes.create');
        Route::post('courses/{course}/quizzes', [InstructorQuizController::class, 'store'])->name('quizzes.store');
        Route::get('courses/{course}/quizzes/{quiz}/edit', [InstructorQuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('courses/{course}/quizzes/{quiz}', [InstructorQuizController::class, 'update'])->name('quizzes.update');
        Route::delete('courses/{course}/quizzes/{quiz}', [InstructorQuizController::class, 'destroy'])->name('quizzes.destroy');
        Route::post('courses/{course}/quizzes/{quiz}/questions', [InstructorQuizController::class, 'addQuestion'])->name('quizzes.questions.store');
        Route::delete('courses/{course}/quizzes/{quiz}/questions/{question}', [InstructorQuizController::class, 'removeQuestion'])->name('quizzes.questions.destroy');
        Route::get('courses/{course}/enrollments', [InstructorEnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('courses/{course}/reviews', [InstructorReviewController::class, 'index'])->name('reviews.index');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('users', AdminUserController::class)->except(['create', 'store']);
        Route::post('users/{user}/approve', [AdminUserController::class, 'approveInstructor'])->name('users.approve');
        Route::get('courses', [AdminCourseController::class, 'index'])->name('courses.index');
        Route::delete('courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');
        Route::resource('categories', AdminCategoryController::class)->only(['index', 'store', 'update', 'destroy']);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
