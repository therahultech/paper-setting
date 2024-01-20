<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $user = User::create([
        //     'name' => 'Rahul Kumar', 
        //     'email' => 'therahultech@gmail.com',
        //     'password' => Hash::make('rks@rahul')
        // ]);
    
        // $role = Role::create(['name' => 'Super_Admin']);
        $user = User::where('email','=','therahultech@gmail.com')->first();
        $role = Role::where('name','=','Super_Admin')->first();
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}
