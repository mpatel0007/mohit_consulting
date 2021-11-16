@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Blogs List')
@section('pagetitle', 'Blogs')
@section('pagesubtitle', 'Blogs')
@section('subtitle', 'Blogs List')
@section('admincontent')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Blogs List</h4>
                        </div>
                        <div class="box-tools float-right">
                            <a href="{{ route('admin-blogs-form') }}" class="btn btn-primary btn-sm">Add Blog</a>
                        </div>
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="Blog_list_table" class="table table-striped table-bordered">
                            {{ csrf_field() }}    
                            <thead>
                                <th>Name</th>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/blogs.js')}}"></script>
@endsection