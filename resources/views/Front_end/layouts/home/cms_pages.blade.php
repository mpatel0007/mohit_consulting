@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', ucfirst($cmsData->title))
@section('pageheader', ucfirst($cmsData->title))
@section('content')

<div id="loader"></div>
    <div class="contact-form">
        <div class="container">
            <div class="row contact-form-area">
                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class="contact-block">
                        <div class="alert alert-danger print-error-msg" style="display:none;">
                            <ul></ul>
                        </div>
                        {!! $cmsData->descriptioneditor !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    

@endsection
@section('footersection')
    {{--  --}}
@endsection
