<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Removing user account from the system') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <a class="btn" href="{{ route('users.index') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <button
                            class="btn btn-danger"
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        >
                            <i class="bi bi-trash"></i> Remove user
                        </button>
                    </div>
                    <section class="sm:max-w-md mx-auto">
                        <!-- Form Title -->
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Update user
                        </h1>

                        <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-4 md:space-y-6">
                            @csrf
                            @method('PUT')
                             <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Your name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Your email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Role -->
                            <div>
                                <x-input-label for="roles" :value="__('Select a role')" />
                                <select id="roles" name="roles" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                    <option value="">Select a role</option>
                                    @foreach($roles as $role)
                                        <option 
                                        value="{{ $role }}"
                                        {{ isset($userRole[$role]) ? 'selected' : ''}}
                                        >
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                            </div>

                            <x-primary-button>
                                {{ __('Update user') }}
                            </x-primary-button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('users.destroy', $user->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to remove this user?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once user account is removed, all of its resources and data will be permanently deleted. Please confirm that you would like to permanently remove this user account.') }}
            </p>


            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Remove User') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
