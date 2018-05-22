@extends('control.layout.default')
@section('form')
     <table id="DataTable" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%">
        <thead>
            <tr>
                @yield('table-headers')
            </tr>
        </thead>
        <tfoot>
            <tr>
                @yield('table-headers')
            </tr>
        </tfoot>
        <tbody>
        </tbody>
    </table>
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
@yield('table-map')
@endsection