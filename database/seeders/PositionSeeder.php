<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'title' => 'Software Engineer',
            'description' => 'Develops software solutions by studying information needs, conferring with users, and studying systems flow, data usage, and work processes.',
        ]);
    }
}
