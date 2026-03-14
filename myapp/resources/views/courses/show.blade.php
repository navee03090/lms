@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $course->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>@endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/2 aspect-video bg-gray-200">
                        @if($course->thumbnail)
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No thumbnail</div>
                        @endif
                    </div>
                    <div class="md:w-1/2 p-8">
                        <h1 class="text-2xl font-bold">{{ $course->title }}</h1>
                        <p class="text-gray-500 mt-2">By {{ $course->instructor->name }}</p>
                        <div class="flex items-center gap-4 mt-4">
                            <span class="text-yellow-500">★ {{ number_format($course->reviews_avg_rating ?? 0, 1) }}</span>
                            <span>{{ $course->reviews_count }} reviews</span>
                            <span>{{ $course->lessons_count }} lessons</span>
                        </div>
                        <p class="mt-4 text-gray-600">{{ Str::limit($course->description, 200) }}</p>
                        <p class="text-2xl font-bold text-indigo-600 mt-4">${{ number_format($course->price, 2) }}</p>

                        @auth
                        @if($isEnrolled)
                        <a href="{{ route('courses.learn', $course) }}" class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Continue Learning</a>
                        @else
                        <form method="POST" action="{{ route('courses.enroll', $course) }}" class="mt-4">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Enroll Now</button>
                        </form>
                        @endif
                        @else
                        <a href="{{ route('login') }}" class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Login to Enroll</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4">Course Content</h3>
                <div class="bg-white rounded-lg shadow p-4">
                    @foreach($course->lessons as $lesson)
                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                        <span>{{ $lesson->title }}</span>
                        <span class="text-sm text-gray-500">{{ $lesson->duration_minutes }} min</span>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($course->reviews->isNotEmpty())
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4">Reviews</h3>
                @foreach($course->reviews->take(5) as $review)
                <div class="bg-white rounded-lg shadow p-4 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-yellow-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                        <span class="font-medium">{{ $review->user->name }}</span>
                    </div>
                    @if($review->comment)<p class="mt-2 text-gray-600">{{ $review->comment }}</p>@endif
                </div>
                @endforeach
            </div>
            @endif

            @auth
            @if($isEnrolled)
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4">Leave a Review</h3>
                <form method="POST" action="{{ route('reviews.store', $course) }}" class="bg-white rounded-lg shadow p-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Rating</label>
                        <select name="rating" class="rounded border-gray-300" required>
                            @for($i = 1; $i <= 5; $i++)<option value="{{ $i }}">{{ $i }} stars</option>@endfor
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Comment (optional)</label>
                        <textarea name="comment" rows="3" class="w-full rounded border-gray-300"></textarea>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Submit Review</button>
                </form>
            </div>
            @endif
            @endauth
        </div>
    </div>
</x-app-layout>
