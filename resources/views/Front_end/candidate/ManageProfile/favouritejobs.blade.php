@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Favourite Jobs')
@section('pageheader', 'Favourite Jobs')
@section('content')

    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
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
                        <h3 class="alerts-title">Favourite Jobs
                            <a href="{{ route('front_end-candidate_manageprofile') }}" class="btn btn-success btn-xs pull-right"><i class="fa fa-chevron-circle-left"></i> Go Back</a>
                        </h3>
                            <table id="Favourite_Jobs" class="table table-sm">
                                <thead>
                                    <th><p>Job Title</p></th>
                                    <th><p>Job Type</p></th>
                                    {{-- <th><p>Job Status</p></th> --}}
                                    <th><p>Apply Now</p></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footersection')
        <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/manageprofile.js') }}"></script>
    @endsection

