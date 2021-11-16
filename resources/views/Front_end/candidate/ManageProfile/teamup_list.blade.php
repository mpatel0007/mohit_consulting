@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Team List')
@section('pageheader', 'Team List')
@section('content')

@include('Front_end.candidate.ManageProfile.create_new_team')
@include('Front_end.candidate.ManageProfile.create_new_task')
    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul></ul>
                    </div>
                    <div class="job-alerts-item candidates">
                        <h3 class="alerts-title">Team List
                        <a href="{{ route('front_end-candidate-team-request-view') }}" class="btn btn-success btn-xs pull-right mr-1">Team Request<span class="reqnumber">{{Helper::CountOfRequest()}}</span></a>
                        <a href="{{ route('front_end-candidate-team-joined-view') }}" class="btn btn-success btn-xs pull-right mr-1">Joined Team</a> 
                        {{-- <a href="{{ route('front_end-candidate-new-teamup') }}" class="btn btn-success btn-xs pull-right mr-1">New Team</a></h3> --}}
                        <button class="btn btn-success btn-xs pull-right mr-1" id="createNewteam">New Team</button></h3>
                            <table id="teamup_list" class="table table-sm" style="text-align:center">
                                <thead>
                                    <th><p>Team Name</p></th>
                                    <th><p>Created Date</p></th>
                                    <th><p>Team Members</p></th>
                                    <th><p>Team Task</p></th>
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

