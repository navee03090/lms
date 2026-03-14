<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Quizzes - {{ $course->title }}</h2>
            <a href="{{ route('instructor.quizzes.create', $course) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Add Quiz</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
            <div class="space-y-4">
                @foreach($quizzes as $quiz)
                <div class="bg-white rounded-xl shadow p-4 flex justify-between items-center">
                    <div>
                        <h4 class="font-semibold">{{ $quiz->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $quiz->questions_count }} questions</p>
                    </div>
                    <div>
                        <a href="{{ route('instructor.quizzes.edit', [$course, $quiz]) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('instructor.quizzes.destroy', [$course, $quiz]) }}" class="inline ml-2" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('instructor.courses.edit', $course) }}" class="inline-block mt-4 text-indigo-600">← Back to Course</a>
        </div>
    </div>
</x-app-layout>
