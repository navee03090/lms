<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CourseService
{
    public function create(array $data, User $instructor): Course
    {
        $data['instructor_id'] = $instructor->id;
        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = $data['is_published'] ?? false;

        return Course::create($data);
    }

    public function update(Course $course, array $data): Course
    {
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        $course->update($data);

        return $course->fresh();
    }

    public function uploadThumbnail(Course $course, UploadedFile $file): string
    {
        $path = $file->store('courses/thumbnails', 'public');
        $course->update(['thumbnail' => $path]);

        return $path;
    }

    public function getPublishedCourses(array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Course::with(['instructor', 'category'])
            ->where('is_published', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhere('description', 'like', '%'.$filters['search'].'%');
            });
        }
        if (! empty($filters['instructor_id'])) {
            $query->where('instructor_id', $filters['instructor_id']);
        }
        if (isset($filters['min_rating'])) {
            $query->having('reviews_avg_rating', '>=', $filters['min_rating']);
        }

        return $query->latest()->paginate(12);
    }
}
