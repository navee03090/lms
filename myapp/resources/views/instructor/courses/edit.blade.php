@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit Course</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
            <form method="POST" action="{{ route('instructor.courses.update', $course) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6 space-y-4 mb-8">
                @csrf @method('PUT')
                <div><label class="block text-sm font-medium mb-1">Title</label><input type="text" name="title" value="{{ old('title', $course->title) }}" required class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="4" class="w-full rounded border-gray-300">{{ old('description', $course->description) }}</textarea></div>
                <div><label class="block text-sm font-medium mb-1">Category</label><select name="category_id" class="w-full rounded border-gray-300">@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ $course->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium mb-1">Price ($)</label><input type="number" name="price" value="{{ old('price', $course->price) }}" step="0.01" min="0" class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Thumbnail</label>@if($course->thumbnail)<img src="{{ Storage::url($course->thumbnail) }}" class="h-24 mb-2">@endif<input type="file" name="thumbnail" accept="image/*" class="w-full"></div>
                <div><label class="flex items-center"><input type="checkbox" name="is_published" value="1" {{ $course->is_published ? 'checked' : '' }}> Publish</label></div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">Update Course</button>
            </form>
            <div class="flex gap-4">
                <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="px-4 py-2 bg-gray-200 rounded-lg">Manage Lessons</a>
                <a href="{{ route('instructor.quizzes.index', $course) }}" class="px-4 py-2 bg-gray-200 rounded-lg">Manage Quizzes</a>
                <a href="{{ route('instructor.enrollments.index', $course) }}" class="px-4 py-2 bg-gray-200 rounded-lg">Enrollments</a>
            </div>
        </div>
    </div>
</x-app-layout>
