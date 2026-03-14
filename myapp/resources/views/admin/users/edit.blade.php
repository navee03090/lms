<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit User</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-xl shadow p-6 space-y-4">
                @csrf @method('PUT')
                <div><label class="block text-sm font-medium mb-1">Name</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded border-gray-300"></div>
                <div><label class="block text-sm font-medium mb-1">Role</label><select name="role_id" class="w-full rounded border-gray-300">@foreach($roles as $r)<option value="{{ $r->id }}" {{ $user->role_id == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>@endforeach</select></div>
                <div><label class="flex items-center"><input type="checkbox" name="is_approved" value="1" {{ $user->is_approved ? 'checked' : '' }}> Approved (for instructors)</label></div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg">Update User</button>
            </form>
        </div>
    </div>
</x-app-layout>
