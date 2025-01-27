<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Position extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'position';

    protected $primaryKey = 'position_id';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id', 'position_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "Position {$eventName}");
    }
}
