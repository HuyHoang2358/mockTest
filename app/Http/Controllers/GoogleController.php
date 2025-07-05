<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            DB::beginTransaction();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt('default_password'), // placeholder
                    'google_id' => $googleUser->getId(),
                ]
            );

            // Kiểm tra và tạo profile nếu chưa có
            if (!$user->profile) {
                $user->profile()->create([
                    'phone' => null,
                    'address' => null,
                    'birthday' => null,
                    'avatar' => null,
                ]);
            }

            DB::commit();

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('login')->withErrors('Lỗi khi đăng nhập bằng Google: ' . $e->getMessage());
        }
    }
}
