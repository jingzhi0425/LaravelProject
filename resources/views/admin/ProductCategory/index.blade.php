@extends('layouts.admin')
@section('content')
@can('product_category_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.product-category.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.product_category.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.product_category.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ProductCategory">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.product_category.fields.uid') }}
                    </th>
                    <th>
                        {{ trans('cruds.product_category.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product_category.fields.is_active') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('product_category_delete')
            let deleteButtonTrans = "{{ trans('global.datatables.delete') }}";
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.product-category.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                    return entry.id
                });

                if (ids.length === 0) {
                    alert("{{ trans('global.datatables.zero_selected') }}")

                    return
                }

                if (confirm("{{ trans('global.areYouSure') }}")) {
                    $.ajax({
                    headers: {'x-csrf-token': _token},
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'POST' }})
                    .done(function () { location.reload() })
                }
                }
            }
            dtButtons.push(deleteButton)
        @endcan

        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('admin.product-category.index') }}",
            columns: [
                {data: 'placeholder', name: 'placeholder'},
                {data: 'uid', name: 'uid'},
                {data: 'name',name: 'name'},
                {data: 'is_active',name: 'is_active'},
                {data: 'actions',name: '{{ trans('global.actions') }}'}
            ],
            orderCellsTop: true,
            pageLength: 100,
        };
        let table = $('.datatable-ProductCategory').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    });
</script>
@endsection