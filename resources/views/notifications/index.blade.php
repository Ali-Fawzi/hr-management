<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto px-6 py-8">
                        <div class="bg-white rounded-lg p-6">
                            @forelse($notifications as $notification)
                                <div class="p-4 border-b border-gray-200 hover:bg-gray-50">
                                    <p class="text-sm text-gray-600">{{ $notification->data['message'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-600">No notifications found.</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
