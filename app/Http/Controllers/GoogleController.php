<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googlehandle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $findUser = User::where('email', $googleUser->email)->first();

            if (!$findUser) {
                $findUser = new User();
                $findUser->email = $googleUser->email;
                $findUser->fname = $googleUser->user['family_name'];
                $findUser->lname = $googleUser->user['given_name'];
                $findUser->password = bcrypt('your-default-password');
                $findUser->role_as = '0';

                $findUser->save();
            }
            Auth::login($findUser);
            return redirect('/')->with('status', 'Logged in successfully');
        } catch (Exception $e) {

        }
    }
}
