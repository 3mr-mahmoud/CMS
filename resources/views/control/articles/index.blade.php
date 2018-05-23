@extends('components.indexingTable')
@section('form-title',trans_choice('labels.articles',1))
@section('table-headers')
                <th>#</th>
                <th>{{ __('Validation.attributes.title')}}</th>
                <th>{{ __('labels.created_at')}}</th>
                <th>{{ __('labels.actions')}}</th>
@endsection
@section('table-map')
<script type="text/javascript">
  $(document).ready(function() {
    $('#DataTable').DataTable({
      'ajaxSource': location.pathname,
      "columnDefs": [
            {
                "data":0,
                "render": function ( data, type, row ) {
                    var prefix = '{{ controlPanelUrl('article') }}';
                    return `<a href="${prefix}/${row.id}/edit" class="btn cur-p btn-outline-primary">تحديث</a>
                    <a class="button btn-outline-danger" href="javascript:void(0)" onClick="Delete(this)">حذف</a>`;
                },
                "targets": 3
            }
        ],
      "columns": [
            { "data": "id" },
            { "data": "title" },
            { "data": "created_at" },
            { "data": "" }
    ]
    });
} );
</script>
@endsection
