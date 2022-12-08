<div class="col-xl-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header border-0">
            <h4 class="card-title">{{ trans('langconvert.admindashboard.statusreports') }}</h4>
        </div>
        <div class="card-body">
            {{-- FILTERS --}}
            <form  id="form-filter-statuses" action="{{ route('admin.reports.category')}}" class="filter-form">
                <div class="mb-3">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-12">
                            <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.status')}}</label>
                            <select class="form-control select2" data-placeholder="Seleccione estados" name="status">
                                <option value="all">Todos</option>
                                <option value="active">{{trans('langconvert.adminmenu.activetickets' )}}</option>
                                <option value="onhold">{{trans('langconvert.adminmenu.onholdtickets' )}}</option>
                                <option value="closed">{{trans('langconvert.adminmenu.closetickets' )}}</option>
                                <option value="overdue">{{trans('langconvert.adminmenu.overduetickets' )}}</option>
                                <option value="reopen">{{trans('langconvert.statuses.Re-Open' )}}</option>
                                
                            </select>	
                        </div>
                        <div class="col-xl-4 col-md-4 col-12">
                            <label class="form-label mb-0 mt-2">Creado desde</label>
                            <div class="header-datepicker me-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                    </div><input class="form-control fc-datepicker pb-0 pt-0" value="" name="created_start" type="date" >
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-12">
                            <label class="form-label mb-0 mt-2">Creado desde</label>
                            <div class="header-datepicker me-3">
                                <div class="input-group">
                                    <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                    </div><input class="form-control fc-datepicker pb-0 pt-0" value="" name="created_end" type="date" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="form-group m-t-10">
                                <button type="button" class="btn btn-success" onclick="filterByReport('#btn-filter-statuses', '{{ route('admin.reports.status')}}', '#form-filter-statuses', '#body-filter-statuses')"><i class="fa fa-check"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>