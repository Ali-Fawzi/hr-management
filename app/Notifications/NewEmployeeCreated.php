<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewEmployeeCreated extends Notification
{
    use Queueable;

    protected $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A new employee has been created: '.$this->employee->name,
            'employee_id' => $this->employee->id,
            'link' => '/employees/'.$this->employee->id,
        ];
    }
}
