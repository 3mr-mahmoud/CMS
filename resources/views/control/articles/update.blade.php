@extends('control.layout.default')
@section('form-title',__('labels.update').' '.trans_choice('labels.articles',1))
@section('secondary-title')
{{ $data->title.__('labels.since').$data->created_at->diffForHumans() }}
@endsection
@section('form')
        @foreach($data->fields as $inputName)
        @include('components.'.$inputName)
        @endforeach
        <a href="javascript:void(0)" class="button btn-success" onclick="save(this)">@lang('labels.save')</a>
@endsection