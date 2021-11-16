@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add Major Subject')
@section('pagetitle', 'Major Subject')
@section('pagesubtitle', 'Major Subject')
@section('admincontent')
<!-- Button trigger modal -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
                  <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Major Subject</h4>
                           </div>
                           <button type="button" id="majorsubjectmodelbutton" class="btn btn-primary" data-toggle="modal">Add Major Subject</button>
                        </div>

                        <div class="iq-card-body">
                            
                           <div class="table-responsive">
                              <table  class="table table-striped table-bordered" id="major_subject-table" >
                       <thead>
                           <tr>
                                <th>Id</th>
                               <th>Major Subject</th>
                               <th>Status</th>
                               <th>Action</th>

                       
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
@include('Admin.major_subject.modal')
<!-- Modal -->

@endsection

@section('footersection')
<script src="{{asset('assets/admin/js/major_subject.js')}}"></script>
@endsection