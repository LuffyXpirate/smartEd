<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::latest()->get();
        return view('subject.list', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = ['Class 5', 'Class 6', 'Class 7', 'Class 8','class 9','class 10']; // Example classes; adjust as needed
        return view('subject.add', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'class' => 'required|array|min:1',  // Expect an array from the checkboxes
        ]);
    
        // Convert the class array into a comma-separated string
        $validated['class'] = implode(',', $validated['class']);
    
        Subject::create($validated);
    
        return redirect()->route('subject.list')
            ->with('success', 'Subject created successfully');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::findOrFail($id);
        // Convert classes back to an array
        $classes = explode(',', $subject->classes); 
        return view('subject.show', compact('subject', 'classes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::findOrFail($id);
        $classes = ['Class 5', 'Class 6', 'Class 7', 'Class 8','class 9','class 10']; // Example classes; adjust as needed
        // Convert stored comma-separated classes into an array
        $selectedClasses = explode(',', $subject->classes);
        return view('subject.edit', compact('subject', 'classes', 'selectedClasses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'class' => 'required|array|min:1',  // Expect an array for class
        ]);
    
        // Convert the class array into a comma-separated string
        $validated['class'] = implode(',', $validated['class']);
    
        $subject = Subject::findOrFail($id);
        $subject->update($validated);
    
        return redirect()->route('subject.list')
            ->with('success', 'Subject updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subject.list')
            ->with('success', 'Subject deleted successfully');
    }
}
