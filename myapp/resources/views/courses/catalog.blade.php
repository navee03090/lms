@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Course Catalog</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" class="mb-6 flex gap-4 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses..." class="rounded-lg border-gray-300">
                <select name="category_id" class="rounded-lg border-gray-300">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Filter</button>
            </form>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($courses as $course)
                <a href="{{ route('courses.show', $course) }}" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="aspect-video bg-gray-200">
                        @if($course->thumbnail)
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">No image</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold line-clamp-2">{{ $course->title }}</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $course->instructor->name }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-yellow-500">★ {{ number_format($course->reviews_avg_rating ?? 0, 1) }}</span>
                            <span class="text-gray-400">({{ $course->reviews_count }})</span>
                        </div>
                        <p class="font-bold text-indigo-600 mt-2">${{ number_format($course->price, 2) }}</p>
                    </div>
                </a>
                @empty
                <p class="col-span-4 text-gray-500 py-8">No courses found. Run: php artisan db:seed</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $courses->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>
