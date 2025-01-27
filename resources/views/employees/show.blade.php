<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-500"
                        >{{ __(session('success')) }}</p>
                    @elseif (session('error'))
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-red-500"
                        >{{ __(session('error')) }}</p>
                    @endif
                    <div class="flex justify-between mb-4">
                        <a class="btn" href="{{ route('employees.index') }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                        @can('employee-approve-reject')
                            @if($employee->status === 'submitted')
                                <div>
                                    <form action="{{ route('employees.approve', $employee->employee_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to approve this employee?')">
                                            <i class="bi bi-check-circle-fill"></i> Approve
                                        </button>
                                    </form>
    
                                    <form action="{{ route('employees.reject', $employee->employee_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to reject this employee?')">
                                            <i class="bi bi-x-circle-fill"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @elsecan('employee-edit')
                        @if($employee->status === 'submitted')
                            <a class="btn" href="{{ route('employees.edit', $employee->employee_id) }}">
                                <i class="bi bi-pencil-fill text-primary"></i> 
                            </a>
                        @endif
                        @endcan
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $employee->first_name }}</p>
                        </div>
            
                        <!-- Last Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $employee->last_name }}</p>
                        </div>
            
                        <!-- Date of Birth -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $employee->date_of_birth }}</p>
                        </div>
            
                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gender</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $employee->gender }}</p>
                        </div>
            
                        <!-- Hire Date -->
                        @if ($employee->hire_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Hire Date</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $employee->hire_date }}</p>
                            </div>
                        @endif

                        <!-- Submit Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Submit Date</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $employee->created_at }}</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="m-1 font-medium me-2 px-2.5 py-1 rounded-sm 
                                @if($employee->status === 'submitted') bg-yellow-100 text-yellow-800 
                                @elseif($employee->status === 'approved') bg-green-100 text-green-800 
                                @elseif($employee->status === 'rejected') bg-red-100 text-red-800 
                                @endif">
                                    {{ $employee->status }}
                            </span>
                        </div>

                        <!-- Department -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Department</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $employee->department->name ?? 'N/A' }}</p>
                        </div>
            
                        <!-- Position -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Position</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $employee->position->title ?? 'N/A' }}</p>
                        </div>
            
                        <!-- Salary -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Salary</label>
                            <p class="mt-1 text-lg text-gray-900">IQD{{ number_format($employee->salary, 2) }}</p>
                        </div>
                    </div>
            
                    <!-- File Uploads Section -->
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Uploaded Files</h2>
            
                        <!-- Driving License -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Driving License</label>
                            @if ($employee->driving_license_path)
                                <a href="{{ Storage::url($employee->driving_license_path) }}" target="_blank" class="text-blue-500 hover:underline">View File</a>
                            @else
                                <p class="text-gray-500">No file uploaded</p>
                            @endif
                        </div>
            
                        <!-- Background Check -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Background Check</label>
                            @if ($employee->background_check_path)
                                <a href="{{ Storage::url($employee->background_check_path) }}" target="_blank" class="text-blue-500 hover:underline">View File</a>
                            @else
                                <p class="text-gray-500">No file uploaded</p>
                            @endif
                        </div>
            
                        <!-- Photo -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Photo</label>
                            @if ($employee->photo_path)
                                <img src="{{ Storage::url($employee->photo_path) }}" alt="Employee Photo" class="mt-2 w-32 h-32 object-cover rounded-lg">
                            @else
                                <p class="text-gray-500">No photo uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
