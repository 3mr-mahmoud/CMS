@extends('components.indexingTable')
@section('form-title',trans_choice('labels.users',4))
@section('table-headers')
                <th>#</th>
                <th>{{ __('validation.attributes.name')}}</th>
                <th>{{ __('validation.attributes.email')}}</th>
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
                "render": function ( data, type, row ) {
                    var prefix = '{{ controlPanelUrl('user') }}';
                    return `<a href="${prefix}/${row.id}/edit" class="btn cur-p btn-outline-primary">تحديث</a>
                    <a class="button btn-outline-danger" href="javascript:void(0)" onClick="Delete(this)">حذف</a>`;
                },
                "targets": 4
            }
        ],
      "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "email" },
            { "data": "created_at" },
            { "data": "permission" }
    ]
    });
} );
</script>
@endsection
