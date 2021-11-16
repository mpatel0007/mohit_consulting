@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Admin Setting')
@section('pagetitle', 'Campaign Management')
@section('pagesubtitle', ' Add Campaign')

@section('admincontent')
@include('Admin.Campaign_Management.Campaign_Management_modal')
      <!-- Page Content  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">
                                <i class="fa fa-cog" aria-hidden="true"></i> Campaign Management</h4>
                        </div>
                        <div><button type="button" class="btn btn-primary" id="openModal">Add Campaign Management</button></div>
                            <!-- Add File Modal -->
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="Campaign_Management_datatable" class="table table-striped table-bordered">
                            <thead>
                                <th>Campaign Name</th>
                                <th>Mail Subject</th>
                                <th>Campaign For</th>
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
<script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/campaign_management.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // admin.cms.initialize();
        CKEDITOR.replace('description', { customConfig: "{{ asset('assets/admin/custom_config.js')}}"});
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraAllowedContent ﻿= 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
    });
</script>
@endsection