@extends('control.layout.default')
@section('form-title',__('labels.update').' '.trans_choice('labels.users',1))

@php
$fields = ['name','username','email','password','admin'];
@endphp

@section('form')
        @foreach($fields as $inputName)
        @include('components.'.$inputName)
        @endforeach
        <a href="javascript:void(0)" class="button btn-success" onclick="save(this)">@lang('labels.save')</a>
@endsection