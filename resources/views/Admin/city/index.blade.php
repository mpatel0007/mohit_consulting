@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add City')
@section('pagetitle', 'Manage Location')
@section('pagesubtitle', 'Manage Location')
@section('subtitle', 'Add City')
@section('admincontent')
<!-- Button trigger modal -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
                  <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> City</h4>
                           </div>
                           <button type="button" id="citymodelbutton" class="btn btn-primary" data-toggle="modal">
                            Add City
                          </button>
                        </div>

                        <div class="iq-card-body">
                            
                           <div class="table-responsive">
                              <table  class="table table-striped table-bordered" id="city-table" >
                       <thead>
                           <tr>
                               <th>Id</th>
                               <th>state</th>
                               <th>city</th>
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
@include('Admin.city.modal')
<!-- Modal -->

@endsection

@section('footersection')
<script src="{{asset('assets/admin/js/city.js')}}"></script>
@endsection