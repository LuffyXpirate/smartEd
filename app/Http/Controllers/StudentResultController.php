<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentModel;
use App\Models\Result;
use App\Models\Subject;
use App\Models\Marks;

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

    // Method to show the result of a student
    public function resultview($student_id)
    {
        // Fetch the student data
        $student = StudentModel::find($student_id);

        if (!$student) {
            return redirect()->route('student.dashboard')->with('error', 'Student not found.');
        }

        // Fetch the student's results from the database
        $results = Result::where('student_id', $student_id)->with('subject')->get();

        // Calculate total marks, percentage, etc.
        $total_marks_obtained = $results->sum('marks_obtained');
        $total_marks = $results->sum('total_marks');
        $percentage = ($total_marks_obtained / $total_marks) * 100;
        $result_status = $percentage >= 40 ? 'Pass' : 'Fail';

        // Teacher's remarks and next steps (could be dynamic)
        $teachers_remarks = "Keep up the good work!";
        $next_steps_guidance = "Focus on weak subjects and continue to practice.";

        // Pass the data to the view
        return view('result.result', compact(
            'student',
            'results',
            'total_marks_obtained',
            'total_marks',
            'percentage',
            'result_status',
            'teachers_remarks',
            'next_steps_guidance'
        ));
    }
    public function studentReport($student_id)
{
    $student = StudentModel::with(['annualPerformance', 'marks.subject'])
                ->findOrFail($student_id);

    // Yearly breakdown
    $yearlyData = $student->marks()
        ->selectRaw('YEAR(exam_date) as year, 
                    AVG(marks_obtained) as overall_percentage,
                    COUNT(*) as total_exams')
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get();

    // Subject-wise performance
    $subjectPerformance = $student->marks()
        ->with('subject')
        ->selectRaw('subject_id, 
                    AVG(marks_obtained) as avg_score,
                    MIN(marks_obtained) as lowest_score,
                    MAX(marks_obtained) as highest_score')
        ->groupBy('subject_id')
        ->get();

    // Comparative analysis
    $classAverages = Marks::selectRaw('YEAR(exam_date) as year, 
                        subject_id, 
                        AVG(marks_obtained) as class_avg')
                    ->groupBy('year', 'subject_id')
                    ->get()
                    ->groupBy(['year', 'subject_id']);

    return view('mark.student-report', compact('student', 'yearlyData', 'subjectPerformance', 'classAverages'));
}
}
