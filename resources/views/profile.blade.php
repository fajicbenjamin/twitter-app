@extends('layouts.default')

@section('content')
    <home-timeline :data="{{ $data }}"></home-timeline>
@endsection