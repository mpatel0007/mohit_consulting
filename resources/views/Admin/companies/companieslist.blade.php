@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Companies List')
@section('pagetitle', 'Companies')
@section('pagesubtitle', 'Companies')
@section('subtitle', 'Companies List')
@section('admincontent')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Companies List</h4>
                        </div>
                        <div class="box-tools float-right">
                            <a href="{{ route('admin-companies-form') }}" class="btn btn-primary btn-sm">Add New Company</a>
                        </div>
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="Company_list_table" class="table table-striped table-bordered">
                            {{ csrf_field() }}
                            <thead>
                                <th>Company Name</th>
                                <th>Company Email</th>
                                <th>Company Status</th>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/companies.js')}}"></script>
@endsection