<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'chief_of_division',
                'guard_name' => 'admin',
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'chief_of_sub_division',
                'guard_name' => 'admin',
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'admin',
                'guard_name' => 'admin',
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'coordinator',
                'guard_name' => 'admin',
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'superadmin',
                'guard_name' => 'admin',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
