<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Create Course</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('instructor.courses.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded border-gray-300">
                    @error('title')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="4" class="w-full rounded border-gray-300">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Category</label>
                    <select name="category_id" class="w-full rounded border-gray-300">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Price ($)</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" step="0.01" min="0" class="w-full rounded border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full">
                </div>
                <div>
                    <label class="flex items-center"><input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}> Publish</label>
                </div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">Create Course</button>
            </form>
        </div>
    </div>
</x-app-layout>
