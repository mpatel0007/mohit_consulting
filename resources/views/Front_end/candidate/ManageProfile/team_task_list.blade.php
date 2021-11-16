@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Team Task List')
@section('pageheader', 'Team Task List')
@section('content')
@include('Front_end.candidate.ManageProfile.create_new_task')
    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
                        <div class="box-tools float-right">
                            <a href="{{ route('front_end-candidate-teamup-list-view') }}" class="btn btn-common btn-sm"><i class="fa fa-caret-left"></i> Go Back</a>
                        </div>
                        
                        <input type="hidden" id="team_id" name="team_id" value="<?php echo isset($team_id) ? $team_id : '' ?>">
                            <table id="Team_task_list" class="table table-sm">
                                <thead>
                                    <th><p>Team Title</p></th>
                                    <th><p>Team Creator Name</p></th>
                                    <th><p>Task Name</p></th>
                                    <!-- <th><p>Task Description</p></th> -->
                                    <th><p>Attachments</p></th>
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
            <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/teamup.js') }}"></script>
    @endsection

