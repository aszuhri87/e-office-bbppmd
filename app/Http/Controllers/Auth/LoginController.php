<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username()
    {
        return 'username';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user_dt = $user->with('roles')->where('username', $request->username)->first();
        if ($user->hasRole('admin') || $user->hasRole('superadmin')) {
            Alert::toast('Selamat Datang, '.$user_dt->name.'!', 'success');

            return redirect('admin/dashboard');
        } elseif ($user->hasRole('chief')) {
            Alert::toast('Selamat Datang, '.$user_dt->name.'!', 'success');

            return redirect('chief/dashboard');
        } elseif ($user->hasRole('chief_of_division') || $user->hasRole('chief_of_sub_division') || $user->hasRole('coordinator') || $user->hasRole('personil')) {
            Alert::toast('Selamat Datang, '.$user_dt->name.'!', 'success');

            return redirect('chief_div/dashboard');
        } else {
            Alert::error('Gagal', 'Email atau password salah!');

            return redirect()->route('login')
                ->with('error', 'Email-Address And Password Are Wrong.');
        }
    }
}
