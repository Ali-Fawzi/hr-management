<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Updating Employee Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <a class="btn" href="{{ route('employees.index') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        <form action="{{route('employees.destroy', $employee->employee_id)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure you want to delete this employee?')">
                                <i class="bi bi-trash-fill text-danger"></i>
                            </button>
                        </form>
                    </div>
                    <section>
                        <!-- Form Title -->
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Update Employee Information
                        </h1>

                        <form method="POST" action="{{ route('employees.update', $employee->employee_id) }}" class="grid-cols-1 md:grid-cols-2 gap-4 grid" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $employee->first_name)" required autofocus autocomplete="first_name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                        
                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $employee->last_name)" required autocomplete="last_name" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                        
                            <!-- Date of Birth -->
                            <div>
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth', $employee->date_of_birth)" required />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>
                        
                            <!-- Gender -->
                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>
                        
                            <!-- Department -->
                            <div>
                                <x-input-label for="department_id" :value="__('Department')" />
                                <select id="department_id" name="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->department_id }}" {{ old('department_id', $employee->department_id) == $department->department_id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                            </div>
                        
                            <!-- Position -->
                            <div>
                                <x-input-label for="position_id" :value="__('Position')" />
                                <select id="position_id" name="position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                    <option value="">Select Position</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->position_id }}" {{ old('position_id', $employee->position_id) == $position->position_id ? 'selected' : '' }}>{{ $position->title }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('position_id')" class="mt-2" />
                            </div>
                        
                            <!-- Salary -->
                            <div>
                                <x-input-label for="salary" :value="__('Salary in IQD')" />
                                <x-text-input id="salary" class="block mt-1 w-full" type="number" name="salary" :value="old('salary', $employee->salary)" required />
                                <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                            </div>
                        
                            <!-- Driving License -->
                            <div>
                                <x-input-label for="driving_license_path" :value="__('Driving License')" />
                                <x-text-input id="driving_license_path" class="block mt-1 w-full" type="file" name="driving_license_path" />
                                <x-input-error :messages="$errors->get('driving_license_path')" class="mt-2" />
                            </div>
                        
                            <!-- Background Check -->
                            <div>
                                <x-input-label for="background_check_path" :value="__('Background Check')" />
                                <x-text-input id="background_check_path" class="block mt-1 w-full" type="file" name="background_check_path" />
                                <x-input-error :messages="$errors->get('background_check_path')" class="mt-2" />
                            </div>
                        
                            <!-- Photo -->
                            <div>
                                <x-input-label for="photo_path" :value="__('Photo')" />
                                <x-text-input id="photo_path" class="block mt-1 w-full" type="file" name="photo_path" />
                                <x-input-error :messages="$errors->get('photo_path')" class="mt-2" />
                            </div>
                        
                            <!-- Submit Button -->
                            <div class="md:col-span-2 mx-auto">
                                <x-primary-button>
                                    {{ __('Update Employee') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>