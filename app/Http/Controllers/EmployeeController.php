<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:department,department_id',
            'position_id' => 'required|exists:position,position_id',
            'salary' => 'required|numeric',
            'driving_license' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'background_check' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'other_documents' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->date_of_birth = $request->date_of_birth;
        $employee->gender = $request->gender;
        $employee->hire_date = $request->hire_date;
        $employee->department_id = $request->department_id;
        $employee->position_id = $request->position_id;
        $employee->salary = $request->salary;

        // Handle file uploads
        if ($request->hasFile('driving_license')) {
            $employee->driving_license_path = $request->file('driving_license')->store('documents/driving_licenses', 'public');
        }

        if ($request->hasFile('background_check')) {
            $employee->background_check_path = $request->file('background_check')->store('documents/background_checks', 'public');
        }

        if ($request->hasFile('other_documents')) {
            $employee->other_documents_path = $request->file('other_documents')->store('documents/other_documents', 'public');
        }

        if ($request->hasFile('photo')) {
            $employee->photo_path = $request->file('photo')->store('photos', 'public');
        }

        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}