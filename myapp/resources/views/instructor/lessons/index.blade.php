<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Lessons - {{ $course->title }}</h2>
            <a href="{{ route('instructor.courses.lessons.create', $course) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Add Lesson</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th></tr></thead>
                    <tbody>
                        @foreach($lessons as $lesson)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $lesson->order }}</td>
                            <td class="px-6 py-4">{{ $lesson->title }}</td>
                            <td class="px-6 py-4">{{ $lesson->duration_minutes }} min</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('instructor.lessons.edit', $lesson) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('instructor.lessons.destroy', $lesson) }}" class="inline ml-2" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('instructor.courses.edit', $course) }}" class="inline-block mt-4 text-indigo-600">← Back to Course</a>
        </div>
    </div>
</x-app-layout>
