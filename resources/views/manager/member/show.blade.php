@extends('manager.layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الأعضاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ جميع الأعضاء</span>
						</div>
					</div>
				
					<div class="form-group">
						<select class="form-control form-control-xl" onchange="window.location.href=this.value">
							<option>فرز حسب </option>
							<option value="{{ route('order-m-last') }}">الأحدث</option>
							<option value="{{ route('order-m-name') }}">الاسم</option>
							<option value="{{ route('order-m-team') }}">الرقم الحزبي</option>
							<option value="{{ route('order-m-join') }}">تاريخ الانتساب</option>
						</select>               
					</div>

					<div class="d-flex my-xl-auto right-content">
						<a href="{{ route('exportm') }}" type="button" class="btn btn-primary" style="color: white">&nbsp; تصدير &nbsp;<i class="fas fa-file-upload"></i></a>
					</div>
                    {{-- <div class="d-flex my-xl-auto right-content">
						<a href="" type="button" class="btn btn-primary" style="color: white">&nbsp; استيراد &nbsp;<i class="fas fa-file-download"></i></a>
					</div> --}}
				</div>


				{{-- search --}}
				<div class="row">
					<div class="col-4">
						<form action="{{ route('search-m-team') }}" method="post">
							@csrf
							<div class="input-group">
								<input class="form-control" placeholder="الرقم الحزبي" type="search" name="searchTerm">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-4">
						<form action="{{ route('search-m-name') }}" method="post">
							@csrf
							<div class="input-group">
								<input class="form-control" placeholder="الاسم" type="search" name="searchTerm">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-4">
						<form action="{{ route('search-m-occupation') }}" method="post">
							@csrf
							<div class="input-group">
								<input class="form-control" placeholder="المهنة" type="search" name="searchTerm">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-4">
						<form action="{{ route('search-m-qualification') }}" method="post">
							@csrf
							<div class="input-group">
								<input class="form-control" placeholder="المؤهل العلمي" type="search" name="searchTerm">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-4">
						<form action="{{ route('search-m-specialization') }}" method="post">
							@csrf
							<div class="input-group">
								<input class="form-control" placeholder="الاختصاص" type="search" name="searchTerm">
								<div class="input-group-append">
									<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
								</div>
							</div>
						</form>
					</div>
		
				</div>
				<br>

				<!-- breadcrumb -->
@endsection
@section('content')

@if(session()->has('delete'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('delete') }}</strong>
	<button type="button" class="close" data_dismiss="alert" aria_lable="Close">
		<span aria_hidden="true">&times;</span>
	</button>
</div>
@endif

@if(session()->has('Edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('Edit') }}</strong>
	<button type="button" class="close" data_dismiss="alert" aria_lable="Close">
		<span aria_hidden="true">&times;</span>
	</button>
</div>
@endif

				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">جميع الأعضاء</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead>
											<tr>
												<th class="wd-15p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0">ملاحظات</th>
												<th class="wd-15p border-bottom-0">الفرع</th>
												<th class="wd-15p border-bottom-0">الرقم الحزبي</th>
												<th class="wd-15p border-bottom-0">الاسم الثلاثي</th>
												<th class="wd-15p border-bottom-0">اسم الأم</th>
												<th class="wd-15p border-bottom-0">محل الولادة</th>
												<th class="wd-15p border-bottom-0">تاريخ الولادة</th>
												<th class="wd-15p border-bottom-0">محل ورقم القيد</th>
												<th class="wd-15p border-bottom-0">المحافظة</th>
												<th class="wd-15p border-bottom-0">الرقم الوطني</th>
												<th class="wd-15p border-bottom-0">الجنس</th>
                                                
												<th class="wd-15p border-bottom-0">المؤهل العلمي</th>
												<th class="wd-15p border-bottom-0">الاختصاص</th>
												<th class="wd-15p border-bottom-0">المهنة</th>
												<th class="wd-15p border-bottom-0">رقم الموبايل</th>
												<th class="wd-15p border-bottom-0">عنوان المنزل</th>
												<th class="wd-15p border-bottom-0">عنوان العمل</th>
												<th class="wd-15p border-bottom-0">هاتف المنزل</th>
												<th class="wd-15p border-bottom-0">هاتف العمل</th>
												<th class="wd-15p border-bottom-0">تاريخ الانتساب</th>
												<th class="wd-15p border-bottom-0">الصورة</th>
												<th class="wd-15p border-bottom-0">تعديل</th>
												<th class="wd-15p border-bottom-0">حذف</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1 ?>
											@if(isset($members) && !$members->isEmpty()) 
											@foreach($members as $member)
											<tr>
												<td>{{$i++}}</td>
												<td>{{$member->NotPad}}</td>
												<td>{{$member->branch}}</td>
												<td>{{$member->IDTeam}}</td>
												<td>{{$member->FullName}}</td>
												<td>{{$member->MotherName}}</td>
												<td>{{$member->PlaceOfBirth}}</td>
												<td>{{$member->BirthDate}}</td>
												<td>{{$member->Constraint}}</td>
												<td>{{$member->City}}</td>
												<td>{{$member->IDNumber}}</td>
												<td>{{$member->Gender}}</td>

												<td>{{$member->Qualification}}</td>
												<td>{{$member->Specialization}}</td>
												<td>{{$member->Occupation}}</td>
												<td>{{$member->MobilePhone}}</td>
												<td>{{$member->HomeAddress}}</td>
												<td>{{$member->WorkAddress}}</td>
												<td>{{$member->HomePhone}}</td>
												<td>{{$member->WorkPhone}}</td>
												<td>{{$member->DateOfJoin}}</td>
												<td>{{$member->Image}}</td>

												<td>
													<a class="btn btn-sm btn-info" href="{{ route('memberm.edit', $member->id) }}" title="تعديل"><i class="las la-pen"></i></a>
												</td>
												<td>
													<a class="modal-effect btn btn-sm btn-danger" data-toggle="modal" style="cursor: pointer;"
													data-target="#delete{{$member->id}}"><i class="las la-trash"></i></a>
													<form action="{{route('memberm.delete', $member->id)}}" method="POST" enctype="multipart/form-data">
															@csrf
															@method('DELETE')
														<div id="delete{{$member->id}}" class="modal fade delete-modal" role="dialog">
															<div class="modal-dialog modal-dialog-centered">
																<div class="modal-content">
			
																	<div class="modal-header">
																		<h6 class="modal-title">حذف العضو: &nbsp; {{$member->FullName}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
																			type="button"><span aria-hidden="true">&times;</span></button>
																	</div>
			
																	<div class="modal-body text-center">
																		<img src="{{URL::asset('assets/img/media/sent.png')}}" alt="" width="50" height="46">
																		<br><br>
																		<h5>هل أنت متأكد من عملية الحذف؟</h5>
																		<br>
																		<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">إلغاء</a>
																			<button type="submit" class="btn btn-danger">حذف</button>
																		</div>
																		<br>
																	</div>
																</div>
															</div>
														</div>
													</form>
												</td>

											</tr>
											@endforeach
											
										@else 
										<tr>
											<td colspan="20">لم يتم العثور على نتائج</td>
										</tr>
										@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->
				</div>
				<!-- /row -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection