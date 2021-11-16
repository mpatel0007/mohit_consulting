@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Team Members List')
@section('pageheader', 'Team Members List')
@section('content')
@include('Front_end.candidate.ManageProfile.gave_task_member')
    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
                        <input type="hidden" id="team_id" name="team_id" value="{{isset($team_id) ? $team_id : ''}}">
                        <div class="box-tools float-right">
                            {{-- <a href="{{ route('front_end-candidate-new-teamup') }}" class="btn btn-common btn-xs pull-right mr-1"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i></a></h3> --}}
                            <a href="{{ route('front_end-candidate-teamup-list-view') }}" class="btn btn-common btn-sm"><i class="fa fa-caret-left"></i> Go Back</a>
                        </div>
                            <table id="Team_member_list" class="table table-sm">
                                <thead>
                                    <th><p>Team Name</p></th>
                                    <th><p>Team Member Name</p></th>
                                    <th><p>Status</p></th>
                                    <th><p>Delete</p></th>
                                    <th><p>Assign Task</p></th>
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

