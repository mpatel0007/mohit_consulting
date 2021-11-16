@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Popular Search')
@section('pagetitle', 'Popular Search')
@section('pagesubtitle', 'Add Popular Search')

@section('admincontent')
@include('Admin.popular_search.popular_search_modal')

      <!-- Page Content  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Popular Search</h4>
                        </div>
                        <div><button type="button" class="btn btn-primary" id="openModal">Add Popular Search</button></div>
                            <!-- Add File Modal -->
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="popularSearchDatatable" class="table table-striped table-bordered">
                            <thead>
                                <th>Popular Search Name</th>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/popular_search.js')}}"></script>
@endsection