<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ForgetEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the login page
    public function login()
    {
        if (Auth::check()) {
            return redirect('admin/dashboard');
        }
        return view('auth.login');
    }

    // Handle login request
    public function Authlogin(Request $request)
    {
        if (!empty($request->email) && !empty($request->password)) {
            $remember = !empty($request->remember) ? true : false;

            // Attempt authentication
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
                $user = Auth::user(); // Get authenticated user

                if ($user->user_type == 'admin') {
                    return redirect('admin/dashboard');
                } elseif ($user->user_type == 'student') {
                    return redirect('student/dashboard');
                }  else {
                    Auth::logout(); // Logout if user type is invalid
                    return redirect()->back()->with('error', 'Unauthorized user type.');
                }
            } else {
                // If authentication fails
                return redirect()->back()->with('error', 'Invalid email or password.');
            }
        } else {
            return redirect()->back()->with('error', 'Email and password are required.');
        }
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return view('auth.login');
    }

    // Show forget password page
    public function forget()
    {
        return view('auth.forget');
    }

    

    
    
    public function list(){
        return view('admin/admin/list');
    }
}
