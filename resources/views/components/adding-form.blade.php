@extends('control.layout.default')

@section('form')
<form method="post">
    {{ csrf_field() }}
    @yield('form-fields')
        <button type="submit" class="button btn-primary">@lang('labels.add')</button>
</form>
@endsection