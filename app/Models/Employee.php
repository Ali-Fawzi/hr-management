<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use RingleSoft\LaravelProcessApproval\Contracts\ApprovableModel;
use RingleSoft\LaravelProcessApproval\Models\ProcessApproval;
use RingleSoft\LaravelProcessApproval\Traits\Approvable;

class Employee extends Model implements ApprovableModel
{
    use Approvable;

    public function onApprovalCompleted(ProcessApproval $approval): bool
    {
        if ($this->approvalStatus->current_step === 'Supervisor') {
            $this->status = 'Approved';
            return true;
        }
        return false;
    }

    protected $table = 'employee';

    public bool $autoSubmit = false;

    protected $primaryKey = 'employee_id';

    public $incrementing = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'hire_date',
        'department_id',
        'position_id',
        'salary',
        'driving_license_path',
        'background_check_path',
        'other_documents_path',
        'photo_path',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($employee) {
            if ($employee->driving_license_path) {
                Storage::disk('public')->delete($employee->driving_license_path);
            }
            if ($employee->background_check_path) {
                Storage::disk('public')->delete($employee->background_check_path);
            }
            if ($employee->other_documents_path) {
                Storage::disk('public')->delete($employee->other_documents_path);
            }
            if ($employee->photo_path) {
                Storage::disk('public')->delete($employee->photo_path);
            }
        });
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'position_id');
    }
}
