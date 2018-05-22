@extends('components.adding-form')
@section('form-title',__('labels.add').' ')
@section('form-fields')
        @foreach((new \App\Article)->fields as $inputName)
        @include('components.'.$inputName)
        @endforeach
 @endsection