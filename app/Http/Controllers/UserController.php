<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
   
    public function index()
    { 
         $users = User::orderBy('updated_at','desc')->get();
         return view('admin.user.show',compact('users'));
    }

    
    public function create()
    {
       return view('admin.user.add');
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
            'email' => 'required|unique:users|max:255',
             'password'=>'required',
             'Role'=>'required',
             'city_id'=>'required',

        ]);

        User::create([
            'email'=>$request->email,
            'password'=>$request->password,
            'Role'=>$request->Role,
            'city_id'=>$request->city_id,

        ]);
        session()->flash('Add', 'Added successfully.');
        return redirect()->route('admin.user.show');
    }

    
  public function edit( $id)
  {
     $user = User::findOrFail($id);
      return view('admin.user.edit',compact('user'));
  }
 
   
  public function update(Request $request, $id)
  {  
    $validated = $request->validate([
    'email' => 'required|unique:users|max:255',
     'password'=>'required',
     'Role'=>'required',
     'city_id'=>'required',
 
     ]);
      $user = User::findOrFail($id);
      $user->update([
        'email'=>$request->email,
        'password'=>$request->password,
        'Role'=>$request->Role,
        'city_id'=>$request->city_id,
      ]);
      session()->flash('update', 'updated successfully.');
      return redirect()->route('admin.user.show');
    }

    public function destroy( $id)
    {
        User::findOrFail($id)->delete();
        session()->flash('delete', 'Deleted successfully.');

          return redirect()->route('admin.user.show');
       }
}
