<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $user = User::with('roles')->where('id', Auth::id())->first();

        // if ($user->hasRole('admin')) {
        //     Alert::toast('Selamat Datang, '.$user->name.'!', 'success');

        //     return redirect('admin/dashboard');
        // } elseif ($user->hasRole('chief')) {
        //     Alert::toast('Selamat Datang, '.$user->name.'!', 'success');

        //     return redirect('chief/dashboard');
        // } elseif ($user->hasRole('chief_of_division') || $user->hasRole('chief_of_sub_division') || $user->hasRole('coordinator') || $user->hasRole('personil')) {
        //     Alert::toast('Selamat Datang, '.$user->name.'!', 'success');

        //     return redirect('chief_div/dashboard');
        // }

        if (Auth::check() == true) {
            $user = User::with('roles')->where('id', Auth::id())->first();

            if ($user->hasRole('admin') || $user->hasRole('superadmin')) {
                Alert::toast('Selamat Datang, '.$user->name.'!', 'success');

                return redirect('admin/dashboard');
            } elseif ($user->hasRole('chief')) {
                Alert::toast('Selamat Datang, '.$user->name.'!', 'success');

                return redirect('chief/dashboard');
            } elseif ($user->hasRole('chief_of_division') || $user->hasRole('chief_of_sub_division') || $user->hasRole('coordinator') || $user->hasRole('personil')) {
                Alert::toast('Selamat Datang, '.$user->name.'!', 'success');

                return redirect('chief_div/dashboard');
            }
        } else {
            Alert::toast('Akun tidak dikenali!', 'error');

            return redirect()->back();
        }
    }

    public function welcome()
    {
        return view('welcome');
    }
}
