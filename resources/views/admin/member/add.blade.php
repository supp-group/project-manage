@extends('admin.layouts.master')
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


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

				<!-- row -->
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="card">
							<div class="card-body">
								<form action="{{ url('admin/member/save') }}" method="post" enctype="multipart/form-data" autocomplete="off">
									{{ csrf_field() }}
			
									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">ملاحظات</label>
											<input type="text" class="form-control @error('NotPad') is-invalid @enderror" 
											id="inputName" name="NotPad" required>

											@error('NotPad')
												<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										</div>
									</div><br>
			
									 <div class="row">
										<div class="col">
											<label for="inputName" class="control-label">الفرع</label>
											<input type="text" class="form-control @error('branch') is-invalid @enderror" 
											id="inputName" name="branch" required>
										
											@error('branch')
												<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										</div>
									</div><br>

					
									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">الاسم الثلاثي</label>
											<input type="text" class="form-control @error('FullName') is-invalid @enderror" 
											id="inputName" name="FullName" required>
										
											@error('FullName')
												<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										</div>
									</div><br>

									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">اسم الأم</label>
											<input type="text" class="form-control @error('MotherName') is-invalid @enderror" 
											id="inputName" name="MotherName" required>

											@error('MotherName')
												<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										</div>
									</div><br>

									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">محل الولادة</label>
											<input type="text" class="form-control @error('PlaceOfBirth') is-invalid @enderror" 
											id="inputName" name="PlaceOfBirth" required>

											@error('PlaceOfBirth')
												<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										</div>
									</div><br>

									<div class="row">
										<div class="col">
											<div class="form-group">
												<label>تاريخ الولادة</label>
													<input type="datetime" class="form-control @error('BirthDate') is-invalid @enderror" 
													name="BirthDate" required>

													@error('BirthDate')
														<div class="alert alert-danger">{{ $message }}</div>
													@enderror
											</div>
										</div>
									</div><br>

									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">محل ورقم القيد</label>
											<input type="text" class="form-control @error('Constraint') is-invalid @enderror" 
											id="inputName" name="Constraint" required>

											@error('Constraint')
												<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										</div>
									</div><br>

									<div class="form-group">
										<label>المحافظة</label>
										<select name="City" class="form-control select @error('City') is-invalid @enderror">
											
											@foreach($cityName as $city)
											<option >{{$city->Name}}</option>
											@endforeach 

										</select>

										@error('City')
										<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div><br>

									<div class="row">
										<div class="col">
											<label for="inputName" class="control-label">الرقم الوطني</label>
											<input type="text" class="form-control @error('IDNumber') is-invalid @enderror" 
											id="inputName" name="IDNumber" required>

											@error('IDNumber')
    											<div class="alert alert-danger">{{ $message }}</div>
											@enderror
										</div>
									</div><br>

									<div class="form-group">
										<label class="display-block">الجنس</label> <br>
										<div class="form-check form-check-inline">
											<input class="form-check-input" 
											type="radio" name="Gender" id="status_active" value="ذكر" checked>

											<label class="form-check-label" for="status_active">
												&nbsp; ذكر 
											</label>
										</div> 
										<div class="form-check form-check-inline">
											<input class="form-check-input" 
											type="radio" name="Gender" id="status_inactive" value="أنثى">

											<label class="form-check-label" for="status_inactive">
												&nbsp; أنثى
											</label>
										</div>
									</div><br>

									<div class="form-group">
										<label>المهنة</label>
										<select name="Occupation" class="form-control select @error('Occupation') is-invalid @enderror" id="Occupation"> 
											<option>اختر المهنة</option>
											
											@foreach($occupations as $occupation)
											<option value="{{$occupation->Name}}">{{$occupation->Name}}</option>
											@endforeach 

										</select>

										@error('Occupation')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div><br>

									<div class="form-group">
										<label>المؤهل العلمي</label>
										<select name="Qualification" id="qualificationSelect" class="form-control select @error('Qualification') is-invalid @enderror" onChange="loadSpecializations()">
											<option>اختر المؤهل العلمي</option>
											@foreach($qualifications as $qualification)
												
												<option value="{{$qualification->id}}">{{$qualification->Name}}</option>
											@endforeach 
										</select>

										@error('Qualification')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div><br>

									<div class="form-group">
										<label>الاختصاص</label>
										<select name="Specialization" class="form-control select @error('Specialization') is-invalid @enderror" id="specializationSelect">
											<!-- Options will be loaded dynamically -->
										</select>

										@error('Specialization')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
									</div><br> 
									

									 <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">رقم الموبايل</label>
										  <input type="text" class="form-control @error('MobilePhone') is-invalid @enderror" 
										  id="inputName" name="MobilePhone" required>

										@error('MobilePhone')
											<div class="alert alert-danger">{{ $message }}</div>
										@enderror
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">عنوان المنزل</label>
										  <input type="text" class="form-control @error('HomeAddress') is-invalid @enderror" 
										  id="inputName" name="HomeAddress" required>

										    @error('HomeAddress')
										  		<div class="alert alert-danger">{{ $message }}</div>
									  		@enderror
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">عنوان العمل</label>
										  <input type="text" class="form-control @error('WorkAddress') is-invalid @enderror" 
										  id="inputName" name="WorkAddress" required>
										
										    @error('WorkAddress')
										  		<div class="alert alert-danger">{{ $message }}</div>
									  		@enderror
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">هاتف المنزل</label>
										  <input type="text" class="form-control @error('HomePhone') is-invalid @enderror" 
										  id="inputName" name="HomePhone" required>
										
										  	@error('HomePhone')
										  		<div class="alert alert-danger">{{ $message }}</div>
									  		@enderror
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="inputName" class="control-label">هاتف العمل</label>
										  <input type="text" class="form-control @error('WorkPhone') is-invalid @enderror" 
										  id="inputName" name="WorkPhone" required>

										  	@error('WorkPhone')
										  		<div class="alert alert-danger">{{ $message }}</div>
									  		@enderror
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <div class="form-group">
											<label>تاريخ الانتساب</label>
											  <input type="datetime-local" class="form-control @error('DateOfJoin') is-invalid @enderror" 
											  name="DateOfJoin" required>

											@error('DateOfJoin')
										  		<div class="alert alert-danger">{{ $message }}</div>
									  		@enderror
										  </div>
										</div>
									  </div><br>
					
									  <div class="row">
										<div class="col">
										  <label for="exampleTextarea">صورة العضو المنتسب</label>
										  <input type="file" name="Image" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
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
    	// enableTime: true,
    	// dateFormat: "Y-m-d",
		// dateFormat: "Y/m/d H:i",
		dateFormat: "Y",

		altInput: true,
		// altFormat: "F j, Y"
		altFormat: "Y"

	}

	flatpickr("input[type=datetime-local]", config);
</script>

<script>
	config = {
    	// enableTime: true,
    	dateFormat: "Y-m-d",
		// dateFormat: "Y/m/d H:i",
		// dateFormat: "Y",

		altInput: true,
		altFormat: "F j, Y"
		// altFormat: "Y"

	}

	flatpickr("input[type=datetime]", config);
</script>



	{{-- Dependent Dropdown ===> qualification & specialization --}}
	<script>
		document.addEventListener("DOMContentLoaded", function() {
		  const qualificationSelect = document.querySelector('#qualificationSelect');
		  const specializationSelect = document.querySelector('#specializationSelect');
		
		  qualificationSelect.addEventListener('change', function() {
			const qualificationId = this.value;
			fetch(`get-specializations/${qualificationId}`)  // Corrected URL format
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