@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900">LMS - Advanced Learning Management System</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Hero --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-12 text-white mb-12">
                <h2 class="text-4xl font-bold mb-4">Learn Anything, Anytime</h2>
                <p class="text-xl opacity-90 mb-6">Discover thousands of courses from expert instructors. Start learning today.</p>
                <a href="{{ route('courses.catalog') }}" class="inline-block px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100">Browse Courses</a>
            </div>

            {{-- Categories --}}
            @if($categories->isNotEmpty())
            <div class="mb-12">
                <h3 class="text-xl font-semibold mb-4">Categories</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($categories as $category)
                    <a href="{{ route('courses.catalog', ['category_id' => $category->id]) }}" class="p-4 bg-white rounded-lg shadow hover:shadow-md border border-gray-100">
                        <span class="font-medium">{{ $category->name }}</span>
                        <span class="text-sm text-gray-500">({{ $category->courses_count }})</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Featured Courses --}}
            <div>
                <h3 class="text-xl font-semibold mb-4">Featured Courses</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($featuredCourses as $course)
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
                    <p class="col-span-4 text-gray-500 py-8">No courses yet. Run the seeder to add sample data.</p>
                    @endforelse
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('courses.catalog') }}" class="text-indigo-600 font-medium hover:underline">View all courses →</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
