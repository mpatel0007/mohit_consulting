@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Category')
@section('pagetitle', 'Category')
@section('pagesubtitle', 'Category')
@section('admincontent')
<!-- Button trigger modal -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
                  <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Category</h4>
                           </div>
                           <button type="button" id="industriesmodelbutton" class="btn btn-primary" data-toggle="modal">
                            Add Category
                          </button>
                        </div>
                        <div class="iq-card-body">
                           <div class="table-responsive">
                              <table  class="table table-striped table-bordered" id="industries-table" >
                       <thead>
                           <tr>
                               <th>Id</th>
                               <th>Category Name</th>
                               <th>Is Default</th>
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
@include('Admin/industries.modal')
<!-- Modal -->

@endsection

@section('footersection')
<script src="{{asset('assets/admin/js/industries.js')}}"></script>
@endsection