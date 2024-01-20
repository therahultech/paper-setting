<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateTeacherUserSeeder extends Seeder
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
        $user = User::where('email','=','teacher1@mail.com')->first();
        $role = Role::where('name','=','Teacher')->first();
     
        // $permissions = Permission::pluck('id','id')->all();
        $permissions = Permission::where('name', 'like', 'paper_Upload%')->pluck('id','id');

   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}
