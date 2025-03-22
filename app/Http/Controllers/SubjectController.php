<?Php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function list()
    {
        $subjects = Subject::all();
        
        return view('subject.list', compact('subjects'));
    }
    public function add()
    {
        return view('subject.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,subject_code',
        ]);

        $subject = new Subject();
        $subject->subject_name = $request->name;
        $subject->subject_code = $request->code;
        $subject->save();

        return redirect()->route('subject.list')->with('success', 'Subject added successfully');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('subject.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:subjects,subject_code,' . $id,
        ]);

        $subject = Subject::findOrFail($id);
        $subject->subject_name = $request->name;
        $subject->subject_code = $request->code;
        $subject->save();

        return redirect()->route('subject.list')->with('success', 'Subject updated successfully');
    }

    public function delete($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subject.list')->with('success', 'Subject deleted successfully');
    }
}
