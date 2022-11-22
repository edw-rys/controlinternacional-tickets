@extends('layouts.usermaster')

@section('styles')
	<!-- INTERNAL Data table css -->
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datatable/responsive.bootstrap5.css')}}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection

@section('content')

	<!-- Section -->
	<section>
		<div class="bannerimg cover-image" data-bs-image-src="{{asset('assets/images/photos/banner1.jpg')}}">
			<div class="header-text mb-0">
				<div class="container ">
					<div class="row text-white">
						<div class="col">
							@switch($status)
								@case('active')
									<h1 class="mb-0">{{trans('langconvert.adminmenu.activetickets')}}</h1>
									
									@break
								@case('closed')
									<h1 class="mb-0">{{trans('langconvert.adminmenu.closedtickets')}}</h1>
									
									@break
								@case('closed')
									<h1 class="mb-0">{{trans('langconvert.adminmenu.onholdtickets')}}</h1>
									@break

								@default
									<h1 class="mb-0">{{trans('langconvert.menu.dashboard')}}</h1>
									
							@endswitch
						</div>
						<div class="col col-auto">
							<ol class="breadcrumb text-center">
								<li class="breadcrumb-item">
									<a href="{{url('/')}}" class="text-white-50">{{trans('langconvert.menu.home')}}</a>
								</li>
								<li class="breadcrumb-item active">
									@switch($status)
										@case('active')
											<a href="#" class="text-white">{{trans('langconvert.adminmenu.activetickets')}}</a>
											{{-- <h1 class="mb-0">{{trans('langconvert.adminmenu.activetickets')}}</h1> --}}
											
											@break
										@case('closed')
											{{-- <h1 class="mb-0">{{trans('langconvert.adminmenu.closedtickets')}}</h1> --}}
											<a href="#" class="text-white">{{trans('langconvert.adminmenu.closedtickets')}}</a>
											
											@break
										@case('closed')
											<a href="#" class="text-white">{{trans('langconvert.adminmenu.onholdtickets')}}</a>
											@break

										@default
											<a href="#" class="text-white">{{trans('langconvert.menu.dashboard')}}</a>
											{{-- <a href="#" class="text-white">{{trans('langconvert.menu.dashboard')}}</a> --}}
											{{-- <h1 class="mb-0">{{trans('langconvert.menu.dashboard')}}</h1> --}}
											
									@endswitch
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Section -->

	<!--Dashboard List-->
	<section>
		<div class="cover-image sptb">
			<div class="container">
				<div class="row">
					@include('includes.user.verticalmenu')
					<div class="col-xl-9">
						@if ($status == 'all')						
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-12">
									<div class="card">
										<a href="#">
											<div class="card-body">
												<div class="row">
													<div class="col-7">
														<div class="mt-0 text-start">
															<span class="fs-16 font-weight-semibold">{{trans('langconvert.admindashboard.totaltickets')}}</span>
															<h3 class="mb-0 mt-1 text-primary fs-25">{{$tickets}}</h3>
														</div>
													</div>
													<div class="col-5">
														<div class="icon1 bg-primary-transparent my-auto float-end"> <i
																class="las la-ticket-alt"></i> </div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-12">
									<div class="card">
										<a href="#">
											<div class="card-body">
												<div class="row">
													<div class="col-7">
														<div class="mt-0 text-start">
															<span class="fs-16 font-weight-semibold">{{trans('langconvert.adminmenu.activetickets')}}</span>
															<h3 class="mb-0 mt-1 text-success fs-25">

																{{$active->count()}}

															</h3>
														</div>
													</div>
													<div class="col-5">
														<div class="icon1 bg-success-transparent my-auto float-end"> <i
																class="ri-ticket-2-line"></i> </div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-12">
									<div class="card">
										<a href="#">
											<div class="card-body">
												<div class="row">
													<div class="col-7">
														<div class="mt-0 text-start">
															<span class="fs-16 font-weight-semibold">{{trans('langconvert.adminmenu.closetickets')}}</span>
															<h3 class="mb-0 mt-1 text-secondary fs-25">{{$closed->count()}}</h3>
														</div>
													</div>
													<div class="col-5">
														<div class="icon1 bg-secondary-transparent my-auto  float-end"> <i
																class="ri-coupon-2-line"></i> </div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
						@endif
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card mb-0">
									<div class="card-header border-0 d-flex">
										<h4 class="card-title">{{trans('langconvert.admindashboard.ticketssummary')}}</h4>
										<div class="float-end ms-auto"><a href="{{route('client.ticket')}}" class="btn btn-secondary ms-auto"><i class="fa fa-paper-plane-o me-2"></i>{{trans('langconvert.adminmenu.createticket')}}</a></div>
									</div>
									<div class="card-body">
										{{-- FILTERS --}}
										<form action="" id="filter-form" class="filter-form">
											<div class="mb-3">
												
												<div class="row">
													@if (isset($categories))
														<div class="col-xl-4 col-md-4 col-12">
															<label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.ticketcategory')}}</label>
															<select
																class="form-control select2-show-search select2"
																data-placeholder="Selecciona Categoría" name="category_id" id="category_id">
																<option value="all">Todos</option>
																@foreach ($categories as $category)
																<option value="{{ $category->id }}">{{ $category->name }}</option>
																@endforeach
															</select>
														</div>
													@endif
													<div class="col-xl-4 col-md-4 col-12">
														<label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.priority')}}</label>
														<select class="form-control select2" data-placeholder="Select Priority" name="priority_id" id="priority_id" >
															<option value="all">Todos</option>
															<option value="Critical">{{trans('langconvert.newwordslang.critical' )}}</option>
															<option value="High">{{trans('langconvert.newwordslang.high' )}}</option>
															<option value="Medium">{{trans('langconvert.newwordslang.medium' )}}</option>
															<option value="Low">{{trans('langconvert.newwordslang.low' )}}</option>
														</select>	
													</div>
													<div class="col-xl-4 col-md-4 col-12">
														<label class="form-label mb-0 mt-2">Creado desde</label>
														<div class="header-datepicker me-3">
															<div class="input-group">
																<div class="input-group-text">
																		<i class="feather feather-calendar"></i>
																</div><input class="form-control fc-datepicker pb-0 pt-0" value="" id="created_start" type="date" >
															</div>
														</div>
													</div>
													<div class="col-xl-4 col-md-4 col-12">
														<label class="form-label mb-0 mt-2">Creado desde</label>
														<div class="header-datepicker me-3">
															<div class="input-group">
																<div class="input-group-text">
																		<i class="feather feather-calendar"></i>
																</div><input class="form-control fc-datepicker pb-0 pt-0" value="" id="created_end" type="date" >
															</div>
														</div>
													</div>
													<div class="col-xl-4 col-md-4 col-12">
					
													</div>
												</div>
												<div class="row mt-2">
													<div class="col-md-12">
														<div class="form-group m-t-10">
															<button type="button" class="btn btn-success" id="filters-apply-button"><i class="fa fa-check"></i> Aplicar</button>
															{{-- <button type="button" id="apply-filters" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.apply')</button> --}}
															<button type="button" id="reset-filters" class="btn btn-inverse col-md-offset-1"><i class="fa fa-refresh"></i> Resetear</button>
														</div>
													</div>
												</div>
											</div>
										</form>
										{{-- TABLE --}}
										<div class="table-responsive">
											<button id="massdelete" class="btn btn-outline-light btn-sm ms-7 mb-4 data-table-btn mx-md-center"><i class="fe fe-trash me-1"></i> {{trans('langconvert.admindashboard.delete')}}</button>
											<table class="table table-vcenter text-nowrap table-bordered table-striped w-100"
												id="userdashboard">
												<thead>
													<tr>
													<th >{{trans('langconvert.admindashboard.id')}}</th>
													<th >{{trans('langconvert.admindashboard.slNo')}}</th>
													<th width="10" >
														<input type="checkbox"  id="customCheckAll">
														<label  for="customCheckAll"></label>
													</th>
													<th >#{{trans('langconvert.admindashboard.id')}}</th>
													<th >{{trans('langconvert.admindashboard.title')}}</th>
													<th>{{ trans('langconvert.admindashboard.tickethose') }}</th>
													<th >{{trans('langconvert.admindashboard.priority')}}</th>
													<th >{{trans('langconvert.admindashboard.category')}}</th>
													<th >{{trans('langconvert.admindashboard.date')}}</th>
													<th >{{trans('langconvert.admindashboard.status')}}</th>
													<th >{{trans('langconvert.admindashboard.lastreply')}}</th>
													<th >{{trans('langconvert.admindashboard.actions')}}</th>
													</tr>
												</thead>
												<tbody>
													
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Dashboard List-->

@endsection

@section('scripts')

	<!-- INTERNAL Vertical-scroll js-->
	<script src="{{asset('assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js')}}?v=<?php echo time(); ?>"></script>

	<!-- INTERNAL Data tables -->
	<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}?v=<?php echo time(); ?>"></script>
	<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}?v=<?php echo time(); ?>"></script>
	<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}?v=<?php echo time(); ?>"></script>
	<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}?v=<?php echo time(); ?>"></script>

	<!-- INTERNAL Index js-->
	<script src="{{asset('assets/js/support/support-sidemenu.js')}}?v=<?php echo time(); ?>"></script>

	<script type="text/javascript">
		"use strict";
		
		(function($){

			// Variables
			var SITEURL = '{{url('')}}';

			// Csrf Field
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			//________ Data Table
			var table = $('#userdashboard').DataTable({

				language: {
					searchPlaceholder: 'Search...',
					sSearch: '',
				},
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('tickets-list', $status) }}"
				},
				columns: [
					{data: 'id', name: 'id', 'visible': false},
					{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
					{data: 'checkbox', name: 'checkbox',orderable: false,searchable: false},
					{ data: 'ticket_id', name: 'ticket_id' },
					{ data: 'subject', name: 'subject' },
					{ data: 'hose_id',name: 'hose_id'},
					{ data: 'priority', name: 'priority' },
					{ data: 'category_id', name: 'category_id' },
					{ data: 'created_at', name: 'created_at' },
					{ data: 'status', name: 'status' },
					{ data: 'last_reply', name: 'last_reply' },
					{data: 'action', name: 'action', orderable: false},
				],
				order:[],
				responsive: true,
				drawCallback: function () {
					var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
					var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
						return new bootstrap.Tooltip(tooltipTriggerEl)
					});
					$('.form-select').select2({
						minimumResultsForSearch: Infinity,
						width: '100%'
					});
					$('#customCheckAll').prop('checked', false);
					$('.checkall').on('click', function(){
						if($('.checkall:checked').length == $('.checkall').length){
							$('#customCheckAll').prop('checked', true);
						}else{
							$('#customCheckAll').prop('checked', false);
						}
					});
				},
			});

			function loadDataTable() {
				// table_checkpoint.draw();
				$('#userdashboard').on('preXhr.dt', function (e, settings, data) {
					var category_id= $('#category_id').val();
					var priority_id = $('#priority_id').val();
					var created_start = $('#created_start').val();
					var created_end = $('#created_end').val();
					
					data['category_id'] = category_id;
					data['priority_id'] = priority_id;
					data['created_start'] = created_start;
					data['created_end'] = created_end;
				});
				table.draw();
			}
			$('#filters-apply-button').on('click', loadDataTable);

			$('#reset-filters').click(function () {

				$('#filter-form')[0].reset();
				$('#category_id').val('all').trigger('change');
				$('#priority_id').val('all').trigger('change');
				loadDataTable();
			})

			// Ticket Detele System
			$('body').on('click', '#show-delete', function () {
				var _id = $(this).data("id");
				swal({
					title: `{{trans('langconvert.admindashboard.wanttocontinue')}}`,
					text: "{{trans('langconvert.admindashboard.eraserecordspermanently')}}",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
				if (willDelete) {
					$.ajax({
							type: "get",
							url: SITEURL + "/customer/ticket/delete/"+_id,
							success: function (data) {
								toastr.error(data.error);
								$('#userdashboard').DataTable().ajax.reload();
							},
							error: function (data) {
							console.log('Error:', data);
							}
						});
					}
				});

			});

			//Mass Delete 
			$('body').on('click', '#massdelete', function () {

				var id = [];
		
				$('.checkall:checked').each(function(){
					id.push($(this).val());
				});
				if(id.length > 0){
					swal({
						title: `{{trans('langconvert.admindashboard.wanttocontinue')}}`,
						text: "{{trans('langconvert.admindashboard.eraserecordspermanently')}}",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {
							$.ajax({
								url:"{{ url('customer/ticket/delete/tickets')}}",
								method:"post",
								data:{id:id},
								success:function(data)
								{

									$('#userdashboard').DataTable().ajax.reload();
									toastr.error(data.error);
												
								},
								error:function(data){

								}
							});
						}
					});
								
				}else{
					toastr.error('{{trans('langconvert.functions.checkboxselect')}}');
				}

			});

			// Check All Checkbox
			$('#customCheckAll').on('click', function() {
				$('.checkall').prop('checked', this.checked);
			});

		})(jQuery);
	</script>
@endsection