@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Team up Action')
@section('pageheader', 'Team up Action')
@section('content')
@if (\Session::has('success'))
<div class="alert alert-success">
    <ul>
        <li>{!! \Session::get('success') !!}</li>
    </ul>
</div>
@endif
@if (\Session::has('error'))
<div class="alert alert-danger">
    <ul>
        <li>{!! \Session::get('error') !!}</li>
    </ul>
</div>
@endif
@endsection