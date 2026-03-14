<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Category Management</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
            <form method="POST" action="{{ route('admin.categories.store') }}" class="bg-white rounded-xl shadow p-6 mb-6">
                @csrf
                <h4 class="font-semibold mb-4">Add Category</h4>
                <div class="flex gap-4">
                    <input type="text" name="name" required placeholder="Category name" class="flex-1 rounded border-gray-300">
                    <input type="text" name="description" placeholder="Description" class="flex-1 rounded border-gray-300">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Add</button>
                </div>
            </form>
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Courses</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th></tr></thead>
                    <tbody>
                        @foreach($categories as $cat)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $cat->name }}</td>
                            <td class="px-6 py-4">{{ $cat->courses_count }}</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.categories.update', $cat) }}" class="inline">@csrf @method('PUT')<input type="text" name="name" value="{{ $cat->name }}" class="rounded border-gray-300 w-40"><button type="submit" class="px-2 py-1 text-indigo-600 text-sm">Update</button></form>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="inline ml-2" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
