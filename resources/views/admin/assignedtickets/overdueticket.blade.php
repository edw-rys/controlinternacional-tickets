@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}?v=<?php echo time(); ?>"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />

    <!-- INTERNAL Sweet-Alert css -->
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span
                    class="font-weight-normal text-muted ms-2">{{ trans('langconvert.adminmenu.overduetickets') }}</span>
            </h4>
        </div>
    </div>
    <!--End Page header-->

    <!--Overdue Tickets List -->
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card ">
            <div class="card-header border-0">
                <h4 class="card-title">{{ trans('langconvert.adminmenu.overduetickets') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive spruko-delete">
                    @can('Ticket Delete')
                        <button id="massdelete" class="btn btn-outline-light btn-sm mb-4 ticketdeleterow data-table-btn"><i
                                class="fe fe-trash"></i> {{ trans('langconvert.admindashboard.delete') }}</button>
                    @endcan

                    <table class="table table-vcenter text-nowrap table-bordered table-striped w-100" id="overduetickets">
                        <thead>
                            <tr>
                                <th>{{ trans('langconvert.admindashboard.id') }}</th>
                                <th>{{ trans('langconvert.admindashboard.slNo') }}</th>
                                @can('Ticket Delete')
                                    <th width="10">
                                        <input type="checkbox" id="customCheckAll">
                                        <label for="customCheckAll"></label>
                                    </th>
                                @endcan
                                @cannot('Ticket Delete')
                                    <th width="10">
                                        <input type="checkbox" id="customCheckAll" disabled>
                                        <label for="customCheckAll"></label>
                                    </th>
                                @endcannot

                                <th>#{{ trans('langconvert.admindashboard.id') }}</th>
                                <th>{{ trans('langconvert.admindashboard.user') }}</th>
                                <th>{{ trans('langconvert.admindashboard.title') }}</th>
								<th>{{ trans('langconvert.admindashboard.tickethose') }}</th>
								<th>{{ trans('langconvert.admindashboard.priority') }}</th>
                                <th>{{ trans('langconvert.admindashboard.category') }}</th>
                                <th>{{ trans('langconvert.admindashboard.date') }}</th>
                                <th>{{ trans('langconvert.admindashboard.status') }}</th>
                                <th>{{ trans('langconvert.admindashboard.assignto') }}</th>
                                <th>{{ trans('langconvert.admindashboard.lastreply') }}</th>
                                <th>{{ trans('langconvert.admindashboard.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--End Overdue Tickets List -->
@endsection


@section('scripts')
    <!-- INTERNAL Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>


    <!-- INTERNAL Index js-->
    <script src="{{ asset('assets/js/support/support-sidemenu.js') }}"></script>
    <script src="{{ asset('assets/js/support/support-admindash.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    <!-- INTERNAL Sweet-Alert js-->
    <script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
        "use strict";

        (function($) {

            // Variables
            var SITEURL = '{{ url('') }}';

            // Csrf Field
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // DataTable
            var table = $('#overduetickets').DataTable({language : languajeDT,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('admin/overduetickets') }}"
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ticket_id',
                        name: 'ticket_id'
                    },
                    {
                        data: 'cust_id',
                        name: 'cust_id'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
					{
                        data: 'hose_id',
                        name: 'hose_id'
                    },
                    {
                        data: 'priority',
                        name: 'priority'
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'toassignuser_id',
                        name: 'toassignuser_id'
                    },
                    {
                        data: 'last_reply',
                        name: 'last_reply'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [],
                responsive: true,
                drawCallback: function() {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                        '[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    });
                    $('.form-select').select2({
                        minimumResultsForSearch: Infinity,
                        width: '100%'
                    });
                    $('#customCheckAll').prop('checked', false);
                },
            });

            // TICKET DELETE SCRIPT
            $('body').on('click', '#show-delete', function() {
                var _id = $(this).data("id");
                swal({
                        title: `{{ trans('langconvert.admindashboard.wanttocontinue') }}`,
                        text: "{{ trans('langconvert.admindashboard.eraserecordspermanently') }}",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "get",
                                url: SITEURL + "/admin/delete-ticket/" + _id,
                                success: function(data) {
                                    toastr.error(data.error);
                                    var oTable = $('#overduetickets').dataTable();
                                    oTable.fnDraw(false);
                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                }
                            });
                        }
                    });

            });

            //Mass Delete 
            $('body').on('click', '#massdelete', function() {
                var id = [];
                $('.checkall:checked').each(function() {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    swal({
                            title: `{{ trans('langconvert.admindashboard.wanttocontinue') }}`,
                            text: "{{ trans('langconvert.admindashboard.eraserecordspermanently') }}",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "{{ url('admin/ticket/delete/tickets') }}",
                                    method: "GET",
                                    data: {
                                        id: id
                                    },
                                    success: function(data) {
                                        $('#overduetickets').DataTable().ajax.reload();
                                        toastr.error(data.error);
                                    },
                                    error: function(data) {

                                    }
                                });
                            }
                        });
                } else {
                    toastr.error('{{ trans('langconvert.functions.checkboxselect') }}');
                }
            });

            // when user click its get modal popup to assigned the ticket
            $('body').on('click', '#assigned', function() {
                var assigned_id = $(this).data('id');
                $('.select2_modalassign').select2({
                    dropdownParent: ".sprukosearch",
                    minimumResultsForSearch: '',
                    placeholder: "Search",
                    width: '100%'
                });

                $.get('assigned/' + assigned_id, function(data) {
                    $('#AssignError').html('');
                    $('#assigned_id').val(data.assign_data.id);
                    $(".modal-title").text('{{ trans('langconvert.admindashboard.assigntoagent') }}');
                    $('#username').html(data.table_data);
                    $('#addassigned').modal('show');
                });
            });

            // Assigned Submit button 
            $('body').on('submit', '#assigned_form', function(e) {
                e.preventDefault();
                var actionType = $('#btnsave').val();
                var fewSeconds = 2;
                $('#btnsave').html('Sending..');
                $('#btnsave').prop('disabled', true);
                setTimeout(function() {
                    $('#btnsave').prop('disabled', false);
                }, fewSeconds * 1000);
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: SITEURL + "/admin/assigned/create",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#AssignError').html('');
                        $('#assigned_form').trigger("reset");
                        $('#addassigned').modal('hide');
                        $('#btnsave').html('{{ trans('langconvert.admindashboard.savechanges')}}');
                        var oTable = $('#overduetickets').dataTable();
                        oTable.fnDraw(false);
                        toastr.success(data.success);
                    },
                    error: function(data) {
                        $('#AssignError').html('');
                        $('#AssignError').html(data.responseJSON.errors.assigned_user_id);
                        $('#btnsave').html('{{ trans('langconvert.admindashboard.savechanges')}}');
                    }
                });
            });

            // Remove the assigned from the ticket
            $('body').on('click', '#btnremove', function() {
                var asid = $(this).data("id");
                swal({
                        title: `{{ trans('langconvert.admindashboard.agentremove') }}`,
                        text: "{{ trans('langconvert.admindashboard.agentremove1') }}",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            $.ajax({
                                type: "get",
                                url: SITEURL + "/admin/assigned/update/" + asid,
                                success: function(data) {
                                    var oTable = $('#overduetickets').dataTable();
                                    oTable.fnDraw(false);
                                    toastr.error(data.error);
                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                }
                            });

                        }
                    });



            });

            // Checkbox checkall
            $('#customCheckAll').on('click', function() {
                $('.checkall').prop('checked', this.checked);
            });

        })(jQuery);
    </script>
@endsection

@section('modal')
    <!-- Assigned Tickets-->
    <div class="modal fade sprukosearch" id="addassigned" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="assigned_form" name="assigned_form">
                    @csrf
                    @honeypot
                    <input type="hidden" name="assigned_id" id="assigned_id">
                    @csrf
                    <div class="modal-body">

                        <div class="custom-controls-stacked d-md-flex">
                            <select class="form-control select2_modalassign" data-placeholder="Select Agent"
                                name="assigned_user_id" id="username">

                            </select>
                        </div>
                        <span id="AssignError" class="text-danger"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" id="btnsave">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Assigned Tickets  -->
@endsection
