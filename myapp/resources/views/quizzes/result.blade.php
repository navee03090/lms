<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Quiz Result</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-8 text-center">
                <h3 class="text-2xl font-bold {{ $attempt->passed ? 'text-green-600' : 'text-gray-700' }}">
                    {{ $attempt->passed ? 'Congratulations! You passed!' : 'Quiz completed' }}
                </h3>
                <p class="text-4xl font-bold mt-4">{{ $attempt->percentage }}%</p>
                <p class="text-gray-500 mt-2">Score: {{ $attempt->score }} / {{ $attempt->total_questions }}</p>
                <a href="{{ route('courses.learn', $attempt->quiz->course) }}" class="inline-block mt-6 px-6 py-3 bg-indigo-600 text-white rounded-lg">Back to Course</a>
            </div>
        </div>
    </div>
</x-app-layout>
