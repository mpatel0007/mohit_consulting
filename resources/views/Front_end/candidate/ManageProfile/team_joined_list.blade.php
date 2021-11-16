@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Team Join List')
@section('pageheader', 'Team Join List')
@section('content')

    <div id="content">
        @include('Front_end.candidate.ManageProfile.my_task_list')
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
                        <div class="box-tools float-right">
                            <a href="{{ route('front_end-candidate-teamup-list-view') }}" class="btn btn-common btn-sm"><i class="fa fa-caret-left"></i> Go Back</a>
                        </div>
                            <table id="Team_joined_list" class="table table-sm">
                                <thead style="justify-content: center;">
                                    <th><p>Team Name</p></th>
                                    <th><p>Team Creator Name</p></th>
                                    <th><p>Teammates</p></th>
                                    <th><p>Team Join Date</p></th>
                                    <th><p>Leave Team</p></th>
                                    <th><p>View Task</p></th>
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

