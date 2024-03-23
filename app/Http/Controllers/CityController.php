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
      $cities = City::whereNotNull('Name')->orderBy('Name','Asc')->get();
      return view('admin.city.show',compact('cities'));
    }

    public function indexBranch()
    { 
      $branchs = City::whereNotNull('branch')->orderBy('branch','Asc')->get();

      foreach($branchs as  $branch)
      {
        if($branch->grandId>0)
        {
          $parent = City::find( $branch->grandId);
          $branch->branch_name = $parent->branch;
        }
      }
      return view('admin.branch.show',compact('branchs'));
    }

    public function indexArea()
    { 
      $areas = City::whereNotNull('area')->orderBy('Name','Asc')->get();

      foreach($areas as  $area)
      {
        if($area->parentId>0)
        {
          $parent = City::find( $area->parentId);
          $area->parent_name = $parent->area;
        }
      }
      return view('admin.area.show',compact('areas'));
    }
    
    public function indexStreet()
    { 
      $streets = City::whereNotNull('street')->orderBy('area','Asc')->get();

      foreach($streets as  $street)
      {
        if($street->grandId>0)
        {
          $parent = City::find( $street->grandId);
          $street->grand_name = $parent->area;
        }
      }
      return view('admin.street.show',compact('streets'));
    }



    public function create()
    {
      return view('admin.city.add');
    }

    public function createBranch()
    {
      $cities = City::whereNotNull('Name')->orderBy('Name','asc')->get();
      return view('admin.branch.add', compact('cities'));
    }

    public function createArea()
    {
      $cities = City::whereNotNull('Name')->orderBy('Name','asc')->get();
      return view('admin.area.add', compact('cities'));
    }

    public function createStreet()
    {
      $cities = City::whereNotNull('Name')->orderBy('Name','Asc')->get();
      $areas = City::whereNotNull('area')->orderBy('Name','Asc')->get();
      $streets = City::whereNotNull('area')->orderBy('area','asc')->get();

      return view('admin.street.add', compact('cities', 'areas', 'streets'));
    }



    public function store(Request $request)
    {
      $validated = $request->validate([
        'Name' => 'required|unique:cities|max:255',
      ]);

      $city= City::create([
        'Name'=>$request->Name,
      ]);

      session()->flash('Add', 'تم إضافة المحافظة بنجاح');
      return back();
    }

    
    public function storeBranch(Request $request)
    {
      City::create([
        'parentId'=>$request->parentId,
        'branch'=>$request->branch,
      ]);

      session()->flash('Add', 'تم إضافة الفرع بنجاح');
      return redirect()->back();
    }


    public function storeArea(Request $request)
    {
      City::create([
        'parentId'=>$request->parentId,
        'area'=>$request->area,
      ]);

      session()->flash('Add', 'تم إضافة المنطقة بنجاح');
      return redirect()->back();
    }


    public function storeStreet(Request $request)
    {
      $cityId = $request->parentId;
      $cityName = City::where('parentId', $cityId)->first()->Name;
      
      $areaId = $request->grandId;
      $areaName = City::where('grandId', $areaId)->first()->area;
      
      City::create([
        'parentId'=>$request->Name,
        'grandId'=>$request->area,
        'street'=>$request->street,
      ]);

      session()->flash('Add', 'تم إضافة الحي بنجاح');
      return redirect()->back();
    }



  public function edit($id)
  {
    $city = City::findOrFail($id);
    return view('admin.city.edit',compact('city'));
  }

  public function editBranch($id)
  {
    $branch = City::findOrFail($id);
    return view('admin.branch.edit',compact('branch'));
  }

  public function editArea($id)
  {
    $area = City::findOrFail($id);
    return view('admin.area.edit',compact('area'));
  }
   
  public function editStreet($id)
  {
    $street = City::findOrFail($id);
    return view('admin.street.edit',compact('street'));
  }



  public function update(Request $request, $id)
  {
    $validated = $request->validate([
        'Name' => 'required|unique:cities|max:255',
    ]);
      $city = City::findOrFail($id);

      $city->update([
        'Name'=>$request->Name,
      ]);

      session()->flash('Edit', 'تم تعديل المحافظة بنجاح');
      return back();
    }

    public function updateBranch(Request $request, $id)
    {
      $validated = $request->validate([
        'parentId'=>'required',
        'branch' => 'required|unique:cities|max:255',
      ]);
  
      $branch = City::findOrFail($id);
  
      $branch->update([
        'parentId'=>$request->parentId,
        'branch'=>$request->branch,
      ]);
  
      session()->flash('Edit', 'تم تعديل الفرع بنجاح');
      return back();
    }

    public function updateArea(Request $request, $id)
    {
      $validated = $request->validate([
        'parentId'=>'required',
        'area' => 'required|unique:cities|max:255',
      ]);
  
      $area = City::findOrFail($id);
  
      $area->update([
        'parentId'=>$request->parentId,
        'area'=>$request->area,
      ]);
  
      session()->flash('Edit', 'تم تعديل المنطقة بنجاح');
      return back();
    }

    public function updateStreet(Request $request, $id)
    {
      $validated = $request->validate([
        // 'parentId'=>'required',
        'grandId'=>'required',
        'street' => 'required|unique:cities|max:255',
      ]);
  
      $street = City::findOrFail($id);
  
      $street->update([
        // 'parentId'=>$request->parentId,
        'grandId'=>$request->grandId,
        'street'=>$request->street,
      ]);
  
      session()->flash('Edit', 'تم تعديل الحي بنجاح');
      return back();
    }



    public function destroy($id)
    {
      $city = City::findOrFail($id);
      $subAreas = City::where('parentId', $id)->get();
      $subStreets = City::where('grandId', $id)->get();
  
      foreach ($subAreas as $subArea) {
        $subArea->delete();
      }

      foreach ($subStreets as $subStreet) {
        $subStreet->delete();
      }

      $city->delete();
    
      session()->flash('delete', 'تم حذف المحافظة بنجاح');
      return back();
    }

    public function destroyBranch($id)
    {
      $branch = City::findOrFail($id);
      $branch->delete();
    
      session()->flash('delete', 'تم حذف الفرع بنجاح');
      return back();
    }


    public function destroyArea($id)
    {
      $area = City::findOrFail($id);
      $subStreets = City::where('grandId', $id)->get();
  
      foreach ($subStreets as $subStreet) {
        $subStreet->delete();
      }
      
      $area->delete();
    
      session()->flash('delete', 'تم حذف المنطقة بنجاح');
      return back();
    }

    public function destroyStreet($id)
    {
      City::findOrFail($id)->delete();

      session()->flash('delete', 'تم حذف الحي بنجاح');
      return back();
    }
 
    public function getAreaForCity($cityId)
    {
      // return $cityId;
      $areas = City::where('parentId', $cityId)
                  ->whereNotNull('area')
                  ->orderBy('area', 'Asc')
                  ->get();

      return response()->json($areas);
    }    

 
    public function getStreetForArea($areaId)
    {
      $street = City::where('grandId', $areaId)
      ->whereNotNull('street')
      ->orderBy('area', 'Asc')
      ->get();
      // return view('admin.member.add',compact('streets'));
      return response()->json($street);
    }

    public function getBranchForCity($branchId)
    {
      // return $cityId;
      $branchs = City::where('id', $branchId)
                  ->whereNotNull('branch')
                  ->orderBy('branch', 'Asc')
                  ->get();

      return response()->json($branchs);
    }    


}
