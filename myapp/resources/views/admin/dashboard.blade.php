<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Admin Dashboard</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500 text-sm">Users</p><p class="text-2xl font-bold">{{ $totalUsers }}</p></div>
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500 text-sm">Students</p><p class="text-2xl font-bold">{{ $totalStudents }}</p></div>
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500 text-sm">Instructors</p><p class="text-2xl font-bold">{{ $totalInstructors }}</p></div>
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500 text-sm">Courses</p><p class="text-2xl font-bold">{{ $totalCourses }}</p></div>
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500 text-sm">Enrollments</p><p class="text-2xl font-bold">{{ $totalEnrollments }}</p></div>
                <div class="bg-white rounded-xl shadow p-4"><p class="text-gray-500 text-sm">Pending Instructors</p><p class="text-2xl font-bold">{{ $pendingInstructors }}</p></div>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold mb-4">Quick Links</h3>
                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-indigo-600 hover:bg-indigo-50 rounded">Manage Users</a>
                    <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2 text-indigo-600 hover:bg-indigo-50 rounded">Manage Courses</a>
                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-indigo-600 hover:bg-indigo-50 rounded">Manage Categories</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
