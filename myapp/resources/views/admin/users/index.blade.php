<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">User Management</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
            <form method="GET" class="mb-6 flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="rounded border-gray-300">
                <select name="role" class="rounded border-gray-300"><option value="">All Roles</option><option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option><option value="instructor" {{ request('role')=='instructor'?'selected':'' }}>Instructor</option><option value="student" {{ request('role')=='student'?'selected':'' }}>Student</option></select>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
            </form>
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approved</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th></tr></thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->role?->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $user->is_approved ? 'Yes' : 'No' }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:underline">Edit</a>
                                @if($user->isInstructor() && !$user->is_approved)
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline ml-2">@csrf<button type="submit" class="text-green-600 hover:underline">Approve</button></form>
                                @endif
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline ml-2" onsubmit="return confirm('Delete user?')">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
