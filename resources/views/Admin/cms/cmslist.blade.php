@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'CMS List')
@section('pagetitle', 'CMS')
@section('pagesubtitle', 'CMS')
@section('subtitle', 'CMS List')
@section('admincontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> CMS List</h4>
                        </div>
                        <div class="box-tools float-right">
                            <a href="{{ route('admin-cms-form') }}" class="btn btn-primary btn-sm">Create New CMS</a>
                        </div>
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="cms_list_table" class="table table-striped table-bordered">
                            {{ csrf_field() }}
                            <thead>
                                <th>Title</th>
                                <th>Slug URL</th>
                               {{-- <th>Meta Title</th> --}} 
                               {{--  <th>Meta Keyword</th>--}} 
                                {{--  <th>Created Date</th>--}} 
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
<script type="text/javascript" src="{{ asset('assets/admin/js/cms.js')}}"></script>
@endsection