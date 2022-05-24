<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\User\Helpers\PermissionHelper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = \Modules\User\Models\Role::firstOrCreate([
            'code'=>'administrator',
            'name'=>__('Administrator')
        ]);

        $admin->givePermission(PermissionHelper::all());


        $employer = \Modules\User\Models\Role::firstOrCreate([
            'code'=>'employer',
            'name'=>__('Employer')
        ]);

        $candidate = \Modules\User\Models\Role::firstOrCreate([
            'code'=>'candidate',
            'name'=>__('Candidate')
        ]);

        $employer->givePermission(['job_manage','employer_manage','media_upload']);
        $candidate->givePermission(['candidate_manage','media_upload','gig_manage']);
    }
}
