@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add Sub Category')
@section('pagetitle', 'Sub Category')
@section('pagesubtitle', 'Sub Category')
@section('admincontent')
    <!-- Button trigger modal -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Sub Category</h4>
                        </div>
                        <button type="button" id="functional_areamodelbutton" class="btn btn-primary" data-toggle="modal">
                            Add Sub Category
                        </button>
                    </div>
                    <div class="iq-card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="functional_area-table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Sub Category</th>
                                        <th>Status</th>
                                        <th style="min-width: 200px">Action</th>
                                    </tr>
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

    <!-- Modal -->
    @include('Admin.functional_area.modal')
    <!-- Modal -->

@endsection

@section('footersection')
    <script src="{{ asset('assets/admin/js/functional_area.js') }}"></script>
@endsection
