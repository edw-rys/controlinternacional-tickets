<div class="col-xl-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header border-0">
            <h4 class="card-title">Tickets por categoría-prioridad-estado</h4>
            {{-- <h4 class="card-title">{{ trans('langconvert.admindashboard.priorityreports') }}</h4> --}}
        </div>
        <div class="card-body">
            {{-- FILTERS --}}
            <form id="form-filter-priority" action="{{ route('admin.reports.priority')}}" class="filter-form">
                <div class="mb-3">
                    @csrf
                    <div class="row">
                        {{-- <div class="col-xl-4 col-md-4 col-12">
                            <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.priority')}}</label>
                            <select class="form-control select2" data-placeholder="Select Priority" name="priority_id" >
                                <option value="all">Todos</option>
                                <option value="Critical">{{trans('langconvert.newwordslang.critical' )}}</option>
                                <option value="High">{{trans('langconvert.newwordslang.high' )}}</option>
                                <option value="Medium">{{trans('langconvert.newwordslang.medium' )}}</option>
                                <option value="Low">{{trans('langconvert.newwordslang.low' )}}</option>
                            </select>	
                        </div> --}}
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
                                <button type="button" class="btn btn-success" onclick="resetFiltersBody()"><i class="fa fa-check"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div id="box-search-body"></div>
            <div class="col-12" id="body-filter-priority"></div>
            <div class="col-12" id="body-filter-category"></div>
            <div class="col-12" id="body-filter-statuses"></div>
        </div>
    </div>
</div>


<script>
    function filterByReport(btnSelector, url, formSelector, bodySelector) {
        $(btnSelector).attr('disabled',false);
        $(btnSelector).removeAttr('disabled',false);
        $('#box-search-body').html('<h4>Buscando...</h4>');
        $(bodySelector).html('');
        $.ajax({
            type:'POST',
            url: url,
            data: $(formSelector).serialize(),
            cache:false,
            // contentType: false,
            processData: false,
            success: (data) => {
                $(bodySelector).html(data.html);
                $('#box-search-body').html('');
            },
            error: function(data){
                $('#box-search-body').html('');
            }
        });
    }
    function resetFiltersBody() {
        filterByReport('#btn-filter-priority', '{{ route('admin.reports.priority')}}', '#form-filter-priority', '#body-filter-priority');
        filterByReport('#btn-filter-category', '{{ route('admin.reports.category')}}', '#form-filter-priority', '#body-filter-category');
        filterByReport('#btn-filter-statuses', '{{ route('admin.reports.status')}}', '#form-filter-priority', '#body-filter-statuses');
    }
</script>