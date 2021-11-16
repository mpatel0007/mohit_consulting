@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Career Level')
@section('pagetitle', 'Career Level')
@section('pagesubtitle', ' Add Career Level')

@section('admincontent')
@include('Admin.career_level.addEditModal')

      <!-- Page Content  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">
                                <i class="fa fa-cog" aria-hidden="true"></i> Career Level</h4>
                        </div>
                        <div><button type="button" class="btn btn-primary" id="openModal">Add Career Level</button></div>
                            <!-- Add File Modal -->
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="career_level_datatable" class="table table-striped table-bordered">
                            <thead>
                                <th>Career Level</th>
                                <th>Status</th>
                                <th style="min-width: 200px">Action</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/admin/js/careerlevel.js')}}"></script>
@endsection