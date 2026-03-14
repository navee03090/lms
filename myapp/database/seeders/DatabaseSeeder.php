<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $adminRole = Role::where('slug', 'admin')->first();
        $instructorRole = Role::where('slug', 'instructor')->first();
        $studentRole = Role::where('slug', 'student')->first();

        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@lms.test',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'is_approved' => true,
        ]);

        // Instructors
        $instructors = [];
        for ($i = 1; $i <= 5; $i++) {
            $instructors[] = User::create([
                'name' => "Instructor $i",
                'email' => "instructor$i@lms.test",
                'password' => Hash::make('password'),
                'role_id' => $instructorRole->id,
                'is_approved' => true,
            ]);
        }

        // Students
        $students = [];
        for ($i = 1; $i <= 20; $i++) {
            $students[] = User::create([
                'name' => "Student $i",
                'email' => "student$i@lms.test",
                'password' => Hash::make('password'),
                'role_id' => $studentRole->id,
            ]);
        }

        // Categories
        $categories = [];
        foreach (['Web Development', 'Design', 'Business', 'Marketing', 'Programming'] as $name) {
            $categories[] = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Learn $name",
            ]);
        }

        // Courses
        $courseTitles = [
            'Laravel Masterclass', 'PHP Fundamentals', 'Vue.js Complete Guide', 'Tailwind CSS', 'React for Beginners',
            'Node.js Backend', 'Python for Data Science', 'UI/UX Design', 'Digital Marketing', 'Project Management',
        ];

        foreach ($courseTitles as $index => $title) {
            $course = Course::create([
                'title' => $title,
                'slug' => Str::slug($title).'-'.uniqid(),
                'description' => "Comprehensive course on $title. Learn from scratch to advanced.",
                'price' => rand(0, 5) ? rand(20, 199) : 0,
                'is_published' => true,
                'instructor_id' => $instructors[$index % 5]->id,
                'category_id' => $categories[$index % 5]->id,
                'order' => $index,
            ]);

            // Lessons
            for ($l = 1; $l <= 5; $l++) {
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => "Lesson $l: Introduction to " . Str::words($title, 2),
                    'content' => "This is the content for lesson $l.",
                    'duration_minutes' => rand(5, 30),
                    'order' => $l,
                    'is_free' => $l === 1,
                ]);
            }

            // Quiz
            $quiz = Quiz::create([
                'course_id' => $course->id,
                'title' => "$title Quiz",
                'description' => "Test your knowledge",
                'time_limit_minutes' => 10,
                'pass_percentage' => 70,
                'order' => 1,
            ]);

            for ($q = 1; $q <= 5; $q++) {
                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => "Question $q: What is the correct answer?",
                    'order' => $q,
                    'points' => 1,
                ]);
                foreach (['A' => 'Option A', 'B' => 'Option B', 'C' => 'Correct Answer', 'D' => 'Option D'] as $key => $text) {
                    $question->options()->create([
                        'option_text' => $text,
                        'is_correct' => $key === 'C',
                        'option_key' => $key,
                        'order' => ord($key) - 65,
                    ]);
                }
            }
        }

        // Enroll some students
        $courses = Course::all();
        foreach (array_slice($students, 0, 10) as $student) {
            foreach ($courses->random(3) as $course) {
                $student->enrolledCourses()->attach($course->id, [
                    'progress_percentage' => rand(0, 100),
                    'completed_at' => rand(0, 1) ? now() : null,
                ]);
            }
        }
    }
}
