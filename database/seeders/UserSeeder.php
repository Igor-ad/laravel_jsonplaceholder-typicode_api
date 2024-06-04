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
            'id' => config('services.place_holder.admin_id'),
            'name' => 'admin',
            'api_token' => '*12345678*',
            'is_admin' => 1,
        ]);
    }
}
