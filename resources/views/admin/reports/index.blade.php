@extends('layouts.adminmaster')

@section('styles')
    <!-- INTERNAL Data table css -->
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}?v=<?php echo time(); ?>"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/buttonbootstrap.min.css') }}?v=<?php echo time(); ?>" rel="stylesheet" />
@endsection

@section('content')
    <!--Page header-->
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <h4 class="page-title"><span
                    class="font-weight-normal text-muted ms-2">{{ trans('langconvert.adminmenu.report') }}</span></h4>
        </div>
    </div>
    <!--End Page header-->

    <!--Reports List-->
    <div class="row">
        <div class="col-xl-6 col-md-10 col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="card-title">{{ trans('langconvert.menu.ticket') }}</h4>
                </div>
                <div class="card-body">
                    <div id="ticketchart" class=""></div>
                    <div class="sales-chart pt-5 pb-3 d-flex mx-auto text-center justify-content-center ">
                        <div class="d-flex me-2"><span
                                class="dot-label bg-success me-2 my-auto"></span>{{ trans('langconvert.admindashboard.new') }}
                        </div>
                        <div class="d-flex me-2"><span
                                class="dot-label bg-info  me-2 my-auto"></span>{{ trans('langconvert.admindashboard.inprogress') }}
                        </div>
                        <div class="d-flex me-2"><span
                                class="dot-label bg-warning  me-2 my-auto"></span>{{ trans('langconvert.admindashboard.onhold') }}
                        </div>
                        <div class="d-flex me-2"><span
                                class="dot-label bg-teal  me-2 my-auto"></span>{{ trans('langconvert.admindashboard.reopen_chart') }}
                        </div>
                        <div class="d-flex me-2"><span
                                class="dot-label bg-danger  me-2 my-auto"></span>{{ trans('langconvert.admindashboard.closed') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

		

        @honeypot
        
		{{-- Customer --}}
		@include('admin.reports.forms.customer')
		{{-- END Customer --}}
        
        {{-- HOSE --}}
		@include('admin.reports.forms.hose')
		{{-- END HOSE --}}

		{{-- Status --}}
		{{-- @include('admin.reports.forms.status') --}}
		{{-- END Status --}}

        {{-- PRIORITY --}}
		@include('admin.reports.forms.priority')
		{{-- END PRIORITY --}}


        
		{{-- Category --}}
		{{-- @include('admin.reports.forms.category') --}}
		{{-- END Category --}}
        
    </div>
    <!--End Reports List-->
@endsection


@section('scripts')
    <!-- INTERNAL Apexchart js-->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.js') }}?v=<?php echo time(); ?>"></script>

    <!-- INTERNAL Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/datatablebutton.min.js') }}?v=<?php echo time(); ?>"></script>
    <script src="{{ asset('assets/plugins/datatable/buttonbootstrap.min.js') }}?v=<?php echo time(); ?>"></script>
	<script src="{{asset('assets/js/select2.js')}}"></script>

    <script type="text/javascript">
        "use strict";
        // End User Chart

        // End Customer Chart

        // Ticket Chart
        var ticketchart = {
            series: [{{ $newticket }}, {{ $inprogressticket }}, {{ $onholdticket }}, {{ $reopenticket }},
                {{ $closedticket }}
            ],
            chart: {
                height: 300,
                type: 'donut',
            },
            dataLabels: {
                enabled: false
            },

            legend: {
                show: false,
            },
            stroke: {
                show: true,
                width: 0
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '29px',
                                color: '#6c6f9a',
                                offsetY: -10
                            },
                            value: {
                                show: true,
                                fontSize: '26px',
                                color: undefined,
                                offsetY: 16,
                                formatter: function(val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                showAlways: false,
                                label: '{{ trans('langconvert.admindashboard.total') }}',
                                fontSize: '22px',
                                fontWeight: 600,
                                color: '#373d3f',
                            }

                        }
                    }
                }
            },
            responsive: [{
                options: {
                    legend: {
                        show: false,
                    }
                }
            }],
            labels: ["New", "Inprogress", "On-Hold", "Re-Open", "Closed"],
            colors: ['#0dcd94', '#128af9', '#fbc518', '#17d1dc', '#f7284a'],
        };
        var chart = new ApexCharts(document.querySelector("#ticketchart"), ticketchart);
        chart.render();
        // End Ticket Chart

        (function($) {

			$("#customers_id").select2({
                ajax: {
                    url: "{{ route('customer-list-json') }}?no_all=1",
                    processResults: function (data) {
                        console.log($.map(data, function(obj) {
                                return { id: obj.id, text: obj.username };
                            }));
                        return {
                            results: $.map(data, function(obj) {
                                return { id: obj.id, text: obj.username };
                            }),
                            pagination: {
                                // En caso de que no necesites paginar
                                more: false
                            }
                        };
                    }
                },
                language: 'es',
            });
            $("#customer_hose_id").select2({
                ajax: {
                    url: "{{ route('customer-list-json') }}?no_all=1",
                    processResults: function (data) {
                        console.log($.map(data, function(obj) {
                                return { id: obj.id, text: obj.username };
                            }));
                        return {
                            results: $.map(data, function(obj) {
                                return { id: obj.id, text: obj.username };
                            }),
                            pagination: {
                                // En caso de que no necesites paginar
                                more: false
                            }
                        };
                    }
                },
                language: 'es',
            });

            
        })(jQuery);
    </script>
@endsection
