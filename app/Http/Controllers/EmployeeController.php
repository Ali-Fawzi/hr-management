<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeesDataTable;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use App\Models\Department;
use App\Models\Position;

class EmployeeController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(EmployeesDataTable $dataTable)
    {
        return $dataTable->render('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create', [
            'departments' => Department::all(),
            'positions' => Position::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Other',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:department,department_id',
            'position_id' => 'required|exists:position,position_id',
            'salary' => 'required|numeric|min:0',
            'driving_license_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'background_check_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'other_documents_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'photo_path' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);
    
        // Handle file uploads
        if ($request->hasFile('driving_license_path')) {
            $validatedData['driving_license_path'] = $request->file('driving_license_path')->store('driving_licenses', 'public');
        }
    
        if ($request->hasFile('background_check_path')) {
            $validatedData['background_check_path'] = $request->file('background_check_path')->store('background_checks', 'public');
        }
    
        if ($request->hasFile('other_documents_path')) {
            $validatedData['other_documents_path'] = $request->file('other_documents_path')->store('other_documents', 'public');
        }
    
        if ($request->hasFile('photo_path')) {
            $validatedData['photo_path'] = $request->file('photo_path')->store('photos', 'public');
        }
    
        Employee::create($validatedData);
    
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);

        return view('employees.show', compact('employee'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        $departments = Department::all();
        $positions = Position::all();

        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:department,department_id',
            'position_id' => 'required|exists:position,position_id',
            'salary' => 'required|numeric',
            'driving_license_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'background_check_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'other_documents_path' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'photo_path' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->first_name = $request->input('first_name');
        $employee->last_name = $request->input('last_name');
        $employee->date_of_birth = $request->input('date_of_birth');
        $employee->gender = $request->input('gender');
        $employee->hire_date = $request->input('hire_date');
        $employee->department_id = $request->input('department_id');
        $employee->position_id = $request->input('position_id');
        $employee->salary = $request->input('salary');

        if ($request->hasFile('driving_license_path')) {
            if ($employee->driving_license_path) {
                Storage::delete($employee->driving_license_path);
            }
            $employee->driving_license_path = $request->file('driving_license_path')->store('driving_licenses');
        }

        if ($request->hasFile('background_check_path')) {
            if ($employee->background_check_path) {
                Storage::delete($employee->background_check_path);
            }
            $employee->background_check_path = $request->file('background_check_path')->store('background_checks');
        }

        if ($request->hasFile('other_documents_path')) {
            if ($employee->other_documents_path) {
                Storage::delete($employee->other_documents_path);
            }
            $employee->other_documents_path = $request->file('other_documents_path')->store('other_documents');
        }

        if ($request->hasFile('photo_path')) {
            if ($employee->photo_path) {
                Storage::delete($employee->photo_path);
            }
            $employee->photo_path = $request->file('photo_path')->store('photos');
        }

        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->driving_license_path) {
            Storage::delete($employee->driving_license_path);
        }
        if ($employee->background_check_path) {
            Storage::delete($employee->background_check_path);
        }
        if ($employee->other_documents_path) {
            Storage::delete($employee->other_documents_path);
        }
        if ($employee->photo_path) {
            Storage::delete($employee->photo_path);
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}