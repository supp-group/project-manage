<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qualification;
use Illuminate\Support\Facades\Validator;

class QualificationController extends Controller
{
  
    public function indexQualification()
    { 
         $qualifications = Qualification::orderBy('Name','desc')->get('Name');
         return view('admin.occupation.show',compact('qualifications'));
    }
    public function indexSpecialization()
    { 
         $specializations = Qualification::where('Name','desc')->get('Specializations');
         return view('admin.specialization.show',compact('specializations'));
    }
    
    public function createQualification()
    {
       return view('admin.qualification.add');
    }

    public function createSpecialization()
    {
       return view('admin.specialization.add');
    }

    public function storeQualification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|unique:qualifications|max:255',
        ]);

        Qualification::create([

            'Name'=>$request->Name,
        ]);
        session()->flash('Add', 'Added successfully.');
        return redirect()->route('admin.qualification.show');
    }

    public function storeSpecialization(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parentId'=>'required',
            'Specialization' => 'required|unique:occupations|max:255',
        ]);

         Qualification::create([

            'parentId'=>$request->parentId,
            'Specialization'=>$request->Specialization
        ]);
        session()->flash('Add', 'Added successfully.');
        
        return redirect()->route('admin.specialization.show');
    }
    
  public function editQualification( $id)
  {
     $qualification = Qualification::findOrFail($id);
      return view('admin.qualification.edit',compact('qualification'));
  }
 
  public function editSpecialization( $id)
  {
     $specialization = Qualification::findOrFail($id);
      return view('admin.specialization.edit',compact('specialization'));
  }
 
   
  public function updateQualification(Request $request, $id)
  {
      $qualification = Qualification::findOrFail($id);
      $qualification->update([
      'Name'=>$request->Name,
      ]);
      session()->flash('update', 'updated successfully.');

      return redirect()->route('admin.qualification.show');
    }

  
       public function updateSpecialization(Request $request, $id)
  {
      $specialization = Qualification::findOrFail($id);
      $specialization->update([
        'parentId'=>$request->parentId,
        'Specialization'=>$request->Name,
      ]);
      session()->flash('update', 'updated successfully.');

      return redirect()->route('admin.specialization.show');
    }

    public function destroyQualification($id)
    {
        $qualification = Qualification::findOrFail($id);
    
        $subSpecializations = Qualification::where('parentId', $id)->get();
  
        foreach ($subSpecializations as $subSpecialization) {
            $subSpecialization->delete();
        }
    
        $qualification->delete();
    
        session()->flash('delete', 'Deleted successfully.');
    
        return redirect()->route('admin.qualification.show');
    }
    


    public function destroySpecialization($id)
    {
        Qualification::findOrFail($id)->delete();

       session()->flash('delete', 'Deleted successfully.');

        return redirect()->route('admin.specialization.show');
       }
}
