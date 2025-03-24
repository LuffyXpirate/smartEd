<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentModel;
use App\Models\Marks;
use App\Models\Result;

class DashboardController extends Controller
{
    // Dashboard method for different user types
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';
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

    // // Method to show the result of a student
    // public function resultview()
    // {
    //     // Get authenticated student
    //     $student = Auth::user()->student;
    
    //     // Get marks with subject relationship
    //     $marks = Marks::where('student_id', $student->id)
    //                 ->with('subject')
    //                 ->get();
    
    //     // Calculate totals
    //     $total_marks_obtained = $marks->sum('total_marks');
    //     $total_possible_marks = $marks->count() * 100; // Assuming max 100 per subject
    //     $percentage = $total_possible_marks > 0 
    //         ? round(($total_marks_obtained / $total_possible_marks) * 100, 2)
    //         : 0;
    
    //     // Determine grade and status
    //     $overall_grade = $this->calculateGrade($percentage);
    //     $result_status = $percentage >= 40 ? 'Pass' : 'Fail';
    
    //     return view('result.result', compact(
    //         'student',
    //         'marks',
    //         'total_marks_obtained',
    //         'percentage',
    //         'overall_grade',
    //         'result_status'
    //     ));
    // }
    
    // private function calculateGrade($percentage)
    // {
    //     if ($percentage >= 90) return 'A+';
    //     if ($percentage >= 80) return 'A';
    //     if ($percentage >= 70) return 'B';
    //     if ($percentage >= 60) return 'C';
    //     if ($percentage >= 50) return 'D';
    //     return 'F';
    // }
    // public function test()
    // {
    //     return view('test');
    // }
}
