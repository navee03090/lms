<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit Lesson</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('instructor.lessons.update', $lesson) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6 space-y-4">
                @csrf @method('PUT')
                <div><label class="block text-sm font-medium mb-1">Title</label><input type="text" name="title" value="{{ old('title', $lesson->title) }}" required class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Content</label><textarea name="content" rows="4" class="w-full rounded border-gray-300">{{ old('content', $lesson->content) }}</textarea></div>
                <div><label class="block text-sm font-medium mb-1">Video URL</label><input type="url" name="video_url" value="{{ old('video_url', $lesson->video_url) }}" class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Or upload new video</label><input type="file" name="video" accept="video/*" class="w-full"></div>
                <div><label class="block text-sm font-medium mb-1">Duration (minutes)</label><input type="number" name="duration_minutes" value="{{ old('duration_minutes', $lesson->duration_minutes) }}" min="0" class="w-full rounded border-gray-300"></div>
                <div><label class="flex items-center"><input type="checkbox" name="is_free" value="1" {{ $lesson->is_free ? 'checked' : '' }}> Free preview</label></div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">Update Lesson</button>
            </form>
        </div>
    </div>
</x-app-layout>
