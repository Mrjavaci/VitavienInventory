@extends('dispatch::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('dispatch.name') !!}</p>
@endsection
