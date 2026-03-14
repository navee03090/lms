<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Analytics - {{ $course->title }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500">Enrollments</p><p class="text-2xl font-bold">{{ $course->enrollments_count }}</p></div>
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500">Lessons</p><p class="text-2xl font-bold">{{ $course->lessons_count }}</p></div>
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500">Rating</p><p class="text-2xl font-bold">★ {{ number_format($course->reviews_avg_rating ?? 0, 1) }}</p></div>
            </div>
            <a href="{{ route('instructor.enrollments.index', $course) }}" class="text-indigo-600">View enrolled students →</a>
        </div>
    </div>
</x-app-layout>
