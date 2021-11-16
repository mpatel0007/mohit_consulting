@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Degree Level')
@section('pagetitle', 'Degree Level')
@section('pagesubtitle', 'Add Degree Level')

@section('admincontent')
@include('Admin.degreelevel.degreelevelmodal')

      <!-- Page Content  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Degree Level</h4>
                        </div>
                        <div><button type="button" class="btn btn-primary" id="openModal">Add Degree Level</button></div>
                            <!-- Add File Modal -->
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="degreelevel_datatable" class="table table-striped table-bordered">
                            <thead>
                                <th>Degree Level</th>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/degreelevel.js')}}"></script>
@endsection