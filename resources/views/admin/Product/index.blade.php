@extends('layouts.admin')
@section('content')
@can('product_category_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.product.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.product.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Product">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.product.fields.uid') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.bar_code_id') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.product_category_id') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.is_active') }}
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
        @can('product_delete')
            let deleteButtonTrans = "{{ trans('global.datatables.delete') }}";
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.product.massDestroy') }}",
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
            ajax: "{{ route('admin.product.index') }}",
            columns: [{
                    data: 'placeholder',
                    name: 'placeholder',
                },
                {
                    data: 'uid',
                    name: 'uid',
                },
                {
                    data: 'bar_code_id',
                    name: 'bar_code_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'product_category',
                    name: 'product_category.name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'actions',
                    name: '{{ trans("global.actions") }}'
                }
            ],
            orderCellsTop: true,
            pageLength: 100,
        };
        let table = $('.datatable-Product').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    });
</script>
@endsection