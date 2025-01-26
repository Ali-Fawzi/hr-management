<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New role creation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-start mb-4">
                        <a class="btn" href="{{ route('roles.index') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </div>
                    <section class="sm:max-w-md mx-auto">
                        <!-- Form Title -->
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Create a new role
                        </h1>

                        <form method="POST" action="{{ route('roles.store') }}" class="space-y-4 md:space-y-6">
                            @csrf

                            <!-- Role Name -->
                            <div>
                                <x-input-label for="name" :value="__('Role Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Permissions -->
                            <div>
                                <label for="permissions" class="block text-sm font-medium text-gray-700">Permissions</label>
                                <div class="mt-2 space-y-2 flex flex-col">
                                    @foreach($permissions as $permission)
                                    <label>
                                        <input type="checkbox" name="permission[{{$permission->id}}]" value="{{$permission->id}}" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                                    {{ $permission->name }}
                                    </label>
                                    @endforeach
                                    <x-input-error :messages="$errors->get('permission')" class="mt-2" />
                                </div>
                            </div>
                            <x-primary-button>
                                {{ __('Create role') }}
                            </x-primary-button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
