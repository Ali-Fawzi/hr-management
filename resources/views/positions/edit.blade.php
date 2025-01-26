<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update an existing position to the system') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-start mb-4">
                        <a class="btn" href="{{ route('positions.index') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </div>
                    <section class="sm:max-w-md mx-auto">
                        <!-- Form Title -->
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Update position
                        </h1>

                        <form 
                            method="POST" 
                            action="{{ route('positions.update', $position->position_id) }}" 
                            class="space-y-4 md:space-y-6"
                        >
                            @csrf
                            @method('PUT')
                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Job title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$position->title" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- description Address -->
                        <div>
                            <x-input-label for="description" :value="__('Job description')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="$position->description" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                            <x-primary-button>
                                {{ __('Update position') }}
                            </x-primary-button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
