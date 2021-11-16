@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Admin List')
@section('pagetitle', 'Admin List')
@section('pagesubtitle', 'Admins')
@section('admincontent')
@include('Admin.admin.adminmodal')
      <!-- Page Content  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Admin</h4>
                        </div>
                        <div><button type="button" class="btn btn-primary" id="openModal">Create New Admin</button></div>
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="admins_datatable" class="table table-striped table-bordered">
                            <thead>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Is Admin</th>
                                <th>Role </th>
                                <th>Status</th>
                                <th>Action</th>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/admin.js')}}"></script>
@endsection