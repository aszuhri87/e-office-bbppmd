<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
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
                'name' => 'chief',
                'guard_name' => 'admin',
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'name' => 'personil',
                'guard_name' => 'admin',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
