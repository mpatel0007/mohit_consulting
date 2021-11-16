@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Email Templates')
@section('pagetitle', 'Admin Setting')
@section('pagesubtitle', 'Admin Setting')
@section('subtitle', 'Email Templates')

@section('admincontent')
@include('Admin.email_template.email_template_modal')
      <!-- Page Content  -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">
                                <i class="fa fa-cog" aria-hidden="true"></i> Email Templates</h4>
                        </div>
                        <div><button type="button" class="btn btn-primary" id="openModal">Add Email Templates</button></div>
                            <!-- Add File Modal -->
                    </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <table id="email_template_datatable" class="table table-striped table-bordered">
                            <thead>
                                <th>Template Title</th>
                                <th>Template Subject</th>
                                {{-- <th>Template Description</th> --}}
                                <th>Edit</th>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/email_template.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // admin.cms.initialize();
        CKEDITOR.replace('description', { customConfig: "{{ asset('assets/admin/custom_config.js')}}"});
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraAllowedContent ﻿= 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
    });
</script>
@endsection