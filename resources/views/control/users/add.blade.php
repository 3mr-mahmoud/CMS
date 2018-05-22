@extends('components.adding-form')

@section('form-title',__('labels.add').' '.__('labels.'))

@php
$fields = ['name','username','email','password','admin'];
@endphp


@section('form-fields')
        @foreach($fields as $inputName)
        @include('components.'.$inputName)
        @endforeach
 @endsection