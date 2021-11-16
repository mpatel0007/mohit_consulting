@extends('Front_end.layouts.home.homeindex')
@section('pagetitle','Manage Applications')
@section('pageheader','Manage Applications')
@section('content')
@include('Front_end.employers.application_reject_reason_modal')
    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
                        <h3 class="alerts-title">Manage Applications</h3>
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
                        @if (count($errors))
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.
                                <br />
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <table id="manage_applications_table" class="table table-sm">
                                <thead>
                                    <th style="max-width: 210px;"><p>Job Title</p></th>
                                    <th><p>Candidate</p></th>
                                    <th><p>Number</p></th>
                                    <th><p>Job Type</p></th>
                                    <th><p>Date</p></th>
                                    <th><p>Status</p></th>
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

