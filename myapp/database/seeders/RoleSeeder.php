<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Platform administrator'],
            ['name' => 'Instructor', 'slug' => 'instructor', 'description' => 'Course creator and instructor'],
            ['name' => 'Student', 'slug' => 'student', 'description' => 'Course learner'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
