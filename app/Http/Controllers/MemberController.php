<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Auth;
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
        $user = auth()->user();
        $city = User::find($user->city_id);
        
        if ($city) {
            $members = Member::where('City', 'حلب')->orderBy('created_at', 'desc') ->get();
        } else {
           
         $members = Member::orderBy('created_at','desc')->get();
         return view('manager.member.show',compact('members'));
        }
        // $city = User::find(auth()->user()->city_id);
        //  $members = Member::where('City',$city->Name)->orderBy('updated_at','desc')->get();
         return view('manager.member.show',compact('members'));
      }
    
    }



    public function orderBy_Last()
    { 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('created_at','desc')->get();
            return view('admin.member.show',compact('members'));
        }
        elseif (optional(auth()->user())->Role == 'manager')
        {
         $user = auth()->user();
         $city = User::find($user->city_id);
         
         if ($city) {
             $members = Member::where('City', $city->Name)->orderBy('created_at', 'desc') ->get();
                } 
          return view('manager.member.show',compact('members'));
         }
    }


    public function orderBy_Name()
    { 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('FullName','Asc')->get();
            return view('admin.member.show',compact('members'));
        }
        elseif (optional(auth()->user())->Role == 'manager')
        {
         $user = auth()->user();
         $city = User::find($user->city_id);
         
         if ($city) {
             $members = Member::where('City', $city->Name)->orderBy('FullName', 'Asc') ->get();
                } 
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
         $user = auth()->user();
         $city = User::find($user->city_id);
         
         if ($city) {
             $members = Member::where('City', $city->Name)->orderBy('IDTeam', 'Asc') ->get();
                } 
          return view('manager.member.show',compact('members'));
    }
    }
     public function orderBy_DateOfJoin()
    { 
   
    if (optional(auth()->user())->Role == 'admin') 
    {
        $members = Member::orderBy('DateOfJoin','desc')->get();
        return view('admin.member.show',compact('members'));
    }
    elseif (optional(auth()->user())->Role == 'manager')
        {
         $user = auth()->user();
         $city = User::find($user->city_id);
         
         if ($city) {
             $members = Member::where('City', $city->Name)->orderBy('DateOfJoin', 'Asc') ->get();
                } 
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
        
             // store image
             if($request->hasfile('Image')){
                $img = $request->file('Image');
                $img_name = $img->getClientOriginalName();
                $img->move(public_path('images'), $img_name);
            }
      
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
    'Gender' => $request->Gender == 'ذكر' ? 'ذكر' : 'أنثى',
    'Qualification' =>$request->Qualification ,
    'Occupation' => $request->Occupation,
    'MobilePhone' => $request->MobilePhone ,
    'HomeAddress' => $request->HomeAddress ,
    'WorkAddress' => $request->WorkAddress ,
    'HomePhone' => $request->Occupation,
    'WorkPhone' => $request->MobilePhone ,
    'DateOfJoin' => $request->DateOfJoin ,
    'Specialization' => $request->Specialization ,
    'Image' => $request->Image->getClientOriginalName(),
    'qualification_id'=>$request->qualification_id,
    'occupation_id'=>$request->occupation_id,
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
    
    'Gender' => $request->Gender == 'ذكر' ? 'ذكر' : 'أنثى',
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
    'qualification_id'=>$request->qualification_id,
    'occupation_id'=>$request->occupation_id,
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

     public function searchByName(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

   $members =  Member::where('FullName', 'like', '%'.$searchTerm.'%')->get();
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('members'));
   }
    }


    public function searchByIDTeam(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

   $members =  Member::where('IDTeam', 'like', '%'.$searchTerm.'%')->get();

   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('members'));
   }
    }

    public function searchByQualification(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $members =  Member::where('Qualification', 'like', '%'.$searchTerm.'%')->get();

   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('members'));
   }
    }

    public function searchBySpecialization(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $members =  Member::where('Specialization', 'like', '%'.$searchTerm.'%')->get();

   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('members'));
   }
    }

    public function searchByCity(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $members =  Member::where('City', 'like', '%'.$searchTerm.'%')->get();

   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('members'));
   }
    }

    
    public function searchByOccupation(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $members =  Member::where('Occupation', 'like', '%'.$searchTerm.'%')->get();

   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
  else if ( auth()->user()->Role == 'manager')
   {
    return view('manager.member.show',compact('members'));
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


function exportDataToCSV($members) {
    $filename = "members.csv";
    $handle = fopen($filename, 'w');

    fputcsv($handle, [
        'الملاحظات',
        'الفرع',
        'الرقم الحزبي',
        'الاسم الثلاثي',
        'اسم الأم',
        ' مكان الولادة ',
        'تاريخ الولادة',
        'محل ورقم القيد ',
        'المحافظة',
        'الرقم الوطني',
        'الجنس',
        'الؤهل العلمي',
        'المهنة',
        'موبايل',
        'عنوان المنزل',
        'عنوان العمل',
        'هاتف المنزل',
        'هاتف العمل',
        'تاريخ الإنتساب',
        ' الاختصاص',
        'رابط الصورة',
    ]);

    foreach ($members as $member) {
        $row = [
            $member->NotPad,
             $member->branch,
             $member->IDTeam,
             $member->FullName,
             $member->MotherName,
             $member->PlaceOfBirth, 
             $member->BirthDate,
             $member->Constraint,
             $member->City,
             $member->IDNumber,
             $member->Gender,
             $member->Qualification,
             $member->Occupation,
             $member->MobilePhone,
             $member->HomeAddress,
             $member->WorkAddress, 
             $member->HomePhone,
             $member->WorkPhone,
             $member->DateOfJoin,
             $member->Specialization,
             $member->Image
        ];

        // تحويل ترميز الحروف إلى UTF-8
        $row = array_map(function($value) {
            return mb_convert_encoding($value, 'UTF-8', 'auto');
        }, $row);

        fputcsv($handle, $row);
    }

    fclose($handle);
}




  public function GetCityWithMember($data)
   {
  $member =  Member::where('City', $data)->get();
  
   return view('admin.show-members',compact('member'));
  }

}