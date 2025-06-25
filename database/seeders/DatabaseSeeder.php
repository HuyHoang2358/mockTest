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
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => "Quản trị viên",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456789'),
            ]
        );
        $admin->profile()->updateOrCreate(
            ['admin_id' => $admin->id],
            [
                'avatar' => 'https://ui-avatars.com/api/?name=Admin&background=random&color=fff',
                'phone' => '0123456789',
                'address' => 'Hà Nội',
                'birthday' => '2000-01-01',
            ]
        );
        /*$this->call(FolderSeeder::class);
        $this->call(QuestionTypeSeeder::class);*/
        $this->call(AdminSeeder::class);
    }
}
