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

        session()->flash('Add', 'تم إضافة المحافظة بنجاح');
        return back();
    }

    
  public function edit( $id)
  {
    $city = City::findOrFail($id);
    return view('admin.city.edit',compact('city'));
  }
 
   
  public function update(Request $request, $id)
  {
      $city = City::findOrFail($id);

      $city->update([
        'Name'=>$request->Name,
      ]);

      session()->flash('update', 'تم تعديل المحافظة بنجاح');
      return back();
    }

    public function destroy($id)
    {
        City::findOrFail($id)->delete();

        session()->flash('delete', 'تم حذف المحافظة بنجاح');
        return back();
    }
}
