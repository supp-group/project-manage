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

use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
class MemberController extends Controller

{
public function index()
{ 
    if (optional(auth()->user())->Role == 'admin') {
        $members = Member::orderBy('updated_at', 'desc')->select('id','branch','IDTeam','FullName',
        'City')->paginate(50);
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
        return view('admin.member.show', [
            'members' => $members,
            'paginationLinks' => $paginationLinks
        ]);

  

    } elseif (optional(auth()->user())->Role == 'manager') {
        $user = auth()->user();
        $cityName = DB::table('cities')
            ->where('id', $user->city_id)
            ->value('Name');
        
        $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->paginate(50);
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
        return view('manager.member.show', [
            'members' => $members,
            'paginationLinks' => $paginationLinks
        ]);

    }
}

    public function orderBy_Last()
    { 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('created_at','desc')->paginate(50);
            $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
            return view('admin.member.show', [
                'members' => $members,
                'paginationLinks' => $paginationLinks
            ]);
        }
        elseif (optional(auth()->user())->Role == 'manager') {
            $user = auth()->user();
            $cityName = DB::table('cities')
                ->where('id', $user->city_id)
                ->value('Name');
            
            $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->paginate(50);
            $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
            return view('manager.member.show', [
                'members' => $members,
                'paginationLinks' => $paginationLinks
            ]);
         }
    }

    
    public function orderBy_Name()
    { 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('FullName','Asc')->paginate(50);
            $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
            return view('admin.member.show', [
                'members' => $members,
                'paginationLinks' => $paginationLinks
            ]);
        }
        elseif (optional(auth()->user())->Role == 'manager') {
            $user = auth()->user();
            $cityName = DB::table('cities')
                ->where('id', $user->city_id)
                ->value('Name');
            
            $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->paginate(50);
            $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
            return view('manager.member.show', [
                'members' => $members,
                'paginationLinks' => $paginationLinks
            ]);
    }
}

    public function orderBy_IDTeam()
    { 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('IDTeam','Asc')->paginate(50);
            $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
            return view('admin.member.show', [
                'members' => $members,
                'paginationLinks' => $paginationLinks
            ]);
        }
        elseif (optional(auth()->user())->Role == 'manager') {
            $user = auth()->user();
            $cityName = DB::table('cities')
                ->where('id', $user->city_id)
                ->value('Name');
            
            $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->paginate(50);
            $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
            return view('manager.member.show', [
                'members' => $members,
                'paginationLinks' => $paginationLinks
            ]);
        }
    }


    public function orderBy_DateOfJoin()
    { 
    if (optional(auth()->user())->Role == 'admin') 
    {
        $members = Member::orderBy('DateOfJoin','desc')->paginate(50);
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
        return view('admin.member.show', [
            'members' => $members,
            'paginationLinks' => $paginationLinks
        ]);
    }
    elseif (optional(auth()->user())->Role == 'manager') {
        $user = auth()->user();
        $cityName = DB::table('cities')
            ->where('id', $user->city_id)
            ->value('Name');
        
        $members = Member::where('City', $cityName)->orderBy('updated_at', 'desc')->paginate(50);
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
        return view('manager.member.show', [
            'members' => $members,
            'paginationLinks' => $paginationLinks
        ]);
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
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'NotPad' => 'required|max:255',
            'branch' => 'required',
            // 'IDTeam' => 'required|unique:members|max:255',
            'FullName' => 'required',
            'MotherName' => 'required',
            'PlaceOfBirth' => 'required',
            'BirthDate' => 'required|date|before:today',
            'Constraint' => 'required',
            'City' => 'required',
            'IDNumber' => 'required|unique:members|min:10|max:11',
            'Gender' => 'required',
            'Qualification' =>'required',
            'Occupation' => 'required',
            'MobilePhone' => 'required|max:10|min:9',
            'HomeAddress' => 'required',
            'WorkAddress' => 'required',
            'HomePhone' => 'required|max:10|min:9',
            'WorkPhone' => 'required|max:10|min:9',
            'DateOfJoin' => 'required|numeric|digits:4|before_or_equal:' . date('Y'),
            'Specialization' => 'required',
            'Image' =>'required',
        ]);


    //    return dd($request->all());
    // $messages =  [
    //     'NotPad.required' => 'يرجى ادخال الملاحظات الخاصة بالعضو ',
    //     'branch.required' => 'يرجى ادخال الفرع الذي ينتمي اليه العضو ',
    //     'FullName.required' => 'يرجى ادخال الاسم الثلاثي للعضو بشكل صحيح',
    //     'MotherName.required' => 'يرجى ادخال اسم الأم للعضو',
    //     'PlaceOfBirth.required' => 'يرجى ادخال مكتن الولادة للعضو',
    //     'BirthDate.required' => 'يرجى ادخال مواليد العضو بشكل صحيح',
    //     'Constraint.required' => 'يرجى ادخال محل ورقم القيد للعضو ',
    //     'City.required' => 'يرجى اخال المحافظة للعضو',
    //     'IDNumber.required' => 'يرجى ادخال الرقم الوطني للعضو',
    //     //'Gender.required' => 'يرجى',
    //     'Qualification.required' => 'يرجى ادخال المؤهل العلمي للعضو',
    //     'Occupation.required' => 'يرجى اخال مهنة العضو',
    //     'MobilePhone.required' => 'يرجى ادخال رقم الموبايل للعضو',
    //     'HomeAddress.required' => 'يرجى اخال عنوان المنزل للعضو',
    //     'WorkAddress.required' => 'يرجى اخال عنوان العمل للعضو ',
    //     'HomePhone.required' => 'يرجى ادخال هاتف المنزل للعضو',
    //     'WorkPhone.required' => 'يرجى ادخال هاتف العمل للعضو',
    //     'DateOfJoin.required' => 'يرجى ادخال تاريخ الانضمام للعضو',
    //     'Specialization.required' => 'يرجى ادخال التخصص للعضو',
    // ];
    
    // $validator = Validator::make($request->all(), [
    //         'NotPad' => 'required|max:255',
    //         'branch' => 'required',
    //         // 'IDTeam' => 'required|unique:members|max:255',
    //         'FullName' => 'required',
    //         'MotherName' => 'required',
    //         'PlaceOfBirth' => 'required',
    //         'BirthDate' => 'required|date|before:today',
    //         'Constraint' => 'required',
    //         'City' => 'required',
    //         'IDNumber' => 'required|unique:members|min:11|max:11',
    //         'Gender' => 'required',
    //         'Qualification' =>'required',
    //         'Occupation' => 'required',
    //         'MobilePhone' => 'required|max:10',
    //         'HomeAddress' => 'required',
    //         'WorkAddress' => 'required',
    //         'HomePhone' => 'required|max:10',
    //         'WorkPhone' => 'required|max:10',
    //         'DateOfJoin' => 'required|date|before_or_equal:today',
    //         'Specialization' => 'required',
    //         'Image' =>'required',
    //         // 'qualification_id'=>'required',
    //         // 'occupation_id'=>'required'
    //     // ], $messages);
    // ]);


    // for increment IDTeam automatically when adding a new member
    $latestIDTeam = DB::table('members')->orderBy('IDTeam', 'desc')->first();
    if($latestIDTeam){
        $IDTeam = $latestIDTeam->IDTeam + 1;
    }
    else{
        $IDTeam = 1;
    }
    

  // Convert Birthdate format
  $birthDate = DateTime::createFromFormat('m/d/Y',$request->BirthDate);
  $birthDateFormatted = $birthDate ? $birthDate->format('Y-m-d') : $request->BirthDate;

  // Convert DateOfJoin format
  $dateJoin = DateTime::createFromFormat('Y',$request->DateOfJoin );
  $dateJoinFormatted = $dateJoin ? $dateJoin->format('Y') : null;


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
    // $member->BirthDate = $request->BirthDate;
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
    // $member->DateOfJoin  = $request->DateOfJoin;
    $member->save();

    // store image
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
  }

  
  public function edit($id)
  {
     $member = Member::findOrFail($id);

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
      return view('admin.member.edit',compact('member', 'cityName', 'qualifications', 'specializations', 'occupations'));
     }
    else if ( auth()->user()->Role == 'manager')
     {
      return view('manager.member.edit',compact('member', 'cityName', 'qualifications', 'specializations', 'occupations'));
     }
  }

  
  public function update(Request $request, $id): RedirectResponse
  {
    // $validated = $request->validate([
    //     'NotPad' => 'required|max:255',
    //     'branch' => 'required',
    //     // 'IDTeam' => 'required|unique:members|max:255',
    //     'FullName' => 'required',
    //     'MotherName' => 'required',
    //     'PlaceOfBirth' => 'required',
    //     'BirthDate' => 'required|date|before:today',
    //     'Constraint' => 'required',
    //     'City' => 'required',
    //     'IDNumber' => 'required|unique:members|min:11|max:11',
    //     'Gender' => 'required',
    //     'Qualification' =>'required',
    //     'Occupation' => 'required',
    //     'MobilePhone' => 'required|max:10',
    //     'HomeAddress' => 'required',
    //     'WorkAddress' => 'required',
    //     'HomePhone' => 'required|max:10',
    //     'WorkPhone' => 'required|max:10',
    //     'DateOfJoin' => 'required|date|before_or_equal:today',
    //     'Specialization' => 'required',
    //     'Image' =>'required',
    // ]);
  
  // Convert Birthdate format
  $birthDate = DateTime::createFromFormat('m/d/Y',$request->BirthDate);
  $birthDateFormatted = $birthDate ? $birthDate->format('Y-m-d') : $request->BirthDate;

  // Convert DateOfJoin format
  $dateJoin = DateTime::createFromFormat('Y',$request->DateOfJoin );
  $dateJoinFormatted = $dateJoin ? $dateJoin->format('Y') : null;


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
$member = Member::findOrFail($id);
$member->NotPad = $request->NotPad;
$member->branch = $request->branch;
// $member->IDTeam  = $IDTeam;
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
$member->update();



    // store image
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

    session()->flash('Edit', 'تم تعديل العضو بنجاح');
    return back(); 
  }


  public function destroy( $id)
    {
       Member::findOrFail($id)->delete();

       session()->flash('delete', 'تم حذف العضو بنجاح');
       return back(); 
    }


     public function searchByName(Request $request)
    {
        $searchTerm = $request->input('search_FullName');

   if ( auth()->user()->Role == 'admin')
   {
   $members =  Member::where('FullName', 'like', '%'.$searchTerm.'%')->orderBy('FullName', 'Asc')->paginate(50);

    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);

   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    
    $members = Member::where('City', $cityName)->where('FullName', 'like', '%'.$searchTerm.'%')->orderBy('FullName', 'Asc')->paginate(50);
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
    }


    public function searchByIDTeam(Request $request)
    {
        $searchTerm = $request->input('search_IDTeam');
   if ( auth()->user()->Role == 'admin')
   {
    $members =  Member::where('IDTeam', 'like', '%'.$searchTerm.'%')->orderBy('IDTeam', 'Asc')->paginate(50);
   
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('IDTeam', 'like', '%'.$searchTerm.'%')->orderBy('IDTeam', 'Asc')->paginate(50);
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
    }


    public function searchByQualification(Request $request)
    {
        $searchTerm = $request->input('search_Qualification');
   if ( auth()->user()->Role == 'admin')
   {
    $members =  Member::where('Qualification', 'like', '%'.$searchTerm.'%')->orderBy('Qualification', 'Asc')->paginate(50);
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Qualification', 'like', '%'.$searchTerm.'%')->orderBy('Qualification', 'Asc')->paginate(50);

    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
    }


    public function searchBySpecialization(Request $request)
    {
        $searchTerm = $request->input('search_Specialization');
   if ( auth()->user()->Role == 'admin')
   {
    $members =  Member::where('Specialization', 'like', '%'.$searchTerm.'%')->orderBy('Specialization', 'Asc')->paginate(50);

    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Specialization', 'like', '%'.$searchTerm.'%')->orderBy('Specialization', 'Asc')->paginate(50);
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
    }


    public function searchByCity(Request $request)
    {
        $searchTerm = $request->input('search_City');

    $members =  Member::where('City', 'like', '%'.$searchTerm.'%')->paginate(50);

    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
}

    
    public function searchByOccupation(Request $request)
    {
        $searchTerm = $request->input('search_Occupation');

   if ( auth()->user()->Role == 'admin')
   {
    $members =  Member::where('Occupation', 'like', '%'.$searchTerm.'%')->orderBy('Occupation', 'Asc')->paginate(50);

    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Occupation', 'like', '%'.$searchTerm.'%')->orderBy('Occupation', 'Asc')->paginate(50);

    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'paginationLinks' => $paginationLinks
    ]);
   }
    }


 
    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
    
        foreach ($fileContents as $key => $line) {
            if ($key == 0 ||$key=='فارغ'||$key=='') {
                continue; // Skip the first row (headers)
            }
    
            $data = str_getcsv($line);
    
            // Convert Birthdate format
            // $birthDate = DateTime::createFromFormat('d/m/Y', $data[6]);
            // $birthDateFormatted = $birthDate ? $birthDate->format('Y-m-d') : null;

                
            // Convert DateOfJoin format
            // $dateJoin = DateTime::createFromFormat('Y', $data[18]);
            // $dateJoinFormatted = $dateJoin ? $dateJoin->format('Y') : null;
    
            // var_dump( $data[13]);

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
            ]);
        }
        session()->flash('Add', 'تم إستيراد البيانات بنجاح');
        return back();
    }
    

    public function exportDataToCSV(Request $request)
    {

        $searchName = $request->input('search_FullName');
        $searchIDTeam = $request->input('search_IDTeam');
        $searchQualification = $request->input('search_Qualification');
        $searchSpecialization = $request->input('search_Specialization');
        $searchCity = $request->input('search_City');
        $searchOccupation = $request->input('search_Occupation');


if($request->input('search_FullName') )
{
    $data = Member::where('FullName', 'like', '%' . $searchName . '%')->get();
}
elseif($searchIDTeam)
{
    $data = Member::where('IDTeam', 'like', '%' . $searchIDTeam . '%')->get();
}
elseif($searchQualification)
{
    $data = Member::where('Qualification', 'like', '%' . $searchQualification . '%')->get();
}
elseif($searchSpecialization)
{
    $data = Member::where('Specialization', 'like', '%' . $searchSpecialization . '%')->get();
}
elseif($searchCity)
{
    $data = Member::where('City', 'like', '%' . $searchCity . '%')->get();
}
elseif($searchOccupation)
{
    $data = Member::where('Occupation', 'like', '%' . $searchOccupation . '%')->get();
}
else{
    $data = '';
}
        // $data = Member::query()
        //     ->when($searchName, function ($query) use ($searchName) {
        //         $query->where('FullName', 'like', '%' . $searchName . '%');
        //     })
        //     ->when($searchIDTeam, function ($query) use ($searchIDTeam) {
        //         $query->where('IDTeam', 'like', '%' . $searchIDTeam . '%');
        //     })
        //     ->when($searchQualification, function ($query) use ($searchQualification) {
        //         $query->where('Qualification', 'like', '%' . $searchQualification . '%');
        //     })
        //     ->when($searchSpecialization, function ($query) use ($searchSpecialization) {
        //         $query->where('Specialization', 'like', '%' . $searchSpecialization . '%');
        //     })
        //     ->when($searchCity, function ($query) use ($searchCity) {
        //         $query->where('City', 'like', '%' . $searchCity . '%');
        //     })
        //     ->when($searchOccupation, function ($query) use ($searchOccupation) {
        //         $query->where('Occupation', 'like', '%' . $searchOccupation . '%');
        //     })
        //     ->get();
           
     return dd($data);

        // $data = $request->input('searchTerm');

        // $query = Member::query(); // Start with a base query
    
        // // Only apply filters if $data is not null or not empty
        // if (!empty($data)) {
        //     $query->where(function ($q) use ($data) {
        //         $q->where('FullName', 'like', '%' . $data . '%')
        //             ->orWhere('IDTeam', 'like', '%' . $data . '%')
        //             ->orWhere('Qualification', 'like', '%' . $data . '%')
        //             ->orWhere('Specialization', 'like', '%' . $data . '%')
        //             ->orWhere('City', 'like', '%' . $data . '%')
        //             ->orWhere('Occupation', 'like', '%' . $data . '%');
        //     });
        // }
    
        // $members = $query->get(); // Execute the query
    
    
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
    
        foreach ($data as $member) {
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

    
    // public function GetCityWithMemberCount(Request $request)
    // {
    //     $searchTerm = $request->input('searchTerm');
    //     $membersCount = Member::where('City', 'like', $searchTerm)->count();
        
    //     return view('admin.index', compact('membersCount'));
    // }
    


public function GetCityWithMemberCount(Request $request)
{
    // $searchTerm = $request->input('searchTerm');
    $members =  Member::where('City', 'like', 'حلب')->count();
    
    if($members)
        return view('admin.index', compact('members'));
    else
        return view('404');
}

// public function getMembersCountByCity()
// {
//     $membersCountByCity = Member::select('City', DB::raw('count(*) as count'))
//         ->groupBy('City')
//         ->get();

//     return view('admin.index', ['membersCountByCity' => $membersCountByCity]);
// }

  public function GetCityWithMember(Request $request)
   {
    $searchTerm = $request->input('searchTerm');
    $members =  Member::where('City', $searchTerm)->get();

//   $members =  Member::where('City', 'حلب')->get();
  
   return view('admin.show-members',compact('members'));
  }


  public function details($id)
  {
     $member = Member::where('id',$id)->first();

     if ( auth()->user()->Role == 'admin')
     {
      return view('admin.member.details',compact('member'));
     }
    else if ( auth()->user()->Role == 'manager')
     {
      return view('manager.member.details',compact('member'));
     }
  }

}
