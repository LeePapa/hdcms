<?php

use App\Models\Group;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PackageSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(SiteUserSeeder::class);
    }
}
