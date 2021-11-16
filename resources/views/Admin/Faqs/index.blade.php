@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Faqs')
@section('pagetitle', 'Faqs')
@section('pagesubtitle', 'Faqs')
@section('admincontent')
<!-- Button trigger modal -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
                  <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Faqs</h4>
                           </div>
                           <button type="button" id="faqsmodelbutton" class="btn btn-primary" data-toggle="modal">
                            Add Faqs
                          </button>
                        </div>

                        <div class="iq-card-body">
                            
                           <div class="table-responsive">
                              <table  class="table table-striped table-bordered" id="faqs-table" >
                       <thead>
                           <tr>
                               <th>Id</th>
                               <th>Questions</th>
                               <th>Answers</th>
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
@include('Admin.Faqs.modal')
<!-- Modal -->

@endsection

@section('footersection')
<script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
<script src="{{asset('assets/admin/js/faqs.js')}}"></script>
<!-- <script type="text/javascript">
    $(document).ready(function () {
        // admin.cms.initialize();
        CKEDITOR.replace('questioneditor', { customConfig: "{{ asset('assets/custom/js/custom_config.js')}}"});
        CKEDITOR.replace('answereditor', { customConfig: "{{ asset('assets/custom/js/custom_config.js')}}"});
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraAllowedContent ﻿= 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
    });
</script> -->
@endsection