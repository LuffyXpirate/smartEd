<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getAdmin();
        return view('admin.admin.list',$data);
    }
    public function add()
    {
// Fetch the records of users with the admin role using the static method `getAdmin` from the User model
        return view('admin.admin.add');
    }
    public function Addadmin(Request $request)
    {
        $request->validate([ 
           'email' => 'required|email|unique:users'

        ]);
        $user = new user();
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type=1;
        $user->save();
        return redirect('admin/list')->with('sucess',"Admin Sucessfully Created");
    }
    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
    
        if (!empty($data['getRecord'])) {
            return view('admin.admin.edit', $data); // Load edit view
        } else {
            abort(404); // Show 404 if record not found
        }
    }
        
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->save();

        return redirect('admin/list')->with('primary', "Admin Successfully Updated");
    }
public function delete($id)
{
    $user = User::findOrFail($id); //: If a user with the given $id is found, findOrFail returns the user instance and assigns it to the $user variable. If no user is found, it throws a ModelNotFoundException,
    $user->is_delete="1";
    $user->save();
    return redirect('admin/list')->with('primary', "Admin Successfully Deleted");

}
}
