<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Member;
use App\Models\Occupation;
use App\Models\Qualification;
use App\Models\User;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class MemberController extends Controller

{
    public function index()
    { 
     if (optional(auth()->user())->Role == 'admin') 
     {
        $members = Member::orderBy('updated_at','desc')->get();
        return view('admin.member.show',compact('members'));
     }
     elseif (optional(auth()->user())->Role == 'manager') {
        $user = auth()->user();
        $cityName = DB::table('cities')
            ->where('id', $user->city_id)
            ->value('Name');
        
        $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->get();
        
        return view('manager.member.show', compact('members'));
    }
      }

    
    public function orderBy_Last()
    { 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('created_at','desc')->get();
            return view('admin.member.show',compact('members'));
        }
        elseif (optional(auth()->user())->Role == 'manager') {
            $user = auth()->user();
            $cityName = DB::table('cities')
                ->where('id', $user->city_id)
                ->value('Name');
            
            $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->get();
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
        elseif (optional(auth()->user())->Role == 'manager') {
            $user = auth()->user();
            $cityName = DB::table('cities')
                ->where('id', $user->city_id)
                ->value('Name');
            
            $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->get();
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
        elseif (optional(auth()->user())->Role == 'manager') {
            $user = auth()->user();
            $cityName = DB::table('cities')
                ->where('id', $user->city_id)
                ->value('Name');
            
            $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->get();
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
    elseif (optional(auth()->user())->Role == 'manager') {
        $user = auth()->user();
        $cityName = DB::table('cities')
            ->where('id', $user->city_id)
            ->value('Name');
        
        $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->get();
          return view('manager.member.show',compact('members'));
    }

    }


    public function create()
    {
        $user = auth()->user();
        $city = DB::table('cities')
            ->where('id', $user->city_id)
            ->value('Name');
            if( $city)
            {
                $cityName = $city;
            }
            else
            {
                $cityName =City::orderBy('Name','Asc')->get();
            }

        $qualifications = Qualification::whereNotNull('Name')->orderBy('Name','Asc')->get();
        $specializations = Qualification::whereNotNull('specialization')->orderBy('Name','Asc')->get();
        $occupations = Occupation::orderBy('Name','Asc')->get();

        if ( auth()->user()->Role == 'admin')
        {
            return view('admin.member.add', compact('cityName', 'qualifications', 'occupations'));
        }
       else if ( auth()->user()->Role == 'manager')
        {
            return view('manager.member.add', compact('cityName', 'qualifications', 'occupations'));
        }
    }
    public function getSpecializations($qualificationId)
    {
        $specializations = Qualification::where('parentId', $qualificationId)
                                        ->whereNotNull('specialization')
                                        ->orderBy('specialization', 'Asc')
                                        ->get();
    
        return response()->json($specializations);

    //     if ( auth()->user()->Role == 'admin')
    //     {
    //         return view('admin.member.add', compact('specializations'));
    //     }
    //    else if ( auth()->user()->Role == 'manager')
    //     {
    //         return view('manager.member.add', compact('specializations'));
    //     }
    }

    public function store(Request $request)
    {
      //  return dd($request->all());
        /*
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
            // 'qualification_id'=>'required',
            // 'occupation_id'=>'required'
        ]);
        */
        // store image
       
        
    
    $latestIDTeam = DB::table('members')->orderBy('IDTeam', 'desc')->first();
    if($latestIDTeam){
        $IDTeam = $latestIDTeam->IDTeam + 1;
    }
    else{
        $IDTeam = 1;
    }
    

//     $member= Member::create([

//     'NotPad'=>$request->NotPad,
//     'branch'=>$request->branch,
//     'IDTeam' =>$IDTeam++,
//     'FullName' => $request->FullName,
//     'MotherName' => $request->MotherName,
//     'PlaceOfBirth' => $request->PlaceOfBirth,
//     'BirthDate' => $request->BirthDate,
//     'Constraint' => $request->Constraint,
//     'City'=>$request->cityName,
//     'IDNumber' => $request->IDNumber,
//     'Gender' => $request->Gender == 'ذكر' ? 'ذكر' : 'أنثى',
//     'Qualification' =>$request->Qualification ,
//     'Occupation' => $request->Occupation,
//     'MobilePhone' => $request->MobilePhone ,
//     'HomeAddress' => $request->HomeAddress ,
//     'WorkAddress' => $request->WorkAddress ,
//     'HomePhone' => $request->Occupation,
//     'WorkPhone' => $request->MobilePhone ,
//     'DateOfJoin' => $request->DateOfJoin ,
//     'Specialization' => $request->Specialization ,
//     'Image' => $request->Image->getClientOriginalName(),
//     'qualification_id'=>$request->qualification_id,
//     'occupation_id'=>$request->occupation_id,
//     //user
//    'user_id'=>auth()->id()
// ]);


    // $cityName='';
    // $user = auth()->user();

    // $city = DB::table('cities')
    // ->where('id', $user->city_id)
    // ->value('Name');

    // if( $city)
    // {
    //     $cityName = $city;
    // }
    // else
    // {
    //     $cityName =City::orderBy('Name','Asc')->get();
    // }



    // Convert Birthdate format
  $birthDate = DateTime::createFromFormat('m/d/Y H:i',$request->BirthDate);
  $birthDateFormatted = $birthDate ? $birthDate->format('Y-m-d H:i:s') : null;

  // Convert DateOfJoin format
  $dateJoin = DateTime::createFromFormat('m/d/Y H:i',$request->DateOfJoin );
  $dateJoinFormatted = $dateJoin ? $dateJoin->format('Y-m-d H:i:s') : null;


  $qualificationId = $request->Qualification;
  $qualificationName = Qualification::where('id', $qualificationId)->first()->Name;
  
  
  $specializationId = $request->Specialization;
  $specializationName = Qualification::where('id', $specializationId)->first()->specialization;



    $member = new Member();
    
    $member->NotPad = $request->NotPad;
   
    $member->branch = $request->branch;
    $member->IDTeam  = $IDTeam;
    
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
    $member->DateOfJoin  = $dateJoinFormatted;
    
  
    // $member->user_id  = $user->id();

    // $member->qualification_id  = $request->qualification_id;
    // $member->occupation_id  = $request->occupation_id;

    $member->save();

    if($request->hasfile('Image')){
        $img = $request->file('Image');
        $img_name = $img->getClientOriginalName();
        $img->move(public_path('images'), $img_name);

      //  $member->Image  =   $img_name;
      //  $member->save();
        Member::find($member->id)->update([
        'Image'=> $img_name,
        ]);
    }

    session()->flash('Add', ' تم إضافة العضو بنجاح ورقمه الحزبي هو '.$IDTeam);
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

  
  public function edit($id)
  {
     $member = Member::findOrFail($id);

     $cities = City::orderBy('Name','Asc')->get();
     $qualifications = Qualification::whereNotNull('Name')->orderBy('Name','Asc')->get();
     $specializations = Qualification::whereNotNull('specialization')->orderBy('Name','Asc')->get();
     $occupations = Occupation::orderBy('Name','Asc')->get();

     if ( auth()->user()->Role == 'admin')
     {
      return view('admin.member.edit',compact('member', 'cities', 'qualifications', 'specializations', 'occupations'));
     }
    else if ( auth()->user()->Role == 'manager')
     {
      return view('manager.member.edit',compact('member', 'cities', 'qualifications', 'specializations', 'occupations'));
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

   $members =  Member::where('FullName', 'like', '%'.$searchTerm.'%')->orderBy('FullName', 'Asc')->get();
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    
    $members = Member::where('City', $cityName)->where('FullName', 'like', '%'.$searchTerm.'%')->orderBy('FullName', 'Asc')->get();
    return view('manager.member.show',compact('members'));
   }
    }


    public function searchByIDTeam(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

   $members =  Member::where('IDTeam', 'like', '%'.$searchTerm.'%')->orderBy('IDTeam', 'Asc')->get();

   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('IDTeam', 'like', '%'.$searchTerm.'%')->orderBy('IDTeam', 'Asc')->get();

    return view('manager.member.show',compact('members'));
   }
    }

    public function searchByQualification(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $members =  Member::where('Qualification', 'like', '%'.$searchTerm.'%')->orderBy('Qualification', 'Asc')->get();

   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Qualification', 'like', '%'.$searchTerm.'%')->orderBy('Qualification', 'Asc')->get();

    return view('manager.member.show',compact('members'));
   }
    }

    public function searchBySpecialization(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $members =  Member::where('Specialization', 'like', '%'.$searchTerm.'%')->orderBy('Specialization', 'Asc')->get();
   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Specialization', 'like', '%'.$searchTerm.'%')->orderBy('Specialization', 'Asc')->get();

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
 
    }

    
    public function searchByOccupation(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $members =  Member::where('Occupation', 'like', '%'.$searchTerm.'%')->orderBy('Occupation', 'Asc')->get();

   if ( auth()->user()->Role == 'admin')
   {
    return view('admin.member.show',compact('members'));
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Occupation', 'like', '%'.$searchTerm.'%')->orderBy('Occupation', 'Asc')->get();

    return view('manager.member.show',compact('members'));
   }
    }



 
    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
    
        foreach ($fileContents as $key => $line) {
            if ($key == 0) {
                continue; // Skip the first row (headers)
            }
    
            $data = str_getcsv($line);
    
            // Convert Birthdate format
            $birthDate = DateTime::createFromFormat('m/d/Y H:i', $data[6]);
            $birthDateFormatted = $birthDate ? $birthDate->format('Y-m-d H:i:s') : null;

                
            // Convert DateOfJoin format
            $dateJoin = DateTime::createFromFormat('m/d/Y H:i', $data[18]);
            $dateJoinFormatted = $dateJoin ? $dateJoin->format('Y-m-d H:i:s') : null;
    
            Member::create([
                'NotPad' => $data[0],
                'branch' => $data[1],
                'IDTeam' => $data[2],
                'FullName' => $data[3],
                'MotherName' => $data[4],
                'PlaceOfBirth' => $data[5],
                'BirthDate' => $birthDateFormatted,
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
                'DateOfJoin' => $dateJoinFormatted,
                'Specialization' => $data[19],
                'Image' => $data[20],
            ]);
        }
        session()->flash('Add', 'تم إستيراد البيانات بنجاح');
        return back();
    }
    

    public function exportDataToCSV(Request $request)
    {
        $data = $request->input('searchTerm');
    
        if ($data) {
            $members = Member::where('Name', 'like', '%' . $data . '%')
                ->orWhere('IDTeam', 'like', '%' . $data . '%')
                ->orWhere('Qualification', 'like', '%' . $data . '%')
                ->orWhere('Specialization', 'like', '%' . $data . '%')
                ->orWhere('City', 'like', '%' . $data . '%')
                ->orWhere('Occupation', 'like', '%' . $data . '%')
                ->get();
        } else {
            $members = Member::all();
        }
    
        $csvFileName = 'members.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];
    
        $handle = fopen('php://output', 'w');
        fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel
        fputcsv($handle, [
            'الملاحظات',
            'الفرع',
            'الرقم الحزبي',
            'الاسم الثلاثي',
            'اسم الأم',
            'مكان الولادة',
            'تاريخ الولادة',
            'محل ورقم القيد',
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
            'الاختصاص',
            'رابط الصورة',
        ]);
    
        foreach ($members as $member) {
            fputcsv($handle, [
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
            ]);
        }
    
        fclose($handle);
    
        return response()->make('', 200, $headers);
    }
    




public function GetCityWithMemberCount(Request $request)
{

    $searchTerm = $request->input('searchTerm');

    $members =  Member::where('City', 'like', $searchTerm)->count();
    
    // session()->put('members', $members);
    return view('admin.index',compact('members'));
}

  public function GetCityWithMember(Request $request)
   {
    $searchTerm = $request->input('searchTerm');
    $members =  Member::where('City', $searchTerm)->get();

//   $members =  Member::where('City', 'حلب')->get();
  
   return view('admin.show-members',compact('members'));
  }

}
