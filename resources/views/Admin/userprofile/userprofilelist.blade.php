@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Users List')
@section('pagetitle', 'Users Profile')
@section('pagesubtitle', 'Users Profile')
@section('subtitle', 'Users List')
@section('admincontent')

@include('Admin.userprofile.uploadedDocument')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Users List</h4>
                        </div>
                        <div class="box-tools float-right">
                            <a href="{{ route('admin-userprofile-form') }}" class="btn btn-primary btn-sm">Add User</a>
                        </div>
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="Userprofile_list_table" class="table table-striped table-bordered">
                            {{ csrf_field() }}
                            <thead>
                                <th>Name</th>
                                <th>Email</th>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/userprofile.js')}}"></script>
@endsection