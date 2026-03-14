<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Enrollments - {{ $course->title }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progress</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrolled</th></tr></thead>
                    <tbody>
                        @foreach($enrollments as $e)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $e->user->name }}</td>
                            <td class="px-6 py-4">{{ number_format($e->progress_percentage, 0) }}%</td>
                            <td class="px-6 py-4">{{ $e->created_at->format('M j, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $enrollments->links() }}
        </div>
    </div>
</x-app-layout>
