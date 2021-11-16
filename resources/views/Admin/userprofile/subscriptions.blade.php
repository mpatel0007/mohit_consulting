@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'User Subscriptions')
@section('pagetitle', 'Users Profile')
@section('pagesubtitle', 'Users Profile')
@section('subtitle', 'User Subscriptions')
@section('admincontent')

@include('Admin.userprofile.viewcharge')


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> User Subscriptions</h4>
                        </div>
                        <div class="box-tools float-right">
                            <a href="{{ route('admin-userprofile-list') }}" class="btn btn-primary btn-sm"><i class="fa fa-caret-left"></i> Go Back</a>
                        </div>
                    </div>
                    
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <input type="hidden" id="userId" name="userId" value="{{isset($userId) ? $userId : ''}}">
                        <table id="User_Subscriptions_table" class="table table-striped table-bordered">
                            {{ csrf_field() }}
                            <thead>
                                <th>Package Name</th>
                                <th>Customer ID</th>
                                <th>Charge</th>
                                <th>Start Date </th>
                                <th>End Date </th>
                                <th style="min-width: 200px">View Charge</th>
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