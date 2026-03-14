<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">{{ $quiz->title }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-600 mb-6">{{ $quiz->description }}</p>
                <p class="text-sm text-gray-500">Questions: {{ $quiz->questions->count() }} | Pass: {{ $quiz->pass_percentage }}%</p>
                <form method="POST" action="{{ route('quizzes.submit', $quiz) }}" id="quiz-form">
                    @csrf
                    <input type="hidden" name="time_taken" id="time-taken" value="0">
                    <div class="mt-8 space-y-8">
                        @foreach($quiz->questions as $index => $question)
                        <div>
                            <p class="font-semibold text-lg">{{ $index + 1 }}. {{ $question->question_text }}</p>
                            <div class="mt-4 space-y-2">
                                @foreach($question->options as $option)
                                <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
                                    <span class="ml-2">{{ $option->option_key }}. {{ $option->option_text }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="submit" class="mt-8 px-6 py-3 bg-indigo-600 text-white rounded-lg">Submit Quiz</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        let start = Date.now();
        document.getElementById('quiz-form').addEventListener('submit', () => {
            document.getElementById('time-taken').value = Math.floor((Date.now() - start) / 1000);
        });
    </script>
</x-app-layout>
