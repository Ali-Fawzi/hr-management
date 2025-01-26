<div>
    <h2>{{ $employee->first_name }} {{ $employee->last_name }}</h2>
    <p>Date of Birth: {{ $employee->date_of_birth }}</p>
    <p>Gender: {{ $employee->gender }}</p>
    <p>Hire Date: {{ $employee->hire_date }}</p>
    <p>Department: {{ $employee->department->name }}</p>
    <p>Position: {{ $employee->position->title }}</p>
    <p>Salary: {{ $employee->salary }}</p>

    @if ($employee->driving_license_path)
        <p>Driving License: <a href="{{ Storage::url($employee->driving_license_path) }}" target="_blank">View</a></p>
    @endif

    @if ($employee->background_check_path)
        <p>Background Check: <a href="{{ Storage::url($employee->background_check_path) }}" target="_blank">View</a></p>
    @endif

    @if ($employee->other_documents_path)
        <p>Other Documents: <a href="{{ Storage::url($employee->other_documents_path) }}" target="_blank">View</a></p>
    @endif

    @if ($employee->photo_path)
        <img src="{{ Storage::url($employee->photo_path) }}" alt="Employee Photo" style="max-width: 200px;">
    @endif
</div>