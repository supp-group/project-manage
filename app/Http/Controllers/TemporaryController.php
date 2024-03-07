<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Temporary;
use App\Models\Qualification;
use Illuminate\Http\Request;
use DateTime;
class TemporaryController extends Controller
{
  public function getDeletedMember() 
   {
   $members = Temporary::where('operation','0')->
   select('id','FullName','IDTeam','managerEmail')
   ->orderBy('updated_at', 'desc')->paginate(4);

   $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
   return view('admin.notice.delete', [
       'members' => $members,
       'paginationLinks' => $paginationLinks
   ]);
   }

   public function getEtidedMember() 
   {
   $members = Temporary::where('operation','1')->
   select('id','FullName','IDTeam','managerEmail')
   ->orderBy('updated_at', 'desc')->paginate(4);

   $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
   return view('admin.notice.edit', [
       'members' => $members,
       'paginationLinks' => $paginationLinks
   ]);
   }
   public function storeUpdatedMember(Request $request)
   {
    //    $validated = $request->validate([
    //        'NotPad' => 'required|max:255',
    //        'branch' => 'required',
    //        // 'IDTeam' => 'required|unique:members|max:255',
    //        'FullName' => 'required',
    //        'MotherName' => 'required',
    //        'PlaceOfBirth' => 'required',
    //        'BirthDate' => 'required|date|before:today',
    //        'Constraint' => 'required',
    //        'City' => 'required',
    //        'IDNumber' => 'required|unique:members|min:10|max:11',
    //        'Gender' => 'required',
    //        'Qualification' =>'required',
    //        'Occupation' => 'required',
    //        'MobilePhone' => 'required|max:10|min:9',
    //        'HomeAddress' => 'required',
    //        'WorkAddress' => 'required',
    //        'HomePhone' => 'required|max:10|min:9',
    //        'WorkPhone' => 'required|max:10|min:9',
    //        'DateOfJoin' => 'required|numeric|digits:4|before_or_equal:' . date('Y'),
    //        'Specialization' => 'required',
    //        'Image' =>'required',
    //    ]);

       
  // Convert Birthdate format
  $birthDate = DateTime::createFromFormat('m/d/Y',$request->BirthDate);
  $birthDateFormatted = $birthDate ? $birthDate->format('Y-m-d') : $request->BirthDate;

  
  $qualification = $request->Qualification;

  if (is_numeric($qualification)) {
      // إذا كانت القيمة هي id
      $qualificationName = Qualification::where('id', $qualification)->value('Name');
  } else {
      // إذا كانت القيمة هي اسم
      $qualificationName = $qualification;
  }
  
$specialization = $request->Specialization;

  if (is_numeric($specialization)) {
      // إذا كانت القيمة هي id
      $specializationName = Qualification::where('id', $specialization)->value('specialization');

  } else {
      // إذا كانت القيمة هي اسم
      $specializationName = $specialization;
  }
  $user = auth()->user();

  $member = new Temporary(); 
  $member->NotPad = $request->NotPad;
  $member->branch = $request->branch;
  $member->IDTeam  = $request->IDTeam;
  $member->FullName = $request->FullName;
  $member->MotherName = $request->MotherName;
  $member->PlaceOfBirth = $request->PlaceOfBirth;
  $member->BirthDate = $birthDateFormatted;
  $member->Constraint = $request->Constraint;
  $member->City = $request->City;
  $member->IDNumber  = $request->IDNumber;
  $member->Gender  = $request->Gender == 'ذكر' ? 'ذكر' : 'أنثى';
  $member->Qualification = $qualificationName;
  $member->Specialization  = $specializationName;
  $member->Occupation  = $request->Occupation;
  $member->MobilePhone  = $request->MobilePhone;
  $member->HomeAddress  = $request->HomeAddress;
  $member->WorkAddress  = $request->WorkAddress;
  $member->HomePhone  = $request->HomePhone;
  $member->WorkPhone  = $request->WorkPhone;
  $member->DateOfJoin  = $request->DateOfJoin;
  $member->operation ='1';
  $member->managerEmail =$user->email;
  $member->save();

  // store image
  if($request->hasfile('Image')){
      $img = $request->file('Image');
      $img_name = $img->getClientOriginalName();
      $img->move(public_path('images'), $img_name);

      Temporary::find($member->id)->update([
      'Image'=> $img_name,
      ]);
  }

  session()->flash('Edit', ' سيتم تعديل العضو بعد الموافقة عليه من قبل المدير');
  return back();
}

public function storeDeletedMember(Request $request)
   {
      
  // Convert Birthdate format
  $birthDate = DateTime::createFromFormat('m/d/Y',$request->BirthDate);
  $birthDateFormatted = $birthDate ? $birthDate->format('Y-m-d') : $request->BirthDate;

  
  $qualification = $request->Qualification;

  if (is_numeric($qualification)) {
      // إذا كانت القيمة هي id
      $qualificationName = Qualification::where('id', $qualification)->value('Name');
  } else {
      // إذا كانت القيمة هي اسم
      $qualificationName = $qualification;
  }
  
$specialization = $request->Specialization;

  if (is_numeric($specialization)) {
      // إذا كانت القيمة هي id
      $specializationName = Qualification::where('id', $specialization)->value('specialization');

  } else {
      // إذا كانت القيمة هي اسم
      $specializationName = $specialization;
  }
  $user = auth()->user();

  $member = new Temporary(); 
  $member->NotPad = $request->NotPad;
  $member->branch = $request->branch;
  $member->IDTeam  = $request->IDTeam;
  $member->FullName = $request->FullName;
  $member->MotherName = $request->MotherName;
  $member->PlaceOfBirth = $request->PlaceOfBirth;
  $member->BirthDate = $birthDateFormatted;
  $member->Constraint = $request->Constraint;
  $member->City = $request->City;
  $member->IDNumber  = $request->IDNumber;
  $member->Gender  = $request->Gender == 'ذكر' ? 'ذكر' : 'أنثى';
  $member->Qualification = $qualificationName;
  $member->Specialization  = $specializationName;
  $member->Occupation  = $request->Occupation;
  $member->MobilePhone  = $request->MobilePhone;
  $member->HomeAddress  = $request->HomeAddress;
  $member->WorkAddress  = $request->WorkAddress;
  $member->HomePhone  = $request->HomePhone;
  $member->WorkPhone  = $request->WorkPhone;
  $member->DateOfJoin  = $request->DateOfJoin;
  $member->operation ='0';
  $member->managerEmail =$user->email;
  $member->save();

  // store image
  if($request->hasfile('Image')){
      $img = $request->file('Image');
      $img_name = $img->getClientOriginalName();
      $img->move(public_path('images'), $img_name);

      Temporary::find($member->id)->update([
      'Image'=> $img_name,
      ]);
  }

  session()->flash('delete', 'سيتم حذف العضو بعد الموافقة عليه من قبل المدير');
  return back();
}

public function destroyNotice( $id)
{
    Temporary::findOrFail($id)->delete();

   session()->flash('delete', 'تم تجاهل الإشعار ');
   return back(); 
}

public function editDetails($IDTeam)
{
   $mem = Temporary::where('IDTeam',$IDTeam)->first();
  return view('admin.notice.editDetails',compact('mem'));
// return dd($mem);
}

public function deleteDetails($IDTeam)
{
   $member = Temporary::where('IDTeam',$IDTeam)->first();
   return view('admin.notice.deleteDetails',compact('member'));
}

}
