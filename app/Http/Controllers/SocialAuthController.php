<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Auth\Guard;

class SocialAuthController extends Controller
{
    protected $socialite;
    protected $auth;
    private $request;

    public function __construct(Socialite $socialite, Guard $auth, Request $request)
    {
        $this->socialite = $socialite;
        $this->auth = $auth;
        $this->request = $request;
    }

    public function facebookLogin()
    {
        if (! $this->request->has('code')) {
            return $this->socialite->driver('facebook')->scopes(['email'])->redirect();
        }

        $userData = $this->socialite->driver('facebook')->fields([
            'first_name', 'last_name', 'email'
        ])->user();

        if($this->request->has('state')) {
            $state = $this->request->get('state');
            $this->request->session()->put('state',$state);
        }

        $email = $userData->email ?? $userData->user->email;

        $username =  $userData->name ?? $userData->user['first_name'] . $userData->user['last_name'];

        $user = User::updateOrCreate(
            ['provider_id' => $userData->id],
            ['provider_id' => $userData->id, 'name' => $username, 'email' => $email, 'image' => $userData->avatar]
        );

        $this->auth->login($user, true);

        return redirect()->intended('/');
    }

    public function logout()
    {
        $this->auth->logout();

        $this->request->session()->flush();

        $this->request->session()->regenerate();

        return redirect('/');
    }
}
