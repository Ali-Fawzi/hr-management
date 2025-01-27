<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeesDataTable;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use App\Notifications\NewEmployeeCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreEmployeeRequest $request)
    {
        $validatedData = $request->validated();
        $filePaths = [];

        try {
            DB::beginTransaction();

            $fileHandlingConfig = [
                'driving_license_path' => 'driving_licenses',
                'background_check_path' => 'background_checks',
                'photo_path' => 'photos',
            ];

            foreach ($fileHandlingConfig as $field => $directory) {
                if ($request->hasFile($field)) {
                    $path = $request->file($field)->store($directory, 'public');
                    $validatedData[$field] = $path;
                    $filePaths[] = $path;
                }
            }

            $employee = Employee::create($validatedData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            foreach ($filePaths as $path) {
                Storage::disk('public')->delete($path);
            }

            return redirect()->back()
                ->with('error', __('Employee creation failed. Please try again.'))
                ->withInput();
        }

        try {
            Notification::send(
                User::supervisors()->get(),
                new NewEmployeeCreated($employee)
            );
        } catch (\Exception $e) {
            Log::error('Failed to send notifications: '.$e->getMessage());
        }

        return redirect()->route('employees.index')
            ->with('success', __('Employee created successfully.'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $validatedData = $request->validated();
        $newFilePaths = [];
        $oldFiles = [];

        try {
            DB::beginTransaction();

            $fileConfig = [
                'driving_license_path' => [
                    'disk' => 'public',
                    'directory' => 'driving_licenses',
                ],
                'background_check_path' => [
                    'disk' => 'public',
                    'directory' => 'background_checks',
                ],
                'photo_path' => [
                    'disk' => 'public',
                    'directory' => 'photos',
                    'is_image' => true,
                ],
            ];

            foreach ($fileConfig as $field => $config) {
                if ($request->hasFile($field)) {
                    $path = $request->file($field)->store(
                        $config['directory'],
                        $config['disk']
                    );

                    $oldFiles[$field] = $employee->$field;
                    $newFilePaths[] = $path;
                    $validatedData[$field] = $path;
                }
            }

            $employee->update($validatedData);

            foreach ($oldFiles as $field => $path) {
                if ($path) {
                    Storage::disk($fileConfig[$field]['disk'])->delete($path);
                }
            }

            DB::commit();

            return redirect()->route('employees.index')
                ->with('success', __('Employee updated successfully.'));

        } catch (\Exception $e) {
            DB::rollBack();

            foreach ($newFilePaths as $path) {
                Storage::disk('public')->delete($path);
            }

            return redirect()->back()
                ->with('error', __('Employee update failed. Please try again.'))
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $fileConfig = [
            'driving_license_path' => ['disk' => 'public'],
            'background_check_path' => ['disk' => 'public'],
            'photo_path' => ['disk' => 'public'],
        ];

        try {
            DB::beginTransaction();

            $filesToDelete = [];
            foreach ($fileConfig as $field => $config) {
                if ($employee->$field) {
                    $filesToDelete[] = [
                        'path' => $employee->$field,
                        'disk' => $config['disk'],
                    ];
                }
            }

            $employee->delete();

            DB::commit();

            foreach ($filesToDelete as $file) {
                Storage::disk($file['disk'])->delete($file['path']);
            }

            return redirect()->route('employees.index')
                ->with('success', __('Employee deleted successfully.'));

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', __('Employee deletion failed. Please try again.'));
        }
    }

    public function approve(Employee $employee)
    {
        if (! auth()->user()->can('employee-approve-reject')) {
            abort(403, 'Unauthorized action.');
        }

        if ($employee->status === 'submitted') {
            $employee->update(['status' => 'approved']);
        }

        return redirect()->back()->with('success', 'Employee approved successfully.');
    }

    public function reject(Employee $employee)
    {
        if (! auth()->user()->can('employee-approve-reject')) {
            abort(403, 'Unauthorized action.');
        }

        if ($employee->status === 'submitted') {
            $employee->update(['status' => 'rejected']);
        }

        return redirect()->back()->with('success', 'Employee rejected successfully.');
    }
}
