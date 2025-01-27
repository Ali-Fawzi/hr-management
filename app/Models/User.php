<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public function getCreatedAtAttribute($value): string
    {
        if ($value instanceof Carbon) {
            return $value->format(self::DATE_FORMAT);
        }

        return Carbon::parse($value)->format(self::DATE_FORMAT);
    }

    public function getUpdatedAtAttribute($value): string
    {
        if ($value instanceof Carbon) {
            return $value->format(self::DATE_FORMAT);
        }

        return Carbon::parse($value)->format(self::DATE_FORMAT);
    }
   public function getActivitylogOptions(): LogOptions
   {
       return LogOptions::defaults()
           ->logOnly(['name', 'email', 'password'])
           ->logOnlyDirty()
           ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}");
   }
    public function scopeSupervisors($query)
    {
        return $query->role('Supervisor');
    }
}
