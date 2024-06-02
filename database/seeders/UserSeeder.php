<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 1000,
            'name' => 'admin',
            'api_token' => '*12345678*',
            'is_admin' => 1,
        ]);
    }
}
