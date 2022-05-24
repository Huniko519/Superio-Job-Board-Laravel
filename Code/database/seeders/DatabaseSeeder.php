<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:clear');

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(Language::class);
        $this->call(MediaFileSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(General::class);
        $this->call(LocationSeeder::class);
        $this->call(News::class);
        $this->call(CandidateSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(CompaniesSeeder::class);
        $this->call(GigSeeder::class);
    }
}
