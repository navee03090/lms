<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Instructor Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-gray-500">Total Courses</h3>
                    <p class="text-3xl font-bold">{{ $totalCourses }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-gray-500">Total Enrollments</h3>
                    <p class="text-3xl font-bold">{{ $totalEnrollments }}</p>
                </div>
            </div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">My Courses</h3>
                <a href="{{ route('instructor.courses.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Create Course</a>
            </div>
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrollments</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th></tr></thead>
                    <tbody>
                        @forelse($recentEnrollments as $course)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $course->title }}</td>
                            <td class="px-6 py-4">{{ $course->enrollments_count }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('instructor.courses.edit', $course) }}" class="text-indigo-600 hover:underline">Edit</a>
                                <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="ml-2 text-indigo-600 hover:underline">Lessons</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-8 text-gray-500 text-center">No courses yet. <a href="{{ route('instructor.courses.create') }}" class="text-indigo-600">Create one</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
