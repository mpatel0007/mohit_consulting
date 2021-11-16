@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Manage Jobs')
@section('pageheader', 'Manage Job')
@section('content')

    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
                        <h3 class="alerts-title">Manage Jobs
                            <a href="{{ route('front_end-jobs-form') }}" class="btn btn-success btn-xs pull-right">Post New Job</a>
                        </h3>

                            <table id="manage_jobs" class="table table-sm">
                                <thead>
                                    <th><p>Name</p></th>
                                    <th><p>Job Type</p></th>
                                    {{-- <th><p>Candidate</p></th> --}}
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
        <script type="text/javascript" src="{{ asset('assets/front_end/js/employers/jobs.js') }}"></script>
    @endsection

