<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update department') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-start mb-4">
                        <a class="btn" href="{{ route('departments.index') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </div>
                    <section class="sm:max-w-md mx-auto">
                        <!-- Form Title -->
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Update department
                        </h1>

                        <form 
                            method="POST" 
                            action="{{ route('departments.update', $department->department_id) }}" 
                            class="space-y-4 md:space-y-6"
                        >
                            @csrf
                            @method('PUT')
                        <!-- Name -->
                        <div>
                            <x-input-label for="Name" :value="__('Enter department name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$department->name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                            <x-primary-button>
                                {{ __('Update department') }}
                            </x-primary-button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
