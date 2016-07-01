@extends('desafio.base')

@section('desafio_content')
@if (auth()->user()->type > 1)
    @include('desafio.professor')
@else
    @include('desafio.aluno')
@endif
@stop
