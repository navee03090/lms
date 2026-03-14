<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Course Management</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
            <form method="GET" class="mb-6"><input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses..." class="rounded border-gray-300"><button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded ml-2">Search</button></form>
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instructor</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrollments</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th></tr></thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $course->title }}</td>
                            <td class="px-6 py-4">{{ $course->instructor->name }}</td>
                            <td class="px-6 py-4">{{ $course->enrollments_count }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:underline">View</a>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="inline ml-2" onsubmit="return confirm('Permanently delete?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $courses->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
