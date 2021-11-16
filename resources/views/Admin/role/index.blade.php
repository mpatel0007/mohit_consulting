@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add Role')
@section('pagetitle', 'Admin Setting')
@section('pagesubtitle', 'Admin Setting')
@section('subtitle', 'Add Role')
@section('admincontent')
<!-- Button trigger modal -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
                  <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Role</h4>
                           </div>
                           <button type="button" id="rolemodelbutton" class="btn btn-primary" data-toggle="modal">
                            Add Role
                          </button>
                        </div>

                        <div class="iq-card-body">
                            
                           <div class="table-responsive">
                              <table  class="table table-striped table-bordered" id="role-table" >
                       <thead>
                           <tr>
                               <th>Id</th>
                               <th>Role</th>
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
@include('Admin.role.modal')
<!-- Modal -->

@endsection

@section('footersection')
<script src="{{asset('assets/admin/js/role.js')}}"></script>
@endsection