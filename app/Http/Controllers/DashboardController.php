<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title']='Dashboard';
        $user = Auth::user(); // Get the authenticated user

        if (!$user) {
            return redirect('/login')->with('error', 'You are not logged in.');
        }

        // Redirect users based on user type
        if ($user->user_type == 'admin') {
            return view('admin.dashboard');
        } elseif ($user->user_type == 'student') {
            return view('student.dashboard');
        } else {
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized user type.');
        }
    }
}
