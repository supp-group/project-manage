@extends('manager.layouts.master')
@section('css')

{{-- flatpicker --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


<!--- Internal Select2 css-->
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!---Internal Fancy uploader css-->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الأعضاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إضافة عضو</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

@if(session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('Add') }}</strong>
	<button type="button" class="close" data_dismiss="alert" aria_lable="Close">
		<span aria_hidden="true">&times;</span>
	</button>
</div>
@endif

				<!-- row -->
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="card">
							<div class="card-body">
								<form action="{{ route('member.save') }}" method="post" enctype="multipart/form-data" autocomplete="off">
									{{ csrf_field() }}
			
									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">ملاحظات</label>
											<input type="hidden" name="NotPad" value="{{ $member->NotPad }}">
											<input type="text" class="form-control" id="inputName" name="NotPad"
											value="{{ $member->NotPad }}" required>
										</div>
									</div><br>
			
									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">الفرع</label>
											<input type="hidden" name="branch" value="{{ $member->branch }}">
											<input type="text" class="form-control" id="inputName" name="branch"
											value="{{ $member->branch }}" required>
										</div>
									</div><br>

					
									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">الاسم الثلاثي</label>
											<input type="hidden" name="FullName" value="{{ $member->FullName }}">
											<input type="text" class="form-control" id="inputName" name="FullName"
											value="{{ $member->FullName }}" required>
										</div>
									</div><br>

									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">اسم الأم</label>
											<input type="hidden" name="MotherName" value="{{ $member->MotherName }}">
											<input type="text" class="form-control" id="inputName" name="MotherName"
											value="{{ $member->MotherName }}" required>
										</div>
									</div><br>

									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">محل الولادة</label>
											<input type="hidden" name="PlaceOfBirth" value="{{ $member->PlaceOfBirth }}">
											<input type="text" class="form-control" id="inputName" name="PlaceOfBirth"
											value="{{ $member->PlaceOfBirth }}" required>
										</div>
									</div><br>

									<div class="row">
										<div class="col">
											<div class="form-group">
												<label>تاريخ الولادة</label>
												<input type="hidden" name="BirthDate" value="{{ $member->BirthDate }}">
												<input type="datetime-local" class="form-control" id="inputName" name="BirthDate"
												value="{{ $member->BirthDate }}" required>
											</div>
										</div>
									</div><br>

									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">محل ورقم القيد</label>
											<input type="hidden" name="Constraint" value="{{ $member->Constraint }}">
											<input type="text" class="form-control" id="inputName" name="Constraint"
											value="{{ $member->Constraint }}" required>
										</div>
									</div><br>

									<div class="form-group">
										<label>المحافظة</label>
										<select name="City" class="form-control select">
											
											{{-- @foreach($cityName as $city) --}}
											<option value="{{$cityName}}">{{$cityName}}</option>
											{{-- @endforeach  --}}

										</select>
									</div><br>

									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">الرقم الوطني</label>
											<input type="hidden" name="IDNumber" value="{{ $member->IDNumber }}">
											<input type="text" class="form-control" id="inputName" name="IDNumber"
											value="{{ $member->IDNumber }}" required>
										</div>
									</div><br>

									<div class="form-group">
										<label class="display-block">الجنس</label> <br>

										@if ($member->Gender == 'ذكر')
											
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" value="ذكر" name="Gender" id="status_active" checked>
											<label class="form-check-label" for="status_active">
												&nbsp; ذكر 
											</label>
										</div> 

										@else
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" value="ذكر" name="Gender" id="status_active">
											<label class="form-check-label" for="status_active">
												&nbsp; ذكر 
											</label>
										</div> 

										@endif

										@if ($member->Gender == 'أنثى')

										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" value="أنثى" name="Gender" id="status_inactive" checked>
											<label class="form-check-label" for="status_inactive">
												&nbsp; أنثى
											</label>
										</div>

										@else
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" value="أنثى" name="Gender" id="status_inactive">
											<label class="form-check-label" for="status_inactive">
												&nbsp; أنثى
											</label>
										</div>
										@endif

									</div><br>

									<div class="form-group">
										<label>المهنة</label>
										<select name="Occupation" class="form-control select" id="Occupation"> 
											
											@foreach($occupations as $occupation)
											<option value="{{$occupation->Name}}">{{$occupation->Name}}</option>
											@endforeach 

										</select>
									</div><br>

									<div class="form-group">
										<label>المؤهل العلمي</label>
										<select name="Qualification" id="qualificationSelect"  class="form-control select" >
											<option >اختر المؤهل العلمي</option>
											@foreach($qualifications as $qualification)
											<option value="{{$qualification->id}}">{{$qualification->Name}}</option>
											@endforeach 

										</select>
									</div><br>

									<div class="form-group">
										<label>الاختصاص</label>
										<select name="Specialization" class="form-control select" id="specializationSelect">
											<!-- Options will be loaded dynamically -->
										</select>
									</div><br>
									

									<div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">رقم الموبايل</label>
										  <input type="hidden" name="MobilePhone" value="{{ $member->MobilePhone }}">
										  <input type="text" class="form-control" id="inputName" name="MobilePhone"
										  value="{{ $member->MobilePhone }}" required>
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">عنوان المنزل</label>
										  <input type="hidden" name="HomeAddress" value="{{ $member->HomeAddress }}">
											<input type="text" class="form-control" id="inputName" name="HomeAddress"
											value="{{ $member->HomeAddress }}" required>
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">عنوان العمل</label>
										  <input type="hidden" name="WorkAddress" value="{{ $member->WorkAddress }}">
											<input type="text" class="form-control" id="inputName" name="WorkAddress"
											value="{{ $member->WorkAddress }}" required>
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">هاتف المنزل</label>
										  <input type="hidden" name="HomePhone" value="{{ $member->HomePhone }}">
										  <input type="text" class="form-control" id="inputName" name="HomePhone"
										  value="{{ $member->HomePhone }}" required>
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">هاتف العمل</label>
										  <input type="hidden" name="WorkPhone" value="{{ $member->WorkPhone }}">
											<input type="text" class="form-control" id="inputName" name="WorkPhone"
											value="{{ $member->WorkPhone }}" required>
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <div class="form-group">
											<label>تاريخ الانتساب</label>
											<input type="hidden" name="DateOfJoin" value="{{ $member->DateOfJoin }}">
											<input type="datetime-local" class="form-control" id="inputName" name="DateOfJoin"
											value="{{ $member->DateOfJoin }}" required>
										  </div>
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="exampleTextarea">صورة العضو المنتسب</label>
										  <input type="hidden" name="Image" value="{{ $member->Image }}">
										  <input type="file" name="Image" value="{{ $member->Image }}" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
										  data-height="70" />
										</div>
									  </div><br>
					
									  <div class="d-flex justify-content-center">
										<button type="submit" class="btn btn-primary">حفظ البيانات</button>
									  </div>
			
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
@endsection
@section('js')

{{-- flatpicker --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
	config = {
    	enableTime: true,
    	// dateFormat: "Y-m-d",
		dateFormat: "Y/m/d H:i",
		altInput: true,
		altFormat: "F j, Y"
	}

	flatpickr("input[type=datetime-local]", config);
</script>


	{{-- Dependent Dropdown ===> qualification & specialization --}}
	<script>
		document.addEventListener("DOMContentLoaded", function() {
		  const qualificationSelect = document.querySelector('#qualificationSelect');
		  const specializationSelect = document.querySelector('#specializationSelect');
		
		  qualificationSelect.addEventListener('change', function() {
			const qualificationId = this.value;

			
			var url="{{ url('manager/memberm/get-specializations/[itemid]') }}";
			url = url.replace('[itemid]',qualificationId);


			fetch(url)  // Corrected URL format
			  .then(response => {
				if (!response.ok) {
				  throw new Error('Network response was not ok');
				}
				return response.json();
			  })
			  .then(specializations => {
				specializationSelect.innerHTML = '<option value="">اختر الاختصاص</option>'; // Clear and add a placeholder
				specializations.forEach(specialization => {
				  const option = document.createElement('option');
				  option.value = specialization.id;
				  option.textContent = specialization.specialization;
				  specializationSelect.appendChild(option);
				});
			  })
			  .catch(error => {
				console.error('There has been a problem with your fetch operation:', error);
			  });
		  });
		});
	</script>
		


<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Fileuploads js-->
<script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
<!--Internal Fancy uploader js-->
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
<!--Internal  Form-elements js-->
<script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<!-- Internal TelephoneInput js-->
<script src="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
<script src="{{URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>

@endsection