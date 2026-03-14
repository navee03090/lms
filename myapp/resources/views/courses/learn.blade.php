@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $course->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif

            <div class="flex gap-6">
                <div class="flex-1">
                    @if($currentLesson)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                        <div class="aspect-video bg-black">
                            @if($currentLesson->video_path)
                            <video controls class="w-full h-full" src="{{ Storage::url($currentLesson->video_path) }}"></video>
                            @elseif($currentLesson->video_url)
                            <iframe src="{{ $currentLesson->embed_url }}" class="w-full h-full" allowfullscreen></iframe>
                            @else
                            <div class="w-full h-full flex items-center justify-center text-white">No video</div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold">{{ $currentLesson->title }}</h3>
                            @if($currentLesson->content)
                            <div class="mt-4 prose max-w-none">{!! Str::markdown($currentLesson->content) !!}</div>
                            @endif
                            @if($currentLesson->materials->isNotEmpty())
                            <div class="mt-4">
                                <h4 class="font-semibold mb-2">Materials</h4>
                                @foreach($currentLesson->materials as $mat)
                                <a href="{{ Storage::url($mat->file_path) }}" download class="block text-indigo-600 hover:underline">{{ $mat->title }}</a>
                                @endforeach
                            </div>
                            @endif
                            <form method="POST" action="{{ route('lessons.complete', [$course, $currentLesson]) }}" class="mt-6">
                                @csrf
                                <input type="hidden" name="seconds" value="0">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Mark as Complete</button>
                            </form>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        @if($prevLesson)
                        <a href="{{ route('courses.learn', [$course, $prevLesson]) }}" class="px-4 py-2 bg-gray-200 rounded-lg">← Previous</a>
                        @endif
                        @if($nextLesson)
                        <a href="{{ route('courses.learn', [$course, $nextLesson]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Next →</a>
                        @endif
                    </div>
                    @else
                    <div class="bg-white rounded-xl shadow p-8 text-center">
                        <p class="text-gray-500">No lessons in this course yet.</p>
                        @if($certificate)
                        <a href="{{ route('certificates.download', $certificate->certificate_code) }}" class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg">Download Certificate</a>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="w-80 shrink-0">
                    <div class="bg-white rounded-xl shadow p-4 sticky top-4">
                        <h4 class="font-semibold mb-4">Course Content</h4>
                        <div class="space-y-1">
                            @foreach($lessons as $lesson)
                            <a href="{{ route('courses.learn', [$course, $lesson]) }}" class="block py-2 px-3 rounded {{ $currentLesson && $currentLesson->id === $lesson->id ? 'bg-indigo-100 text-indigo-700' : 'hover:bg-gray-100' }}">
                                {{ $lesson->title }}
                            </a>
                            @endforeach
                        </div>
                        @if($quizzes->isNotEmpty())
                        <h4 class="font-semibold mt-4 mb-2">Quizzes</h4>
                        @foreach($quizzes as $quiz)
                        <a href="{{ route('quizzes.start', $quiz) }}" class="block py-2 px-3 rounded hover:bg-gray-100">{{ $quiz->title }}</a>
                        @endforeach
                        @endif
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-sm text-gray-500">Progress: {{ number_format($enrollment->progress_percentage ?? 0, 0) }}%</p>
                            <div class="h-2 bg-gray-200 rounded mt-1"><div class="h-full bg-indigo-600 rounded" style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div></div>
                        </div>
                        @if($certificate)
                        <a href="{{ route('certificates.download', $certificate->certificate_code) }}" class="block mt-4 text-center py-2 bg-green-600 text-white rounded">Download Certificate</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
