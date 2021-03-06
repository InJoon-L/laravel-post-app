<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('github')->stateless()->user();

        // DB에 사용자 정보를 저장한다.
        // 이미 이 사용자 정보가 DB에 저장되어 있다면
        // 저장할 필요가 없다.
        User::firstOrCreate(
            ['email' => $user->getEmail()],
            [
                'password' => Hash::make(Str::random(24)),
                'name' => $user->getName()
            ]
        );

        // 로그인 처리..
        Auth::login($user);

        // view를 반환
        return redirect()->intended('/dashboard');
    }
}
