@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add Package')
@section('pagetitle', 'Package')
@section('pagesubtitle', 'Package')
@section('subtitle', 'list')
@section('admincontent')
<!-- Button trigger modal -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
                  <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Package</h4>
                           </div>
                           <button type="button" id="packagemodelbutton" class="btn btn-primary" data-toggle="modal">Add package</button>
                        </div>

                        <div class="iq-card-body">
                            
                           <div class="table-responsive">
                              <table  class="table table-striped table-bordered" id="package-table" >
                       <thead>
                           <tr>
                                <th>Id</th>
                               <th> Title</th>
                               <th> Price</th>
                               <th> Num Days</th>
                               <!-- <th> Num Listings</th> -->
                               <th> For</th>
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
@include('Admin.package.modal')
<!-- Modal -->

@endsection

@section('footersection')
<script src="{{asset('assets/admin/js/package.js')}}"></script>
@endsection