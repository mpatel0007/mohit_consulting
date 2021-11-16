@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Admin Dasboard')
@section('pagetitle', 'Dasboard')
@section('pagesubtitle', 'Dasboard')
@section('subtitle', 'Info')

@section('admincontent')
    {{-- <div class="dashboard-title">
        <h1 class="title">Dashboard</h1>
    </div> --}}
    {{-- <div id="content-page" class="content-page">
        <div class="container-fluid"> --}}
           <div class="row">
              <div class="col-md-6 col-lg-3">
                 <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                    <div class="iq-card-body">
                       <div class="text-center mb-2">
                       <div class="rounded-circle iq-card-icon iq-bg-primary"><i class="ri-user-line"></i></div></div>
                       <div class="clearfix"></div>
                       <div class="text-center">
                          <h2 class="mb-0"><span class="counter">{{isset($totalUser) ? $totalUser: ''}}</span></h2>
                          <h6 class="mb-2">Users</h6>
                          <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">10%</span> Increased</p>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-md-6 col-lg-3">
                 <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                    <div class="iq-card-body">
                       <div class="text-center mb-2">
                       <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="fa fa-building"></i></div></div>
                       <div class="clearfix"></div>
                       <div class="text-center">
                          <h2 class="mb-0"><span class="counter">{{isset($totalCompanies) ? $totalCompanies : ''}}</span></h2>
                          <h6 class="mb-2">Companies</h6>
                          <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">22%</span> Increased</p>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-md-6 col-lg-3">
                 <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                    <div class="iq-card-body">
                       <div class="text-center mb-2">
                       <div class="rounded-circle iq-card-icon iq-bg-success"><i class="las la-briefcase"></i></div></div>
                       <div class="clearfix"></div>
                       <div class="text-center">
                          <h2 class="mb-0"><span class="counter">{{isset($totalJobs) ? $totalJobs : ''}}</span></h2>
                          <h6 class="mb-2">Jobs</h6>
                          <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">20%</span> Increased</p>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-md-6 col-lg-3">
                 <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                    <div class="iq-card-body p-0" style="background: url({{asset('/assets/theme/images/page-img/01.png')}}) no-repeat scroll center center; background-size: contain; min-height: 202px;">
                    </div>
                 </div>
              </div>
              
              <div class="col-lg-6">
                 <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                    <div class="iq-card-header d-flex justify-content-between">
                       <div class="iq-header-title">
                          <h4 class="card-title">Expenses </h4>
                       </div>
                       <div class="iq-card-header-toolbar d-flex align-items-center">
                          <div class="dropdown">
                             <span class="dropdown-toggle" id="dropdownMenuButton01" data-toggle="dropdown" aria-expanded="false" role="button">
                             <i class="ri-more-2-fill"></i>
                             </span>
                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton01" style="">
                                <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                                <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
                                <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="iq-card-body pl-0">
                       <div id="home-chart-1" style="height: 380px;"></div>
                    </div>
                 </div>
              </div>
              <div class="col-md-6 col-lg-3">
                 <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                       <div class="iq-header-title">
                          <h4 class="card-title">Device</h4>
                       </div>
                       <div class="iq-card-header-toolbar d-flex align-items-center">
                          <div class="dropdown">
                             <span class="dropdown-toggle" id="dropdownMenuButton02" data-toggle="dropdown" aria-expanded="false" role="button">
                             <i class="ri-more-2-fill"></i>
                             </span>
                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton02" style="">
                                <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                                <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
                                <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="iq-card-body p-0">
                       <div id="bar-chart-6" style="min-height: 304px;"></div>
                    </div>
                 </div>
              </div>
              <div class="col-md-6 col-lg-3">
                 <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                       <div class="iq-header-title">
                          <h4 class="card-title">Server History</h4>
                       </div>
                       <div class="iq-card-header-toolbar d-flex align-items-center">
                          <div class="dropdown">
                             <span class="dropdown-toggle text-primary" id="dropdownMenuButton03" data-toggle="dropdown">
                             <i class="ri-more-2-fill"></i>
                             </span>
                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton03">
                                <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                                <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                                <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
                                <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="iq-card-body">
                       <div id="home-pie-chart" style="height: 105px;"></div>
                       <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
                          <div class="student-data">
                             <h6 class="">US Data</h6>
                             <div class="">45,000</div>
                          </div>
                          <div class="student-data">
                             <h6 class="">ASIA Data</h6>
                             <div class="">60,000</div>
                          </div>
                       </div>
                    </div>
                    <div id="bar-chart-12"></div>
                 </div>
              </div>
           </div>
        {{-- </div>
    </div> --}}
@endsection