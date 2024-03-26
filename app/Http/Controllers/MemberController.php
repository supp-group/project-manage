<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TemporaryController;
use App\Models\City;
use App\Models\Member;
use App\Models\Temporary;
use App\Models\Occupation;
use App\Models\Qualification;
use App\Models\User;
use Auth;
use DateTime;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
// use Intervention\Image\ImageManagerStatic as Image;
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
        $city = City::whereNotNull('Name')->orderBy('Name','Asc')->get();
        $areas = City::whereNotNull('area')->orderBy('area','Asc')->get();
        $streets = City::whereNotNull('street')->orderBy('street','Asc')->get();
        $branch =City::whereNotNull('branch')->orderBy('branch','Asc')->get();
        $qualifications = Qualification::whereNotNull('Name')->orderBy('Name','Asc')->get();
        $specializations = Qualification::whereNotNull('specialization')->orderBy('Name','Asc')->get();
        $occupations = Occupation::orderBy('Name','Asc')->get();


        $members = Member::orderBy('IDTeam', 'Asc')->select('id','branch','IDTeam','FirstName','LastName',
        'City')->paginate(50);
        $memberCount = Member::count();
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');

        return view('admin.member.show', [
            'city' => $city,
            'areas' => $areas,
            'streets' => $streets,
             'branch'=>$branch,
            'qualifications' => $qualifications,
            'specializations' => $specializations,
            'occupations' => $occupations,

            'members' => $members,
            'memberCount'=>$memberCount,
            'paginationLinks' => $paginationLinks
        ]);
    }

    elseif (optional(auth()->user())->Role == 'manager') {
        $user = auth()->user();
        $cityName = DB::table('cities')
            ->where('id', $user->city_id)
            ->value('Name');
        
        $members = Member::where('City', $cityName)->orderBy('IDTeam', 'Asc')->paginate(50);
        $branch =Member::where('branch', 'like', '%'.$cityName.'%')->first();
        $memberCount = Member::where('City', $cityName)->count();
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');

        return view('manager.member.show', [
            'members' => $members,
            'memberCount'=>$memberCount,
             'branch'=>$branch,
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
            $members = Member::orderBy('FirstName','Asc')->paginate(50);
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

public function orderBy_LastName()
{ 
        if (optional(auth()->user())->Role == 'admin') 
        {
            $members = Member::orderBy('LastName','Asc')->paginate(50);
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
            if($city)
            {
               $cityName = $city;
               $branch = City::where('branch', 'like', '%' . $cityName . '%')->pluck('branch')->first();

            //    $branch =City::where('branch','like', '%'.$cityName.'%')->select('branch')->get();
               $areas = City::where('parentId', $user->city_id)->whereNotNull('area')->orderBy('area','Asc')->get();
               $streets = City::where('grandId', $user->city_id)->whereNotNull('street')->orderBy('street','Asc')->get();
            }
            else
            {
                $cityName =City::whereNotNull('Name')->orderBy('Name','Asc')->get();
                $branch =City::whereNotNull('branch')->orderBy('branch','Asc')->get();
                $areas = City::whereNotNull('area')->orderBy('area','Asc')->get();
                $streets = City::whereNotNull('street')->orderBy('street','Asc')->get();

            }
      
        $qualifications = Qualification::whereNotNull('Name')->orderBy('Name','Asc')->get();
        $specializations = Qualification::whereNotNull('specialization')->orderBy('Name','Asc')->get();
        $occupations = Occupation::orderBy('Name','Asc')->get();

        if ( auth()->user()->Role == 'admin')
        {
            return view('admin.member.add', compact('cityName', 'qualifications', 'occupations', 'areas', 'streets','branch'));
        }
       else if ( auth()->user()->Role == 'manager')
        {
            return view('manager.member.add', compact('cityName', 'qualifications', 'occupations','branch', 'areas', 'streets'));
        }
}

public function store(Request $request): RedirectResponse
{
        $validated = $request->validate([
            'NotPad' => 'required|max:255',
            'branch' => 'required',
            'IDTeam' => 'required|unique:members|max:255',
            'FirstName' => 'required',
            'LastName' => 'required',
            'FatherName' => 'required',
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
            'area' => 'required',
            'street' => 'required',
            'Image' =>'required',
        ]);

    // for increment IDTeam automatically when adding a new member
    // $latestIDTeam = DB::table('members')->orderBy('IDTeam', 'desc')->first();
    // if($latestIDTeam){
    //     $IDTeam = $latestIDTeam->IDTeam + 1;
    // }
    // else{
    //     $IDTeam = 1;
    // }
    
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



  $cityId = $request->City;

  if (is_numeric($cityId)) {
      // إذا كانت القيمة هي id
      $cityName = City::where('id', $cityId)->value('Name');
  } else {
      // إذا كانت القيمة هي اسم
      $cityName = $cityId;
  }


  //   $cityId = $request->City;
  //   $cityName = City::where('id', $cityId)->first()->Name;



  $areaId = $request->area;
  $areaName = City::where('id', $areaId)->first()->area;

  $streetId = $request->street;
  $streetName = City::where('id', $streetId)->first()->street;


    $member = new Member(); 
    $member->NotPad = $request->NotPad;
    $member->branch = $request->branch;
    $member->IDTeam  = $request->IDTeam;
   // $member->IDTeam  = $IDTeam;
    $member->FirstName = $request->FirstName;
    $member->LastName = $request->LastName;
    $member->FatherName = $request->FatherName;

    $member->MotherName = $request->MotherName;
    $member->PlaceOfBirth = $request->PlaceOfBirth;
    $member->BirthDate = $birthDateFormatted;
    // $member->BirthDate = $request->BirthDate;
    $member->Constraint = $request->Constraint;
    $member->City = $cityName;
    $member->area = $areaName;
    $member->street = $streetName;

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
    if($request->hasFile('Image')){
        $newImage = $request->file('Image');
        //$newImageName = $img->getClientOriginalName();
        //for change image name
        $newImageName = 'image_' . $member->id . '.' . $newImage->getClientOriginalExtension();
        $newImage->move('assets/img/media/', $newImageName);

        Member::find($member->id)->update([
            'Image'=> $newImageName,
        ]);
   }
    
 //    session()->flash('Add', ' تم إضافة العضو بنجاح ورقمه الحزبي هو '.$IDTeam);

    session()->flash('Add', ' تم إضافة العضو بنجاح ورقمه الحزبي هو '.$request->IDTeam);
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
            $branch = City::where('branch', 'like', '%' . $cityName . '%')->pluck('branch')->first();
            $areas = City::where('parentId', $user->city_id)->whereNotNull('area')->orderBy('area','Asc')->get();
            $streets = City::where('grandId', $user->city_id)->whereNotNull('street')->orderBy('street','Asc')->get();
        }
        else
        {
            $cityName =City::whereNotNull('Name')->orderBy('Name','Asc')->get();
            $branch =City::whereNotNull('branch')->orderBy('branch','Asc')->get();
            $areas = City::whereNotNull('area')->orderBy('area','Asc')->get();
            $streets = City::whereNotNull('street')->orderBy('street','Asc')->get();
        }

     $qualifications = Qualification::whereNotNull('Name')->orderBy('Name','Asc')->get();
     $specializations = Qualification::whereNotNull('specialization')->orderBy('Name','Asc')->get();
     $occupations = Occupation::orderBy('Name','Asc')->get();

     if ( auth()->user()->Role == 'admin')
     {
      return view('admin.member.edit',compact('member', 'cityName', 'qualifications', 'specializations', 'occupations', 'areas', 'streets','branch'));
     }
    else if ( auth()->user()->Role == 'manager')
     {
      return view('manager.member.edit',compact('member', 'cityName', 'qualifications', 'specializations', 'occupations','branch'));
     }
}

  
public function updateForNotice(Request $request, $IDTeam)
{
  
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


  $city = $request->City;

  if (is_numeric($city)) {
      // إذا كانت القيمة هي id
      $cityName = City::where('id', $city)->value('Name');
  } else {
      // إذا كانت القيمة هي اسم
      $cityName = $city;
  }
  
   $area = $request->area;

  if (is_numeric($area)) {
      // إذا كانت القيمة هي id
      $areaName = City::where('id', $area)->value('area');

  } else {
      // إذا كانت القيمة هي اسم
      $areaName = $area;
  }

  $street = $request->street;

  if (is_numeric($street)) {
      // إذا كانت القيمة هي id
      $streetName = City::where('id', $street)->value('street');

  } else {
      // إذا كانت القيمة هي اسم
      $streetName = $street;
  }



  $member = Member::where('IDTeam',$IDTeam)->first();
  // return($member);
  $oldImageName=$member->Image;
  $member->NotPad = $request->NotPad;
  $member->branch = $request->branch;
  $member->IDTeam  = $IDTeam;
  $member->FirstName = $request->FirstName;
  $member->LastName = $request->LastName;
  $member->FatherName = $request->FatherName;
  $member->MotherName = $request->MotherName;
  $member->PlaceOfBirth = $request->PlaceOfBirth;
  $member->BirthDate = $birthDateFormatted;
  $member->Constraint = $request->Constraint;
  $member->City = $cityName;
  $member->area = $areaName;
  $member->street = $streetName;

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
   // store newImage
  if ($request->hasFile('Image')) {
    // Delete the old image from server
    if ($oldImageName) {
       // Storage::delete('public/assets/img/media/' . $oldImageName);
       File::delete('assets/img/media/'. $oldImageName);
    }

    // Upload new image
    $newImage = $request->file('Image');
    $newImageName = 'image_' . $member->id . '.' . $newImage->getClientOriginalExtension();
    $newImage->move('assets/img/media/', $newImageName);

    // Update the image record with the new image name
    $member->update(['Image' => $newImageName]);
  }


    //Temporary::where($request->IDTeam)->get('AdminAgree')->set('1');
    Temporary::where('IDTeam', $request->IDTeam)->update(['AdminAgree' => 1]);

    session()->flash('Add', 'تم تعديل العضو بنجاح');
    return redirect()->route('edit');
}

public function update(Request $request, $id)
{
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

  $city = $request->City;

  if (is_numeric($city)) {
      // إذا كانت القيمة هي id
      $cityName = City::where('id', $city)->value('Name');
  } else {
      // إذا كانت القيمة هي اسم
      $cityName = $city;
  }
   
   $area = $request->area;

  if (is_numeric($area)) {
      // إذا كانت القيمة هي id
      $areaName = City::where('id', $area)->value('area');

  } else {
      // إذا كانت القيمة هي اسم
      $areaName = $area;
  }

  $street = $request->street;

  if (is_numeric($street)) {
      // إذا كانت القيمة هي id
      $streetName = City::where('id', $street)->value('street');

  } else {
      // إذا كانت القيمة هي اسم
      $streetName = $street;
  }

  $member = Member::findOrFail($id);
  $oldImageName=$member->Image;
  $member->NotPad = $request->NotPad;
  $member->branch = $request->branch;
  $member->FirstName = $request->FirstName;
  $member->LastName = $request->LastName;
  $member->FatherName = $request->FatherName;
  $member->MotherName = $request->MotherName;
  $member->PlaceOfBirth = $request->PlaceOfBirth;
  $member->BirthDate = $birthDateFormatted;
  $member->Constraint = $request->Constraint;
  $member->City = $cityName;
  $member->area = $areaName;
  $member->street = $streetName;
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
 //   $member->update();

  // Store newImage
  if ($request->hasFile('Image')) {
    // Delete the old image from the server
    if ($oldImageName) {
         // Storage::delete('public/assets/img/media/' . $oldImageName);
         File::delete('assets/img/media/' . $oldImageName);
    }
    // Upload new image
    $newImage = $request->file('Image');
    $newImageName = 'image_' . $member->id . '.' . $newImage->getClientOriginalExtension();
    $newImage->move('assets/img/media/', $newImageName);

    // Update the image record with the new image name
    // $member->update(['Image' => $newImageName]);
    $member->Image = $newImageName;
  }
    $member->update();

    session()->flash('Edit', 'تم تعديل العضو بنجاح');
    return back(); 
}


public function destroy($id)
{
       Member::findOrFail($id)->delete();

       session()->flash('delete', 'تم حذف العضو بنجاح');
       return back(); 
}

public function destroyForNotice($IDTeam)
{
       Member::where('IDTeam', $IDTeam)->delete();
       Temporary::where('IDTeam', $IDTeam)->where('operation', '0')->delete();
       
       session()->flash('Add', 'تم حذف العضو بنجاح');
       return redirect()->route('delete');
}

public function searchByName(Request $request)
{
        $searchTerm = $request->input('search_FirstName');

   if ( auth()->user()->Role == 'admin')
   {
    $members =  Member::where('FirstName', 'like', '%'.$searchTerm.'%')->orderBy('FirstName', 'Asc')->paginate(50);
    $memberCount =  Member::where('FirstName', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    
    return view('admin.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    
    $members = Member::where('City', $cityName)->where('FirstName', 'like', '%'.$searchTerm.'%')->orderBy('FirstName', 'Asc')->paginate(50);
    $memberCount = Member::where('City', $cityName)->where('FirstName', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    
    return view('manager.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
   }
}

public function searchByLastName(Request $request)
{
        $searchTerm = $request->input('search_LastName');

   if ( auth()->user()->Role == 'admin')
   {
    $members =  Member::where('LastName', 'like', '%'.$searchTerm.'%')->orderBy('LastName', 'Asc')->paginate(50);
    $memberCount =  Member::where('LastName', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    
    return view('admin.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    
    $members = Member::where('City', $cityName)->where('LastName', 'like', '%'.$searchTerm.'%')->orderBy('LastName', 'Asc')->paginate(50);
    $memberCount = Member::where('City', $cityName)->where('LastName', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    
    return view('manager.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
   }
}

public function searchByPhoneNull()
{
   if ( auth()->user()->Role == 'admin')
   {
    $members =  Member::where('MobilePhone',Null)->orwhere('MobilePhone','')->orderBy('FirstName', 'Asc')->paginate(50);
    $memberCount =  Member::where('MobilePhone',Null)->orwhere('MobilePhone','')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    
    return view('admin.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);

   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    
    $members = Member::where('City', $cityName)->where('MobilePhone',Null)->orwhere('MobilePhone','')->orderBy('FirstName', 'Asc')->paginate(50);
    $memberCount = Member::where('City', $cityName)->where('MobilePhone',Null)->orwhere('MobilePhone','')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    
    return view('manager.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
   }
}

    public function searchByIDTeam(Request $request)
{
        $searchTerm = $request->input('search_IDTeam');
   if ( auth()->user()->Role == 'admin')
   {
    $members =  Member::where('IDTeam', 'like', $searchTerm)->orderBy('IDTeam', 'Asc')->paginate(50);
    $memberCount =  Member::where('IDTeam', 'like',$searchTerm)->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('IDTeam', 'like',$searchTerm)->orderBy('IDTeam', 'Asc')->paginate(50);
    $memberCount = Member::where('City', $cityName)->where('IDTeam', 'like',$searchTerm)->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
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
          $memberCount =  Member::where('Qualification', 'like', '%'.$searchTerm.'%')->count();
          $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
           return view('admin.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
          ]);
        }
      elseif (optional(auth()->user())->Role == 'manager') {
      $user = auth()->user();
      $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Qualification', 'like', '%'.$searchTerm.'%')->orderBy('Qualification', 'Asc')->paginate(50);
    $memberCount = Member::where('City', $cityName)->where('Qualification', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
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
    $memberCount =  Member::where('Specialization', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
   }
   elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Specialization', 'like', '%'.$searchTerm.'%')->orderBy('Specialization', 'Asc')->paginate(50);
    $memberCount = Member::where('City', $cityName)->where('Specialization', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
   }
}

public function searchByArea(Request $request)
{
    $searchTerm = $request->input('search_Area');
    if ( auth()->user()->Role == 'admin')
    {
        $members =  Member::where('area', 'like', '%'.$searchTerm.'%')->orderBy('area', 'Asc')->paginate(50);
        $memberCount =  Member::where('area', 'like', '%'.$searchTerm.'%')->count();
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');

    return view('admin.member.show', [
    'members' => $members,
    'memberCount'=>$memberCount,
    'paginationLinks' => $paginationLinks
    ]);
    }
    elseif (optional(auth()->user())->Role == 'manager') {
        $user = auth()->user();
        $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
        $members = Member::where('City', $cityName)->where('area', 'like', '%'.$searchTerm.'%')->orderBy('area', 'Asc')->paginate(50);
        $memberCount = Member::where('City', $cityName)->where('area', 'like', '%'.$searchTerm.'%')->count();
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');

    return view('manager.member.show', [
    'members' => $members,
    'memberCount'=>$memberCount,
    'paginationLinks' => $paginationLinks
    ]);
    }
}

public function searchBystreet(Request $request)
{
    $searchTerm = $request->input('search_Street');
    if ( auth()->user()->Role == 'admin')
    {
        $members =  Member::where('street', 'like', '%'.$searchTerm.'%')->orderBy('street', 'Asc')->paginate(50);
        $memberCount =  Member::where('street', 'like', '%'.$searchTerm.'%')->count();
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');

    return view('admin.member.show', [
    'members' => $members,
    'memberCount'=>$memberCount,
    'paginationLinks' => $paginationLinks
    ]);
    }
    elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
    ->where('id', $user->city_id)
    ->value('Name');
    $members = Member::where('City', $cityName)->where('street', 'like', '%'.$searchTerm.'%')->orderBy('street', 'Asc')->paginate(50);
    $memberCount = Member::where('City', $cityName)->where('street', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');

    return view('manager.member.show', [
    'members' => $members,
    'memberCount'=>$memberCount,
    'paginationLinks' => $paginationLinks
    ]);
    }
}

public function searchByCity(Request $request)
{
        $searchTerm = $request->input('search_City');

    $members =  Member::where('City', 'like', '%'.$searchTerm.'%')->paginate(50);
    $memberCount =  Member::where('City', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('admin.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
    ]);
}
    
public function searchByOccupation(Request $request)
{
        $searchTerm = $request->input('search_Occupation');

    if ( auth()->user()->Role == 'admin')
     {
      $members =  Member::where('Occupation', 'like', '%'.$searchTerm.'%')->orderBy('Occupation', 'Asc')->paginate(50);
      $memberCount =  Member::where('Occupation', 'like', '%'.$searchTerm.'%')->count();
      $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
        return view('admin.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'paginationLinks' => $paginationLinks
      ]);
    }
     elseif (optional(auth()->user())->Role == 'manager') {
    $user = auth()->user();
    $cityName = DB::table('cities')
        ->where('id', $user->city_id)
        ->value('Name');
    $members = Member::where('City', $cityName)->where('Occupation', 'like', '%'.$searchTerm.'%')->orderBy('Occupation', 'Asc')->paginate(50);
    $memberCount = Member::where('City', $cityName)->where('Occupation', 'like', '%'.$searchTerm.'%')->count();
    $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');
    return view('manager.member.show', [
        'members' => $members,
        'memberCount'=>$memberCount,
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
                'FirstName' => $data[3],
                'LastName' => $data[4],
                'FatherName' => $data[5],
                'MotherName' => $data[6],
                'PlaceOfBirth' => $data[7],
                'BirthDate' => $data[8],
                'Constraint' => $data[9],
                'City' => $data[10],
                'IDNumber' => $data[11],
                'Gender' => $data[12],
                'Qualification' => $data[13],
                'Occupation' => $data[14],
                'MobilePhone' => $data[15],
                'HomeAddress' => $data[16],
                'WorkAddress' => $data[17],
                'HomePhone' => $data[18],
                'WorkPhone' => $data[19],
                'DateOfJoin' => $data[20],
                'Specialization' => $data[21],
                'Image' => $data[22],
            ]);
        }
        session()->flash('Add', 'تم إستيراد البيانات بنجاح');
        return back();
}
    

public function exportDataToCSV(Request $request)
{

        $searchFirstName = $request->input('search_FirstName');
        $searchLastName = $request->input('search_LastName');
        $searchIDTeam = $request->input('search_IDTeam');
        $searchQualification = $request->input('search_Qualification');
        $searchSpecialization = $request->input('search_Specialization');
        $searchCity = $request->input('search_City');
        $searchOccupation = $request->input('search_Occupation');


  if($request->input('search_FirstName') )
  {
    $data = Member::where('FirstName', 'like', '%' . $searchFirstName . '%')->get();
  }
  elseif($searchLastName)
   {
    $data = Member::where('LastName', 'like', '%' . $searchLastName . '%')->get();
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
    $data = Member::get();
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
           
    //  return dd($data);

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

public function getMembersCountByCity()
{
    $membersCountByCity = Member::select('City', DB::raw('count(*) as count'))
        ->groupBy('City')
        ->get();

    return view('admin.index', ['membersCountByCity' => $membersCountByCity]);
}

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

public function detailsForCompare($IDTeam)
{
    $memb = Temporary::where('IDTeam',$IDTeam)->where('operation','1')->where('AdminAgree', 0)->first();
    $member = Member::where('IDTeam',$IDTeam)->first();
  //  $temctrlr=new TemporaryController();
 //   $temctrlr->getDeletedMember()
    return view('admin.notice.editDetails',compact('member','memb'));
}

public function getSpecializations($qualificationId)
{
    $specializations = Qualification::where('parentId', $qualificationId)
                                  ->whereNotNull('specialization')
                                  ->orderBy('specialization', 'Asc')
                                  ->get();
    return response()->json($specializations);
}

public function AdvancedIndex()
{
    if (optional(auth()->user())->Role == 'admin') {
  
    $city =City::whereNotNull('Name')->orderBy('Name','Asc')->get();
    $areas = City::whereNotNull('area')->orderBy('area','Asc')->get();
    $streets = City::whereNotNull('street')->orderBy('street','Asc')->get();

    $qualifications = Qualification::whereNotNull('Name')->orderBy('Name','Asc')->get();
    $specializations = Qualification::whereNotNull('specialization')->orderBy('Name','Asc')->get();
    $occupations = Occupation::orderBy('Name','Asc')->get();

        
        return view('admin.member.Advancedsearch', [
            'city'=>$city,
            'areas'=>$areas,
            'streets'=>$streets,
            
            'qualifications'=>$qualifications,
            'specializations'=>$specializations,
            'occupations'=>$occupations,
        ]);
    }
}

public function Advancedsearch(Request $request)
{
    $results = Member::query();
    $city =City::whereNotNull('Name')->orderBy('Name','Asc')->get();
    $areas = City::whereNotNull('area')->orderBy('area','Asc')->get();
    $streets = City::whereNotNull('street')->orderBy('street','Asc')->get();

    $qualifications = Qualification::whereNotNull('Name')->orderBy('Name','Asc')->get();
    $specializations = Qualification::whereNotNull('specialization')->orderBy('Name','Asc')->get();
    $occupations = Occupation::orderBy('Name','Asc')->get();

        $members = Member::orderBy('IDTeam', 'Asc')->select('id','branch','IDTeam','FirstName','LastName',
        'City')->paginate(50);
        $memberCount = Member::count();
        $paginationLinks = $members->withQueryString()->links('pagination::bootstrap-4');




    if ($request->City != 0) {
        $cityId = $request->City;
        $cityName = City::where('id', $cityId)->first()->Name;
        $results->where('City', $cityName);
    }

    if ($request->area != 0) {
        $areaId = $request->area;
        $areaName = City::where('id', $areaId)->first()->area;
        $results->where('area', $areaName);
    }

    if ($request->street != 0) {
        $streetId = $request->street;
        $streetName = City::where('id', $streetId)->first()->street;
        $results->where('street', $streetName);
    }

    if ($request->Qualification != 0) {
        $qualificationId = $request->Qualification;
        $qualificationName = Qualification::where('id', $qualificationId)->first()->Name;
        $results->where('Qualification', $qualificationName);
    }

    if ($request->Specialization != 0) {
        $specializationId = $request->Specialization;
        $specializationName = Qualification::where('id', $specializationId)->first()->specialization;
        $results->where('Specialization', $specializationName);
    }

    if ($request->Occupation != 0) {
        $results->where('Occupation', $request->Occupation);
    }

    $members = $results->get();

    return view('admin.member.Advancedsearch', [
        'members' => $members,
        'memberCount'=>$memberCount,
        'city'=>$city,
        'areas'=>$areas,
        'streets'=>$streets,
        'qualifications'=>$qualifications,
        'specializations'=>$specializations,
        'occupations'=>$occupations,
        'paginationLinks' => $paginationLinks
        // 'paginationLinks' => $paginationLinks
    ]);
}



public function printDetails($id) {
    $members = Member::where('id', $id)->first();
    return view('admin.member.details', compact('members'));
}

}
