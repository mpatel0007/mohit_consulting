@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add Testimonials')
@section('pagetitle', 'Testimonials')
@section('pagesubtitle', 'Testimonials')
@section('admincontent')
<!-- Button trigger modal -->
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-12">
                  <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Testimonials</h4>
                           </div>
                           <button type="button" id="testimonialmodelbutton" class="btn btn-primary" data-toggle="modal">Add Testimonials</button>
                        </div>

                        <div class="iq-card-body">
                            
                           <div class="table-responsive">
                              <table  class="table table-striped table-bordered" id="testimonial-table" >
                       <thead>
                           <tr>
                                <th>Id</th>
                               <th>Testimonial By</th>
                               <th>Testimonial</th>
                               <th>Company and Designation</th>
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
@include('Admin.testimonials.modal')
<!-- Modal -->

@endsection

@section('footersection')
<script src="{{asset('assets/admin/js/testimonial.js')}}"></script>
@endsection