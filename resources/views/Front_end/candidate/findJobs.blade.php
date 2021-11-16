@extends('Front_end.layouts.home.homeindex')
{{-- @extends('Front_end.layouts.home.homeindex') --}}
@section('pagetitle', 'Find Jobs')
@section('pageheader', 'Find Jobs')
@section('content')
@section('headersection')
<link rel="stylesheet" href="{{asset('assets/front_end/css/notfound.css')}}">
@endsection
@section('pageheader_content')
@include('Front_end.candidate.ManageProfile.appliedjobs_attachment_modal')

<input type="hidden" id="numberOfRecord" name="numberOfRecord" value="<?php echo isset($numberOfRecord) ? $numberOfRecord : 0; ?>">
<input type="hidden" id="scroll" name="scroll">
    <div class="job-search-form bg-cyan job-featured-search">
        <form id="find_jobs_form" name="find_jobs_form">
            {{ csrf_field() }}
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" type="text" id="search_jobs" name="search_jobs"
                            value="{{ isset($home_search) ? $home_search : '' }}" placeholder="Job Title or Company Name">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <div class="search-category-container">
                            <label class="styled-select">
                                <select class="form-control" id="country" name="country" required>
                                    <option value="">-- Select Country --</option>
                                    @foreach ($country as $country)
                                        <option class="custom-select" value='{{ $country->id }}' 
                                            <?php if (isset($home_country)) { if ($home_country==$country->id) { echo 'selected'; } } ?> >{{ $country->country_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <i class="lni-map-marker"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="form-group">
                        <div class="search-category-container">
                            <label class="styled-select">
                                <select class="form-control" id="category" name="category" required>
                                    <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option class="custom-select" value='{{ $category->id }}' 
                                                <?php if (isset($home_category)) { if ($home_category==$category->id) { echo 'selected'; } } ?> >{{ $category->industry_name }}
                                            </option>
                                        @endforeach
                                </select>
                            </label>
                        </div>
                        <i class="lni-map-marker"></i>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-xs-12">
                    <button type="button" id="find_jobs_candidate" class="button btn btn-common"><i
                            class="lni-search"></i></button>
                </div>
            </div>
        </form>
    </div>
@endsection

<section id="job-listings" class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
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
            </div>
            {{-- @if (!Auth::guard('employers')->check()) --}}
                <div id="jobs_search_data" class="job-listings">
                    @include('Front_end.candidate.findjobsrender')
                </div>
            {{-- @endif --}}
        </div>
    </div>
</section>
    
@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/findjobs.js') }}"></script>
@endsection
