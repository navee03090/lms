<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Add Quiz - {{ $course->title }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('instructor.quizzes.store', $course) }}" class="bg-white rounded-xl shadow p-6 space-y-4">
                @csrf
                <div><label class="block text-sm font-medium mb-1">Title</label><input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="2" class="w-full rounded border-gray-300">{{ old('description') }}</textarea></div>
                <div><label class="block text-sm font-medium mb-1">Time limit (minutes, 0 = no limit)</label><input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes') }}" min="0" class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Pass percentage</label><input type="number" name="pass_percentage" value="{{ old('pass_percentage', 70) }}" min="1" max="100" class="w-full rounded border-gray-300"></div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">Create Quiz</button>
            </form>
        </div>
    </div>
</x-app-layout>
