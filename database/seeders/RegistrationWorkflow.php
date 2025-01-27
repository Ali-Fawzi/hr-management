<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use RingleSoft\LaravelProcessApproval\Enums\ApprovalTypeEnum;

class RegistrationWorkflow extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Employee::makeApprovable([
            [
                'role_id' => 1,
                'action' => ApprovalTypeEnum::APPROVE->value,
            ],
            [
                'role_id' => 1,
                'action' => ApprovalTypeEnum::CHECK->value,
            ],
            [
                'role_id' => 2,
                'action' => ApprovalTypeEnum::CHECK->value,
            ],
        ]);
    }
}
