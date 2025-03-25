<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\auth;
use App\Models\Marks;
use App\Models\Subject;
use Carbon\Carbon;

class StudentController extends Controller
{
    // Student Dashboard
    public function dashboard()
    {
        return view('student.dashboard');
    }

    // List Students (Paginated)
    public function list()
    {
        $students = StudentModel::paginate(10); // Show 10 students per page
        return view('student.list', compact('students'));
    }

    // Show Add Student Form
    public function add()
    {
        return view('student.add');
    }

    // Store New Student
    public function store(Request $request)
    {
        try {
            // Debug the request data
           
    
            // Validate the request
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'roll_no' => 'required|string|unique:students,roll_no',
                'class' => 'required|string',
            ]);
    
            // Check if the class already has 10 students
            $studentsInClass = StudentModel::where('class', $request->class)->count();
            if ($studentsInClass >= 10) {
                return back()->withErrors(['error' => 'This class already has 10 students. Cannot add more students.']);
            }
    
            // Create User
            $user = new User();
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 'student';
            $user->save();
    
            // Create Student
            $student = new StudentModel();
            $student->user_id = $user->id;
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->roll_no = $request->roll_no;
            $student->class = $request->class;
            $student->save();
    
            return redirect()->back()->with('success', 'Student added successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to add student: ' . $e->getMessage()]);
        }
    }
    
    // Show Edit Form for Student
    public function edit($id)
    {
        $student = StudentModel::with('user')->findOrFail($id);
        return view('student.edit', compact('student'));
    }

    // Update Student Details
    public function update(Request $request, $id)
{
    try {
        // Find the student first to get the user relationship
        $student = StudentModel::with('user')->findOrFail($id);
        
        // Validate Request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user->id,
            'roll_no' => 'required|string|unique:students,roll_no,' . $id,
            'class' => 'required|string',
        ]);

        // Update User
        $student->user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
        ]);

        // Update Student
        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'roll_no' => $request->roll_no,
            'class' => $request->class,
        ]);

        return redirect()->route('student.list')->with('success', 'Student updated successfully!');
    } catch (ValidationException $e) {
        return back()->withErrors($e->validator->errors())->withInput();
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Failed to update student: ' . $e->getMessage()])->withInput();
    }
}

    // Delete Student
    public function delete($id)
    {
        try {
            // Find Student with User Relationship
            $student = StudentModel::with('user')->findOrFail($id);

            // Delete the Student and Associated User
            $student->delete();
            if ($student->user) {
                $student->user->delete();
            }

            return redirect()->route('student.list')->with('success', 'Student deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete student: ' . $e->getMessage()]);
        }
    }

  

   
}

