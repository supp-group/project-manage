@extends('admin.layouts.master')

@section('css')

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
							<h4 class="content-title mb-0 my-auto">سجل التعديلات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ سجل تعديلات العضو</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection

@section('content')
				<!-- row -->
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">

                            @foreach ($members as $member)

                            <h4>تم تعديل العضو {{ $member->FullName }} 
                                 من قبل {{$member->managerEmail}} 
                                 بتاريخ {{ $member->updated_at->format('Y-m-d') }}
                            </h4>

                            <form action="{{ route('archive.GetArchive', $member->IDTeam) }}" method="get" autocomplete="off">
                                {{ csrf_field() }}
                                @method('get')

                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">ملاحظات</label>
                                        <input type="hidden" name="NotPad" value="{{ $member->NotPad }}">
                                        <input type="text" class="form-control" id="inputName" name="NotPad"
                                        value="{{ $member->NotPad }}" readonly>
                                    </div>
                                </div><br>
                                   
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">الفرع</label>
                                        <input type="hidden" name="branch" value="{{ $member->branch }}">
                                        <input type="text" class="form-control" id="inputName" name="branch"
                                        value="{{ $member->branch }}" readonly>
                                    </div>
                                </div><br>

                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">الرقم الحزبي</label>
                                        <input type="hidden" name="IDTeam" value="{{ $member->IDTeam }}">
                                        <input type="text" class="form-control" id="inputName" name="IDTeam"
                                        value="{{ $member->IDTeam }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">الاسم الثلاثي</label>
                                        <input type="hidden" name="FullName" value="{{ $member->FullName }}">
                                        <input type="text" class="form-control" id="inputName" name="FullName"
                                        value="{{ $member->FullName }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">اسم الأم</label>
                                        <input type="hidden" name="MotherName" value="{{ $member->MotherName }}">
                                        <input type="text" class="form-control" id="inputName" name="MotherName"
                                        value="{{ $member->MotherName }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">محل الولادة</label>
                                        <input type="hidden" name="PlaceOfBirth" value="{{ $member->PlaceOfBirth }}">
                                        <input type="text" class="form-control" id="inputName" name="PlaceOfBirth"
                                        value="{{ $member->PlaceOfBirth }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">تاريخ الولادة</label>
                                        <input type="hidden" name="BirthDate" value="{{ $member->BirthDate }}">
                                        <input type="text" class="form-control" id="inputName" name="BirthDate"
                                        value="{{ $member->BirthDate }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">محل ورقم القيد</label>
                                        <input type="hidden" name="Constraint" value="{{ $member->Constraint }}">
                                        <input type="text" class="form-control" id="inputName" name="Constraint"
                                        value="{{ $member->Constraint }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">المحافظة</label>
                                        <input type="hidden" name="City" value="{{ $member->City }}">
                                        <input type="text" class="form-control" id="inputName" name="City"
                                        value="{{ $member->City }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">الرقم الوطني</label>
                                        <input type="hidden" name="IDNumber" value="{{ $member->IDNumber }}">
                                        <input type="text" class="form-control" id="inputName" name="IDNumber"
                                        value="{{ $member->IDNumber }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">الجنس</label>
                                        <input type="hidden" name="Gender" value="{{ $member->Gender }}">
                                        <input type="text" class="form-control" id="inputName" name="Gender"
                                        value="{{ $member->Gender }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">المهنة</label>
                                        <input type="hidden" name="Occupation" value="{{ $member->Occupation }}">
                                        <input type="text" class="form-control" id="inputName" name="Occupation"
                                        value="{{ $member->Occupation }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">المؤهل العلمي</label>
                                        <input type="hidden" name="Qualification" value="{{ $member->Qualification }}">
                                        <input type="text" class="form-control" id="inputName" name="Qualification"
                                        value="{{ $member->Qualification }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">الاختصاص</label>
                                        <input type="hidden" name="Specialization" value="{{ $member->Specialization }}">
                                        <input type="text" class="form-control" id="inputName" name="Specialization"
                                        value="{{ $member->Specialization }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">رقم الموبايل</label>
                                        <input type="hidden" name="MobilePhone" value="{{ $member->MobilePhone }}">
                                        <input type="text" class="form-control" id="inputName" name="MobilePhone"
                                        value="{{ $member->MobilePhone }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">عنوان المنزل</label>
                                        <input type="hidden" name="HomeAddress" value="{{ $member->HomeAddress }}">
                                        <input type="text" class="form-control" id="inputName" name="HomeAddress"
                                        value="{{ $member->HomeAddress }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">عنوان العمل</label>
                                        <input type="hidden" name="WorkAddress" value="{{ $member->WorkAddress }}">
                                        <input type="text" class="form-control" id="inputName" name="WorkAddress"
                                        value="{{ $member->WorkAddress }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">هاتف المنزل</label>
                                        <input type="hidden" name="HomePhone" value="{{ $member->HomePhone }}">
                                        <input type="text" class="form-control" id="inputName" name="HomePhone"
                                        value="{{ $member->HomePhone }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">هاتف العمل</label>
                                        <input type="hidden" name="WorkPhone" value="{{ $member->WorkPhone }}">
                                        <input type="text" class="form-control" id="inputName" name="WorkPhone"
                                        value="{{ $member->WorkPhone }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">تاريخ الانتساب</label>
                                        <input type="hidden" name="DateOfJoin" value="{{ $member->DateOfJoin }}">
                                        <input type="text" class="form-control" id="inputName" name="DateOfJoin"
                                        value="{{ $member->DateOfJoin }}" readonly>
                                    </div>
                                </div><br>
                                
                                <div class="row">
                                    <div class="col">
                                        <label for="exampleTextarea">صورة العضو المنتسب</label> <br>
                                        <input type="hidden" name="Image" value="{{ $member->Image }}">
                                        <br>
                                        
                                        @if ($member->Image)
                                            <td><img src="{{asset('images/'.$member->Image)}}" style="width: 100px;"></td>
                                        @else
                                            <td><img src="{{URL::asset('assets/img/media/user.jpg')}}"  style="width: 100px;"></td>
                                        @endif
                                    </div>
                                </div><br>
                            </form>

                            @endforeach

                        </div>
                    </div>
                </div>
				<!-- row closed -->

@endsection

@section('js')

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
