<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">My Courses</h2>
            <a href="{{ route('instructor.courses.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Create Course</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lessons</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrollments</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th></tr></thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr class="border-t">
                            <td class="px-6 py-4 font-medium">{{ $course->title }}</td>
                            <td class="px-6 py-4">{{ $course->lessons_count }}</td>
                            <td class="px-6 py-4">{{ $course->enrollments_count }}</td>
                            <td class="px-6 py-4">★ {{ number_format($course->reviews_avg_rating ?? 0, 1) }}</td>
                            <td class="px-6 py-4"><span class="px-2 py-1 rounded {{ $course->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $course->is_published ? 'Published' : 'Draft' }}</span></td>
                            <td class="px-6 py-4">
                                <a href="{{ route('instructor.courses.edit', $course) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="ml-2 text-indigo-600 hover:underline">Lessons</a>
                                <a href="{{ route('instructor.quizzes.index', $course) }}" class="ml-2 text-indigo-600 hover:underline">Quizzes</a>
                                <form method="POST" action="{{ route('instructor.courses.destroy', $course) }}" class="inline ml-2" onsubmit="return confirm('Delete this course?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $courses->links() }}
        </div>
    </div>
</x-app-layout>
