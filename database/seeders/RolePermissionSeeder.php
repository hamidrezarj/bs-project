<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // tickets
        Permission::create([
            'name' => 'create_ticket'
        ]);

        Permission::create([
            'name' => 'show_ticket'
        ]);

        Permission::create([
            'name' => 'update_ticket'
        ]);

        Permission::create([
            'name' => 'delete_ticket'
        ]);

        // ticket answers
        Permission::create([
            'name' => 'create_ticket_answer'
        ]);

        Permission::create([
            'name' => 'show_ticket_answer'
        ]);

        Permission::create([
            'name' => 'update_ticket_answer'
        ]);

        Permission::create([
            'name' => 'delete_ticket_answer'
        ]);

        // technical supports
        Permission::create([
            'name' => 'show_technical_supports'
        ]);

        Permission::create([
            'name' => 'update_technical_supports'
        ]);

        Permission::create([
            'name' => 'delete_technical_supports'
        ]);

        // user profile
        Permission::create([
            'name' => 'show_profile'
        ]);

        Permission::create([
            'name' => 'update_profile'
        ]);

        Permission::create([
            'name' => 'delete_profile'
        ]);

        $role_user = Role::create([
            'name' => 'user'
        ]);

        $role_user->givePermissionTo([
            'create_ticket', 
            'show_ticket', 
            'update_ticket', 
            'delete_ticket', 
            'show_profile', 
            'update_profile', 
            'delete_profile'
        ]);

        $role_ts = Role::create([
            'name' => 'technical_support'
        ]);

        $role_ts->givePermissionTo([
            'create_ticket_answer', 
            'show_ticket_answer', 
            'update_ticket_answer', 
            'delete_ticket_answer', 
            'show_profile', 
            'update_profile', 
            'delete_profile'
        ]);

        $role_admin = Role::create([
            'name' => 'admin'
        ]);

        $role_admin->givePermissionTo([
            'show_technical_supports',
            'show_profile', 
            'update_profile', 
            'delete_profile'
        ]);
    }
}
