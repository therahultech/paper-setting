<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'department-list',
            'department-create',
            'department-edit',
            'department-delete',
            'course-list',
            'course-create',
            'course-edit',
            'course-delete',
            'subject-list',
            'subject-create',
            'subject-edit',
            'subject-delete',
            'paper-list',
            'paper-create',
            'paper-edit',
            'paper-delete',
            'teacher-list',
            'teacher-create',
            'teacher-edit',
            'teacher-delete',
            'paper_Allocation-list',
            'paper_Allocation-create',
            'paper_Allocation-edit',
            'paper_Allocation-delete',
            'paper_Upload-list',
            'paper_Upload-create',
            'paper_Upload-edit',
            'paper_Upload-delete',

         ];
      
         foreach ($permissions as $permission) {
            //   Permission::create(['name' => $permission]);
              Permission::firstOrCreate(['name' => $permission]);
         }
    }
}
