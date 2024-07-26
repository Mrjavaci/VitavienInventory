@extends('system::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('system.name') !!}</p>
@endsection
