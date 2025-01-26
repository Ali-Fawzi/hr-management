<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adding new user to the system') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-start mb-4">
                        <a class="btn" href="{{ route('users.index') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </div>
                    <section class="sm:max-w-md mx-auto">
                        <!-- Form Title -->
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Add new user
                        </h1>

                        <form method="POST" action="{{ route('users.store') }}" class="space-y-4 md:space-y-6">
                            @csrf
                             <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Your name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Your email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="confirm-password" :value="__('Confirm Password')" />

                            <x-text-input id="confirm-password" class="block mt-1 w-full"
                                            type="password"
                                            name="confirm-password" required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('confirm-password')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div>
                            <x-input-label for="roles" :value="__('Select a role')" />
                            <select id="roles" name="roles" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                        </div>

                            <x-primary-button>
                                {{ __('Add user') }}
                            </x-primary-button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Other fields for employee details -->

    <div class="form-group">
        <label for="driving_license">Driving License</label>
        <input type="file" class="form-control" id="driving_license" name="driving_license">
    </div>

    <div class="form-group">
        <label for="background_check">Background Check Report</label>
        <input type="file" class="form-control" id="background_check" name="background_check">
    </div>

    <div class="form-group">
        <label for="other_documents">Other Documents</label>
        <input type="file" class="form-control" id="other_documents" name="other_documents">
    </div>

    <div class="form-group">
        <label for="photo">Employee Photo</label>
        <input type="file" class="form-control" id="photo" name="photo">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form> --}}