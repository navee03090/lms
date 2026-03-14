<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">My Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold mb-4">My Courses</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($enrollments as $enrollment)
                @php $c = $enrollment->course; @endphp
                <a href="{{ route('courses.learn', $c) }}" class="bg-white rounded-xl shadow p-4 hover:shadow-lg">
                    <h4 class="font-semibold">{{ $c->title }}</h4>
                    <p class="text-sm text-gray-500">{{ $c->instructor->name }}</p>
                    <div class="mt-2 h-2 bg-gray-200 rounded"><div class="h-full bg-indigo-600 rounded" style="width: {{ $enrollment->progress_percentage }}%"></div></div>
                    <p class="text-sm mt-1">{{ number_format($enrollment->progress_percentage, 0) }}% complete</p>
                </a>
                @empty
                <p class="col-span-3 text-gray-500">You haven't enrolled in any courses yet. <a href="{{ route('courses.catalog') }}" class="text-indigo-600">Browse courses</a></p>
                @endforelse
            </div>
            {{ $enrollments->links() }}

            @if($certificates->isNotEmpty())
            <h3 class="text-lg font-semibold mt-8 mb-4">My Certificates</h3>
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($certificates as $cert)
                <div class="bg-white rounded-xl shadow p-4 flex justify-between items-center">
                    <div>
                        <h4 class="font-semibold">{{ $cert->course->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $cert->issued_at->format('M j, Y') }}</p>
                    </div>
                    <a href="{{ route('certificates.download', $cert->certificate_code) }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Download</a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
