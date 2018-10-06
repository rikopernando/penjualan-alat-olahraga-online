<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Create Role
       $role_owner = new Role();
       $role_owner->name = "owner";
       $role_owner->display_name = "Owner";
       $role_owner->save();

       // Create Role
       $role_admin = new Role();
       $role_admin->name = "admin";
       $role_admin->display_name = "Admin";
       $role_admin->save();

       $role_member = new Role();
       $role_member->name = "member";
       $role_member->display_name = "Member";
       $role_member->save();

      // Create User
       $owner = new User(); 
       $owner->name = "Owner";
       $owner->email = "owner@gmail.com";
       $owner->password = bcrypt('rahasia');
       $owner->save();
       $owner->attachRole($role_owner);

      // Create User
       $admin = new User(); 
       $admin->name = "Admin";
       $admin->email = "admin@gmail.com";
       $admin->password = bcrypt('rahasia');
       $admin->save();
       $admin->attachRole($role_admin);

      // Create User
       $member = new User(); 
       $member->name = "Member";
       $member->email = "member@gmail.com";
       $member->password = bcrypt('rahasia');
       $member->save();
       $member->attachRole($role_member);
    }
}
