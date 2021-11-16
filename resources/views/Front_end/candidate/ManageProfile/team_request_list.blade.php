@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Team Request List')
@section('pageheader', 'Team Request List')
@section('content')
@include('Front_end.candidate.ManageProfile.team_up_message_modal')
    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
                        <div class="box-tools float-right">
                            <a href="{{ route('front_end-candidate-teamup-list-view') }}" class="btn btn-common btn-sm"><i class="fa fa-caret-left"></i> Go Back</a>
                        </div>
                            <table id="Team_request_list" class="table table-sm">
                                <thead>
                                    <th><p>Team Name</p></th>
                                    <th><p>Team Creator Name</p></th>
                                    <th><p>Team Created At</p></th>
                                    <th><p>Action</p></th>
                                    <th><p>Message</p></th>
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
            <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/teamup.js') }}"></script>
    @endsection


    