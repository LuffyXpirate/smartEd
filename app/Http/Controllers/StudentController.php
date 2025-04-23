<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassModel;

use App\Models\StudentClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        $students = Student::with('studentClass')->paginate(10);
        
        // Get classes from the CORRECT model/table
        $classes = ClassModel::orderBy('class_name')->get(); 
        
        return view('student.list', compact('students', 'classes'));
    }

    // Show Add Student Form
    public function add()
    {
        $classes = StudentClass::orderBy('class')->get(); // Get all classes
        return view('student.add', compact('classes')); 
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'roll_no' => 'required|string|unique:students,roll_no',
                'class_id' => 'required|exists:classes,id',            ]);
    
            // Create the User
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                
                'user_type' => 'student'
            ]);
    
            // Create the Student record
            $student = new Student();
            $student->user_id = $user->id;
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->roll_no = $request->roll_no;
            $student->class_id = $request->class_id;
            $student->save();
    
            return redirect()->route('student.list')->with('success', 'Student added successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to add student: ' . $e->getMessage()]);
        }
    }
    
    
    // Show Edit Form for Student
    public function edit($id)
    {
        $student = Student::with(['user', 'studentClass'])->findOrFail($id);
        $classes = ClassModel::orderBy('class_name')->get(); 
        return view('student.edit', compact('student', 'classes'));
    }

    // Update Student Details
    public function update(Request $request, $id)
    {
        try {
            $student = Student::with('user')->findOrFail($id);
            
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $student->user->id,
                'roll_no' => 'required|string|unique:students,roll_no,' . $id,
                'class_id' => 'required|exists:classes,id',
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
                'class_id' => $request->class_id,
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
            $student = Student::with('user')->findOrFail($id);
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
