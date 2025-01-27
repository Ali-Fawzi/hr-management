<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">                    
                        <div class="card shadow-sm">
                            <div class="card-body">
                                @if ($activities->isEmpty())
                                    <div class="alert alert-info">No activity logs found.</div>
                                @else
                                    @foreach ($activities as $activity)
                                        <div class="mb-4 p-3 border-bottom">
                                            <p class="mb-1"><strong>Action:</strong> {{ $activity->description }}</p>
                                            <p class="mb-1"><strong>Performed by:</strong> {{ $activity->causer->name ?? 'System' }}</p>
                                            <p class="mb-1"><strong>On:</strong> {{ class_basename($activity->subject_type) }} (ID: {{ $activity->subject_id }})</p>
                                            <p class="mb-0"><strong>At:</strong> {{ $activity->created_at->format('Y-m-d H:i:s') }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    
                        <div class="d-flex justify-content-center mt-4">
                            {{ $activities->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
