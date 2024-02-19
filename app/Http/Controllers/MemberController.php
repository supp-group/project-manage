<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class MemberController extends Controller
{
   

    public function index()
    { 
     if (optional(auth()->user())->role == '1') 
     {
         $members = Member::orderBy('updated_at','desc')->get();
         return view('admin.member.show',compact('members'));
     }
      elseif (optional(auth()->user())->role == '0')
       {
         $members = Member::where('City',auth()->user()->City)->orderBy('updated_at','desc')->get();
         return view('manager.member.show',compact('members'));
      }
    
    }

    public function orderBy_Name()
    { 
        if (optional(auth()->user())->role == '1') 
        {
            $members = Member::orderBy('Name','desc')->get();
            return view('admin.member.show',compact('members'));
        }
         elseif (optional(auth()->user())->role == '0')
          {
            $members = Member::where('City',auth()->user()->City)->orderBy('Name','desc')->get();
            return view('manager.member.show',compact('members'));
         }
    }

     public function orderBy_IDTeam()
    { 
        if (optional(auth()->user())->role == '1') 
        {
            $members = Member::orderBy('IDTeam','desc')->get();
            return view('admin.member.show',compact('members'));
        }
         elseif (optional(auth()->user())->role == '0')
          {
            $members = Member::where('City',auth()->user()->City)->orderBy('IDTeam','desc')->get();
            return view('manager.member.show',compact('members'));
         }
    }
     public function orderBy_DateOfJoin()
    { 
   
    if (optional(auth()->user())->role == '1') 
    {
        $members = Member::orderBy('DateOfJoin','desc')->get();
        return view('admin.member.show',compact('members'));
    }
     elseif (optional(auth()->user())->role == '0')
      {
        $members = Member::where('City',auth()->user()->City)->orderBy('DateOfJoin','desc')->get();
        return view('manager.member.show',compact('members'));
     }

    }

    public function create()
    {
        if ( auth()->user()->role == '1')
        {
            return view('admin.member.create');
        }
       else if ( auth()->user()->role == '0')
        {
            return view('manager.member.create');
        }
    
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NotPad' => 'required|max:255',
            'branch' => 'required',
            'IDTeam' => 'required|unique:members|max:255',
            'FullName' => 'required',
            'MotherName' => 'required',
            'PlaceOfBirth' => 'required',
            'BirthDate' => 'required',
            'Constraint' => 'required',
            'City' => 'required',
            'IDNumber' => 'required|unique:members|min:11|max:11',
            'Gender' => 'required',
            'Qualification' =>'required',
            'Occupation' => 'required',
            'MobilePhone' => 'required|max:10',
            'HomeAddress' => 'required',
            'WorkAddress' => 'required',
            'HomePhone' => 'required|max:10',
            'WorkPhone' => 'required|max:10',
            'DateOfJoin' => 'required|<date.now',
            'Specialization' => 'required',
            'Image' =>'required',
        ]);
        
      
        $member= Member::create([

    'NotPad'=>$request->NotPad,
    'branch'=>$request->branch,
    'IDTeam' => $request->IDTeam,
    'FullName' => $request->FullName,
    'MotherName' => $request->MotherName,
    'PlaceOfBirth' => $request->PlaceOfBirth,
    'BirthDate' => $request->BirthDate,
    'Constraint' => $request->Constraint,
    'City'=>$request->City,
    'IDNumber' => $request->IDNumber,
    // 0 for male ..1 for female
    'Gender' => $request->Gender == '1' ? 1 : 0,
    'Qualification' => $request->Qualification ,
    'Occupation' => $request->Occupation,
    'MobilePhone' => $request->MobilePhone ,
    'HomeAddress' => $request->HomeAddress ,
    'WorkAddress' => $request->WorkAddress ,
    'HomePhone' => $request->Occupation,
    'WorkPhone' => $request->MobilePhone ,
    'DateOfJoin' => $request->DateOfJoin ,
    'Specialization' => $request->Specialization ,
    'Image' => $request->Image ,
    //user
   'user_id'=>auth()->id()
]);
session()->flash('Add', 'Added successfully.');
   
    
    if ( auth()->user()->role == '1')
    {
        return redirect()->route('admin.member.add');
    }
   else if ( auth()->user()->role == '0')
    {
        return redirect()->route('manager.member.add');
    }
  }

  
  public function edit( $id)
  {
     $member = Member::findOrFail($id);

     if ( auth()->user()->role == '1')
     {
      return view('admin.member.edit',compact('member'));
     }
    else if ( auth()->user()->role == '0')
     {
      return view('manager.member.edit',compact('member'));
     }
     
  }

  
  public function update(Request $request, $id)
  {
      $member = Member::findOrFail($id);
      $member->update([
    'NotPad'=>$request->NotPad,
    'branch'=>$request->branch,
    'IDTeam' => $request->IDTeam,
    'FullName' => $request->FullName,
    'MotherName' => $request->MotherName,
    'PlaceOfBirth' => $request->PlaceOfBirth,
    'BirthDate' => $request->BirthDate,
    'Constraint' => $request->Constraint,
    'City'=>$request->City,
    'IDNumber' => $request->IDNumber,
    // 0 for male ..1 for female
    'Gender' => $request->Gender == '1' ? 1 : 0,
    'Qualification' => $request->Qualification ,
    'Occupation' => $request->Occupation,
    'MobilePhone' => $request->MobilePhone ,
    'HomeAddress' => $request->HomeAddress ,
    'WorkAddress' => $request->WorkAddress ,
    'HomePhone' => $request->Occupation,
    'WorkPhone' => $request->MobilePhone ,
    'DateOfJoin' => $request->DateOfJoin ,
    'Specialization' => $request->Specialization ,
    'Image' => $request->Image ,
    //user
   'user_id'=>auth()->id()
      ]);

      if ( auth()->user()->role == '1')
      {
         return redirect()->route('admin.member.show');
      }
     else if ( auth()->user()->role == '0')
      {
         return redirect()->route('manager.member.show');
      }
     
  }

  public function destroy( $id)
    {
       Member::findOrFail($id)->delete();
       if ( auth()->user()->role == '1')
       {
          return redirect()->route('admin.member.show');
       }
      else if ( auth()->user()->role == '0')
       {
          return redirect()->route('manager.member.show');
       }
    }

     public function searchByName($data)
    {
   $members =  Member::contains('Name', $data);
   if ( auth()->user()->role == '1')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->role == '0')
   {
    return view('manager.member.show',compact('member'));
   }
    }


    public function searchByIDTeam($data)
    {
   $members =  Member::contains('IDTeam', $data);
   if ( auth()->user()->role == '1')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->role == '0')
   {
    return view('manager.member.show',compact('member'));
   }
    }

    public function searchByQualification($data)
    {
   $members =  Member::contains('Qualification', $data);
   if ( auth()->user()->role == '1')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->role == '0')
   {
    return view('manager.member.show',compact('member'));
   }
    }

    public function searchBySpecialization($data)
    {
   $members =  Member::contains('Specialization', $data);
   if ( auth()->user()->role == '1')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->role == '0')
   {
    return view('manager.member.show',compact('member'));
   }
    }

    public function searchByCity($data)
    {
   $members =  Member::contains('City', $data);
   if ( auth()->user()->role == '1')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->role == '0')
   {
    return view('manager.member.show',compact('member'));
   }
    }

    
    public function searchByOccupation($data)
    {
   $members =  Member::contains('Occupation', $data);
   if ( auth()->user()->role == '1')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->role == '0')
   {
    return view('manager.member.show',compact('member'));
   }
    }

}