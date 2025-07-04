<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $admin = Admin::updateOrCreate(
                [ 'email' => 'admin' . $i . '@example.com',],
                [
                    'name' => 'Giáo viên ' . $i,
                    'email' => 'admin' . $i . '@example.com',
                    'password' => Hash::make('password123'), // Hoặc bcrypt('password123')
            ]);
            $admin->profile()->updateOrCreate(
                ['admin_id' => $admin->id],
                [
                    'avatar' => 'https://ui-avatars.com/api/?name=Admin+' . $i . '&background=random&color=fff',
                    'phone' => '0123456789',
                    'address' => 'Hà Nội',
                    'birthday' => '2000-01-01',
                ]
            );
        }
    }
}
