<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit Quiz - {{ $quiz->title }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('instructor.quizzes.update', [$course, $quiz]) }}" class="bg-white rounded-xl shadow p-6 space-y-4 mb-8">
                @csrf @method('PUT')
                <div><label class="block text-sm font-medium mb-1">Title</label><input type="text" name="title" value="{{ old('title', $quiz->title) }}" required class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="2" class="w-full rounded border-gray-300">{{ old('description', $quiz->description) }}</textarea></div>
                <div><label class="block text-sm font-medium mb-1">Time limit (minutes)</label><input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes', $quiz->time_limit_minutes) }}" min="0" class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Pass percentage</label><input type="number" name="pass_percentage" value="{{ old('pass_percentage', $quiz->pass_percentage) }}" min="1" max="100" class="w-full rounded border-gray-300"></div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">Update Quiz</button>
            </form>
            <h4 class="font-semibold mb-4">Questions</h4>
            @foreach($quiz->questions as $q)
            <div class="bg-white rounded-xl shadow p-4 mb-2">
                <p class="font-medium">{{ $q->question_text }}</p>
                <ul class="mt-2 text-sm text-gray-600">
                    @foreach($q->options as $opt)<li>{{ $opt->option_key }}. {{ $opt->option_text }} {{ $opt->is_correct ? '✓' : '' }}</li>@endforeach
                </ul>
                <form method="POST" action="{{ route('instructor.quizzes.questions.destroy', [$course, $quiz, $q]) }}" class="inline mt-2" onsubmit="return confirm('Remove?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 text-sm">Remove</button></form>
            </div>
            @endforeach
            <a href="{{ route('instructor.quizzes.index', $course) }}" class="inline-block mt-4 text-indigo-600">← Back to Quizzes</a>
        </div>
    </div>
</x-app-layout>
