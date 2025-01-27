<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

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
}
