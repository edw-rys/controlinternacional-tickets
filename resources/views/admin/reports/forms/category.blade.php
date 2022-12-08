<div class="col-xl-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header border-0">
            <h4 class="card-title">{{ trans('langconvert.admindashboard.categoryreports') }}</h4>
        </div>
        <div class="card-body">
            {{-- FILTERS --}}
            <form id="form-filter-category" action="{{ route('admin.reports.category')}}" class="filter-form" onsubmit="return false">
                <div class="mb-3">
                    @csrf
                    <div class="row">
                        @if (isset($categories))
                            <div class="col-xl-4 col-md-4 col-12">
                                <label class="form-label mb-0 mt-2">{{trans('langconvert.admindashboard.ticketcategory')}}</label>
                                <select
                                    class="form-control select2-show-search select2"
                                    data-placeholder="Selecciona Categoría" name="category_id" >
                                    <option value="all">Todos</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
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
                                <button type="button" class="btn btn-success" onclick="filterByReport('#btn-filter-category', '{{ route('admin.reports.category')}}', '#form-filter-category', '#body-filter-category')"><i class="fa fa-check"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div id="body-filter-category">
            </div>
        </div>
    </div>
</div>

<script>
    function filterByReport(btnSelector, url, formSelector, bodySelector) {
        $(btnSelector).attr('disabled',false);
        $(btnSelector).removeAttr('disabled',false);
        $(bodySelector).html('<h4>Buscando...</h4>');
        $.ajax({
            type:'POST',
            url: url,
            data: $(formSelector).serialize(),
            cache:false,
            // contentType: false,
            processData: false,
            success: (data) => {
                $(bodySelector).html(data.html);
            },
            error: function(data){

            }
        });
        
    }
</script>