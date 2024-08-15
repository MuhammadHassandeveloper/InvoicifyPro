<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\User;
use Exception;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Toastr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\Notification;
use Illuminate\Support\Facades\Password;
use response;


class AuthController extends Controller
{

    public function index(){
        if (Sentinel::check()) {
            $user = Sentinel::getUser();
            if ($user->inRole('admin')) {
                return redirect('/admin/dashboard');
            } elseif ($user->inRole('customer')) {
                return redirect('/customer/dashboard');
             } elseif ($user->inRole('accountant')) {
                return redirect('/accountant/dashboard');
            }
        }
        $data = [];
        $data['title'] = "Login";
        return view('index',$data);
    }


    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        try {
            $user = Sentinel::authenticate($credentials);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->back()->withErrors($message)->withInput();
        }

        if ($user) {
            if ($user->inRole('admin')) {
                return redirect('/admin/dashboard');
            } elseif ($user->inRole('customer')) {
                return redirect('/customer/dashboard');
            }elseif ($user->inRole('accountant')) {
                return redirect('/accountant/dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }


    public function logout(Request $request)
    {
        Sentinel::logout();
        Auth::logout();

        return redirect(route('login.form'));
    }
}
