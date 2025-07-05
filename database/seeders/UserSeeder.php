<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = User::updateOrCreate(
                [ 'email' => 'user' . $i . '@gmail.com',],
                [
                    'name' => 'Học sinh ' . $i,
                    'email' => 'user' . $i . '@gmail.com',
                    'password' => Hash::make('123456789'), // Hoặc bcrypt('password123')
                ]);
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'avatar' => 'https://ui-avatars.com/api/?name=Admin+' . $i . '&background=random&color=fff',
                    'phone' => '',
                    'address' => '',

                ]
            );
        }
    }
}
