@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Jobs List')
@section('pagetitle', 'Jobs')
@section('pagesubtitle', 'Jobs')
@section('subtitle', 'Jobs List')
@section('admincontent')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Jobs List</h4>
                        </div>
                        <div class="box-tools float-right">
                            <a href="{{ route('admin-jobs-form') }}" class="btn btn-primary btn-sm">Add New Jobs</a>
                        </div>
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="jobs_list_table" class="table table-striped table-bordered">
                            {{ csrf_field() }}
                            <thead>
                                <th>Jobs Title</th>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/jobs.js')}}"></script>
@endsection