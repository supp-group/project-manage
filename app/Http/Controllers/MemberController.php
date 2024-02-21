<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class MemberController extends Controller
{
   

    public function index()
    { 
     if (optional(auth()->user())->Role == 'admin') 
     {
         $members = Member::orderBy('updated_at','desc')->get();
         return view('admin.member.show',compact('members'));
     }
      elseif (optional(auth()->user())->Role == 'manager')
       {
         $members = Member::where('City',auth()->user()->City)->orderBy('updated_at','desc')->get();
         return view('manager.member.show',compact('members'));
      }
    
    }

    public function orderBy_Name()
    { 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('Name','Asc')->get();
            return view('admin.member.show',compact('members'));
        }
         elseif (optional(auth()->user())->Role == 'manager')
          {
            $members = Member::where('City',auth()->user()->City)->orderBy('Name','Asc')->get();
            return view('manager.member.show',compact('members'));
         }
    }

     public function orderBy_IDTeam()
    { 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('IDTeam','Asc')->get();
            return view('admin.member.show',compact('members'));
        }
         elseif (optional(auth()->user())->Role == 'manager')
          {
            $members = Member::where('City',auth()->user()->City)->orderBy('IDTeam','Asc')->get();
            return view('manager.member.show',compact('members'));
         }
    }
     public function orderBy_DateOfJoin()
    { 
   
    if (optional(auth()->user())->Role == 'admin') 
    {
        $members = Member::orderBy('DateOfJoin','Asc')->get();
        return view('admin.member.show',compact('members'));
    }
     elseif (optional(auth()->user())->Role == 'manager')
      {
        $members = Member::where('City',auth()->user()->City)->orderBy('DateOfJoin','Asc')->get();
        return view('manager.member.show',compact('members'));
     }

    }

    public function create()
    {
        if ( auth()->user()->Role == 'admin')
        {
            return view('admin.member.add');
        }
       else if ( auth()->user()->Role == 'manager')
        {
            return view('manager.member.add');
        }
    
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'NotPad' => 'required|max:255',
            'branch' => 'required',
            'IDTeam' => 'required|unique:members|max:255',
            'FullName' => 'required',
            'MotherName' => 'required',
            'PlaceOfBirth' => 'required',
            'BirthDate' => 'required|date|before_or_equal:today',
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
            'DateOfJoin' => 'required|date|before_or_equal:today',
            'Specialization' => 'required',
            'Image' =>'required',
            'qualification_id'=>'required',
            'occupation_id'=>'required'
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
    'City'=>auth()->city_id->Name,
    // 'City' => $user->city->name,
    // 'City' => $user->city->name,
    'IDNumber' => $request->IDNumber,
    'Gender' => $request->Gender == 'male' ? 'male' : 'female',
    'Qualification' =>$request->Qualification ,
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

    session()->flash('Add', 'تم إضافة العضو بنجاح');
        return back();
    
//     if ( auth()->user()->Role == 'admin')
//     {
//         return redirect()->route('admin.member.add');
//     }
//    else if ( auth()->user()->Role == 'manager')
//     {
//         return redirect()->route('manager.member.add');
//     }
  }

  
  public function edit( $id)
  {
     $member = Member::findOrFail($id);

     if ( auth()->user()->Role == 'admin')
     {
      return view('admin.member.edit',compact('member'));
     }
    else if ( auth()->user()->Role == 'manager')
     {
      return view('manager.member.edit',compact('member'));
     }
     
  }

  
  public function update(Request $request, $id)
  {
    $validated = $request->validate([
        'NotPad' => 'required|max:255',
        'branch' => 'required',
        'IDTeam' => 'required|unique:members|max:255',
        'FullName' => 'required',
        'MotherName' => 'required',
        'PlaceOfBirth' => 'required',
        'BirthDate' => 'required|date|before_or_equal:today',
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
        'DateOfJoin' => 'required|date|before_or_equal:today',
        'Specialization' => 'required',
        'Image' =>'required',
        'qualification_id'=>'required',
        'occupation_id'=>'required'
    ]);
    
  

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
    
    'Gender' => $request->Gender == 'male' ? 'male' : 'female',
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

    session()->flash('Edit', 'تم تعديل العضو بنجاح');
    return back();

    //   if ( auth()->user()->Role == 'admin')
    //   {
    //      return redirect()->route('admin.member.show');
    //   }
    //  else if ( auth()->user()->Role == 'manager')
    //   {
    //      return redirect()->route('manager.member.show');
    //   }
     
  }

  public function destroy( $id)
    {
       Member::findOrFail($id)->delete();
       if ( auth()->user()->Role == 'admin')
       {
          return redirect()->route('admin.member.show');
       }
      else if ( auth()->user()->Role == 'manager')
       {
          return redirect()->route('manager.member.show');
       }
    }

     public function searchByName($data)
    {
        
   $members =  Member::contains('Name', $data);
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('member'));
   }
    }


    public function searchByIDTeam($data)
    {
   $members =  Member::contains('IDTeam', $data);
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('member'));
   }
    }

    public function searchByQualification($data)
    {
   $members =  Member::contains('Qualification', $data);
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('member'));
   }
    }

    public function searchBySpecialization($data)
    {
   $members =  Member::contains('Specialization', $data);
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('member'));
   }
    }

    public function searchByCity($data)
    {
   $members =  Member::contains('City', $data);
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('member'));
   }
    }

    
    public function searchByOccupation($data)
    {
   $members =  Member::contains('Occupation', $data);
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('member'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('member'));
   }
    }



    public function import(Request $request)
    {
    $file = $request->file('file');
    $fileContents = file($file->getPathname());

    foreach ($fileContents as $line) {
        $data = str_getcsv($line);

        Member::create([
            'NotPad' => $data[0],
            'branch' => $data[1],
            'IDTeam' => $data[2],
            'FullName' => $data[3],
            'MotherName' => $data[4],
            'PlaceOfBirth' => $data[5],
            'BirthDate' => $data[6],
            'Constraint' => $data[7],
            'City' => $data[8],
            'IDNumber' => $data[9],
            'Gender' => $data[10],
            'Qualification' => $data[11],
            'Occupation' => $data[12],
            'MobilePhone' => $data[13],
            'HomeAddress' => $data[14],
            'WorkAddress' => $data[15],
            'HomePhone' => $data[16],
            'WorkPhone' => $data[17],
            'DateOfJoin' => $data[18],
            'Specialization' => $data[19],
            'Image' => $data[20],
            // Add more fields as needed
        ]);
    }

    // return "ok";
    return redirect()->back()->with('success', 'CSV file imported successfully.');
    }


    public function export()
    {
        $data = session('searchData');
        if ($data) {
            $members = Member::contains('Name', $data)||Member::contains('IDTeam', $data)||
            Member::contains('Qualification', $data)||Member::contains('Specialization', $data)||
            $members =  Member::contains('City', $data)||Member::contains('Occupation', $data) ->get(); // تغيير Name إلى الحقل المناسب
        } else {
            $members = Member::all();
        }
    
    $csvFileName = 'posts.csv';
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
    ];

    $handle = fopen('php://output', 'w');
    fputcsv($handle, ['NotPad', 'branch','IDTeam','FullName','MotherName','PlaceOfBirth','BirthDate','Constraint',
            'City','IDNumber','Gender','Qualification','Occupation','MobilePhone','HomeAddress','WorkAddress',
            'HomePhone','WorkPhone','DateOfJoin','Specialization','Image']); // Add more headers as needed

    foreach ($members as $member) {
        fputcsv($handle, [$member->NotPad, $member->branch,$member->IDTeam,$member->FullName,$member->MotherName,
        $member->PlaceOfBirth, $member->BirthDate,$member->Constraint,$member->City,$member->IDNumber,
        $member->Gender, $member->Qualification,$member->Occupation,$member->MobilePhone,$member->HomeAddress,
        $member->WorkAddress, $member->HomePhone,$member->WorkPhone,$member->DateOfJoin,$member->Specialization,
        $member->Image]); // Add more fields as needed
    }

    fclose($handle);

    return Response::make('CSV file exported successfully.', 200, $headers);
    }

}