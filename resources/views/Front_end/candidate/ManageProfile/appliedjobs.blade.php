@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Applied Jobs')
@section('pageheader', 'Applied Jobs')
@section('content')

    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
                        <h3 class="alerts-title">Applied Jobs
                            <a href="{{ route('front_end-candidate-favourite-jobs-view') }}" class="btn btn-success btn-xs pull-right">Favourite Jobs</a>
                        </h3>
                            <table id="Applied_Jobs" class="table table-sm">
                                <thead>
                                    <th><p>Job Title</p></th>
                                    {{-- <th><p>Job Type</p></th> --}}
                                    <th><p>Job Status</p></th>
                                    <th><p>Applied At</p></th>
                                    <th><p>Action</p></th>
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

