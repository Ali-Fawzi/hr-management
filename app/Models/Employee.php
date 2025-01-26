<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

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