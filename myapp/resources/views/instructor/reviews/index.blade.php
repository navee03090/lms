<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Reviews - {{ $course->title }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">
                @foreach($reviews as $review)
                <div class="bg-white rounded-xl shadow p-4">
                    <div class="flex items-center gap-2">
                        <span class="text-yellow-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                        <span class="font-medium">{{ $review->user->name }}</span>
                    </div>
                    @if($review->comment)<p class="mt-2 text-gray-600">{{ $review->comment }}</p>@endif
                </div>
                @endforeach
            </div>
            {{ $reviews->links() }}
        </div>
    </div>
</x-app-layout>
