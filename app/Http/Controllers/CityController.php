<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index()
    { 
         $cities = City::orderBy('Name','desc')->get();
         return view('admin.city.show',compact('cities'));
    }

    
    public function create()
    {
       return view('admin.city.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|unique:cities|max:255',
        ]);

        $city= City::create([

            'Name'=>$request->Name,
        ]);
        session()->flash('Add', 'Added successfully.');
        return redirect()->route('admin.city.show');
    }

    
  public function edit( $id)
  {
     $cities = City::findOrFail($id);
      return view('admin.city.edit',compact('cities'));
  }
 
   
  public function update(Request $request, $id)
  {
      $cities = City::findOrFail($id);
      $cities->update([
    'Name'=>$request->Name,
      ]);
      session()->flash('update', 'updated successfully.');
      return redirect()->route('admin.city.show');
    }

    public function destroy( $id)
    {
       City::findOrFail($id)->delete();
      session()->flash('delete', 'Deleted successfully.');

          return redirect()->route('admin.city.show');
       }
}
