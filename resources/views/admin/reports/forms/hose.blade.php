<div class="col-xl-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header border-0">
            <h4 class="card-title">{{ trans('langconvert.admindashboard.hosesreports') }}</h4>
        </div>
        <div class="card-body">
            {{-- FILTERS --}}
            <form action="{{ route('admin.reports.hoses')}}" method="POST" class="filter-form">
                <div class="mb-3">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-12">
                            <label class="form-label mb-0 mt-2">{{trans('langconvert.adminmenu.customers')}}</label>
                            <select
                                style="width: 100%"
                                multiple
                                class="form-control select2-show-search select2"
                                data-placeholder="Selecciona estación" name="customer_hose_id" id="customer_hose_id">
                                {{-- <option value="all">Todos</option> --}}
                            </select>
                        </div>
                        <div class="col-xl-4 col-md-4 col-12">
                            <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.status')}}</label>
                            <select class="form-control select2" data-placeholder="Select Priority" name="status">
                                <option value="all">Todos</option>
                                <option value="overdue">{{trans('langconvert.adminmenu.activetickets' )}}</option>
                                <option value="onhold">{{trans('langconvert.adminmenu.onholdtickets' )}}</option>
                                <option value="closed">{{trans('langconvert.adminmenu.closetickets' )}}</option>
                            </select>	
                        </div>
                        @if (isset($categories))
                            <div class="col-xl-4 col-md-4 col-12">
                                <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.ticketcategory')}}</label>
                                <select
                                    class="form-control select2-show-search select2"
                                    data-placeholder="Selecciona Categoría" name="category_id">
                                    <option value="all">Todos</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-xl-4 col-md-4 col-12">
                            <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.priority')}}</label>
                            <select class="form-control select2" data-placeholder="Select Priority" name="priority_id">
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
                                <button type="submit" class="btn btn-success"><i class="fas fa-excel"></i> Exportar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>