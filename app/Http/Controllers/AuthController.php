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
   // Handle login request
   public function Authlogin(Request $request)
   {
       // Convert email to lowercase
       $email = strtolower($request->email);
   
       // Validate the request
       $request->validate([
           'email' => 'required|email|exists:users,email',
           'password' => 'required|min:6',
       ], [
           'email.required' => 'Email is required.',
           'email.email' => 'Please enter a valid email address.',
           'email.exists' => 'No account found with this email.',
           'password.required' => 'Password is required.',
           'password.min' => 'Password must be at least 6 characters long.',
       ]);
   
       $remember = !empty($request->remember);
   
       // Attempt authentication with lowercase email
       if (Auth::attempt(['email' => $email, 'password' => $request->password], $remember)) {
           $user = Auth::user();
   
           if ($user->user_type == 'admin') {
               return redirect('admin/dashboard');
           } elseif ($user->user_type == 'student') {
               return redirect('student/dashboard');
           } else {
               Auth::logout();
               return redirect()->back()->with('error', 'Unauthorized user type.');
           }
       } else {
           return redirect()->back()->with('error', 'Invalid email or password.');
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
