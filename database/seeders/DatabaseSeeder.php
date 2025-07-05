<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // $this->call(FolderSeeder::class);
        $this->call(QuestionTypeSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
    }
}
