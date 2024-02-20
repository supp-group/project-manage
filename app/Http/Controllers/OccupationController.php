<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Occupation;
use Illuminate\Support\Facades\Validator;

class OccupationController extends Controller
{
    public function index()
    { 
         $occupations = Occupation::orderBy('Name','desc')->get();
         return view('admin.occupation.show',compact('occupations'));
    }

    
    public function create()
    {
       return view('admin.occupation.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|unique:occupations|max:255',
        ]);

        $occupations= Occupation::create([

            'Name'=>$request->Name,
        ]);
        session()->flash('Add', 'Added successfully.');
        return redirect()->route('admin.occupation.show');
    }

    
  public function edit( $id)
  {
     $occupation = Occupation::findOrFail($id);
      return view('admin.occupation.edit',compact('occupation'));
  }
 
   
  public function update(Request $request, $id)
  {
      $occupation = Occupation::findOrFail($id);
      $occupation->update([
    'Name'=>$request->Name,
      ]);
      session()->flash('update', 'updated successfully.');
      return redirect()->route('admin.occupation.show');
    }

    public function destroy( $id)
    {
        Occupation::findOrFail($id)->delete();
      session()->flash('delete', 'Deleted successfully.');

          return redirect()->route('admin.occupation.show');
       }
}
