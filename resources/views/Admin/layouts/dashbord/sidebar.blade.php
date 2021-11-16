<?php
$routeName = Request::route()->getName();
$jobs = [
   'admin-jobs-form',
   'admin-jobs-list',
];
$cms = [
   'admin-cms-form',
   'admin-cms-list',
];
$companies=[
   'admin-companies-form',
   'admin-companies-list',
];
$employees=[
   'admin-userprofile-form',
   'admin-userprofile-list',
];
$location=[
   'country',
   'state',
   'city',
];
$adminsetting=[
   'role',
   'admin-admin',
   'setting',
];
$skill=[
   'admin-jobskill',
   'admin-careerlevel',
];

?>

<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
       <a href="{{ route('admin-dashboard') }}">
       <img src="{{asset('/assets/theme/front_end/img/faveicon.png')}}" class="img-fluid" alt="">
       <h5 class="mt-2">{{ isset(Auth::user()->name) ? Auth::user()->name : 'Admin' }}</h5>
       </a>
       <div class="iq-menu-bt align-self-center">
          <div class="wrapper-menu">
             <div class="line-menu half start"></div>
             <div class="line-menu"></div>
             <div class="line-menu half end"></div>
          </div>
       </div>
    </div>
    <div id="sidebar-scrollbar">
       <nav class="iq-sidebar-menu">
          <ul id="iq-sidebar-toggle" class="iq-menu">             
            <li class="<?php echo $routeName == 'admin-dashboard' ? 'active':'';?>" ><a href="{{ route('admin-dashboard') }}" class="iq-waves-effect"><i class="las la-home"></i><span>Dashboard</span></a></li>
            <li class="<?php echo in_array($routeName , $jobs ) ? 'active' : ''; ?>">
               <a href="#jobs" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-briefcase"></i><span>Jobs</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
               <ul id="jobs" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                  <li><a href="{{ route('admin-jobs-form') }}">Add Jobs</a></li>
                  <li><a href="{{ route('admin-jobs-list') }}">Jobs List</a></li>
               </ul>
            </li>
             {{-- <li><a href="{{ route('admin-admin') }}" class="iq-waves-effect"><i class="las la-user-tie"></i><span>Admin List</span></a></li> --}}
             <li class="<?php echo $routeName == 'industries' ? 'active':'';?>"><a href="{{ route('industries') }}" class="iq-waves-effect"><i class="las la-industry"></i><span>Category</span></a></li>
             <li class="<?php echo $routeName == 'functional_area' ? 'active':'';?>"><a href="{{ route('functional_area') }}" class="iq-waves-effect"><i class="las la-university"></i><span>Sub Category</span></a></li>
             <li class="<?php echo in_array($routeName , $cms ) ? 'active' : ''; ?>">
               <a href="#admincms" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-settings-3-line"></i><span>CMS</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
               <ul id="admincms" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                  <li><a href="{{ route('admin-cms-form') }}">Add CMS</a></li>
                  <li><a href="{{ route('admin-cms-list') }}">CMS List</a></li>
               </ul>
            </li>
            <li class="<?php echo in_array($routeName , $companies ) ? 'active' : ''; ?>">
               <a href="#Companies" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-chart-bar"></i><span>Companies</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
               <ul id="Companies" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                  <li ><a href="{{ route('admin-companies-form') }}">Add Company</a></li>
                  <li><a href="{{ route('admin-companies-list') }}">Companies List</a></li>
               </ul>
            </li>
            <li class="<?php echo in_array($routeName , $employees ) ? 'active' : ''; ?>">
               <a href="#user-info" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-user-tie"></i><span>Users</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
               <ul id="user-info" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                  <li><a href="{{ route('admin-userprofile-form') }}">Add User</a></li>
                  <li><a href="{{ route('admin-userprofile-list') }}">Users List</a></li>
               </ul>
            </li>
            <li class="<?php echo in_array($routeName , $skill ) ? 'active' : ''; ?>">
               <a href="#skill" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-user-tie"></i><span> Skills & Level</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
               <ul id="skill" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                  <li><a href="{{ route('admin-jobskill') }}">Skill</a></li>
                  <li><a href="{{ route('admin-careerlevel') }}">Level</a></li>
               </ul>
            </li>
            {{--<li><a href="{{ route('major_subject') }}" class="iq-waves-effect"><i class="las la-book"></i><span>Major Subject</span></a></li>--}}
            <li class="<?php echo $routeName == 'package' ? 'active':'';?>"><a href="{{ route('package') }}" class="iq-waves-effect"><i class="las la-money-check-alt"></i><span>Package</span></a></li>
            {{-- <li class="<?php // echo $routeName == 'admin-jobskill' ? 'active':'';?>"><a href="{{ route('admin-jobskill') }}" class="iq-waves-effect"><i class="las la-file-alt"></i><span>Job Skill</span></a></li> --}}
            <li class="<?php echo $routeName == 'admin-salary' ? 'active':'';?>"><a href="{{ route('admin-salary') }}" class="iq-waves-effect"><i class="fa fa-money" aria-hidden="true"></i><span>Salary</span></a></li>
            <li class="<?php echo $routeName == 'admin-degreelevel' ? 'active':'';?>"><a href="{{ route('admin-degreelevel') }}" class="iq-waves-effect"><i class="fa fa-graduation-cap" ></i><span>Degree Level</span></a></li>
            <li class="<?php echo $routeName == 'admin-degreetype' ? 'active':'';?>"><a href="{{ route('admin-degreetype') }}" class="iq-waves-effect"><i class="fa fa-graduation-cap" ></i><span>Degree Type</span></a></li>
            <li class="<?php echo $routeName == 'admin-contact-form' ? 'active':'';?>"><a href="{{ route('admin-contact-form') }}" class="iq-waves-effect"><i class="las la-sms"></i><span>Inquiries</span></a></li>

               <li class="<?php echo in_array($routeName , $location ) ? 'active' : ''; ?>">
                <a href="#location" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-globe"></i><span>Manage Location</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                <ul id="location" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                   <li><a href="{{ route('country') }}">Add Country</a></li>
                   <li><a href="{{ route('state') }}">Add State</a></li>
                   <li><a href="{{ route('city') }}">Add City</a></li>
                </ul>
             </li>
                
             {{-- <li class="<?php // echo $routeName == 'industries' ? 'active':'';?>"><a href="{{ route('industries') }}" class="iq-waves-effect"><i class="las la-industry"></i><span>Industries</span></a></li> --}}
             <li class="<?php echo $routeName == 'faqs' ? 'active':'';?>"><a href="{{ route('faqs') }}" class="iq-waves-effect"><i class="las la-comments"></i><span>Faqs</span></a></li>
             <li class="<?php echo $routeName == 'testimonials' ? 'active':'';?>"><a href="{{ route('testimonials') }}" class="iq-waves-effect"><i class="las la-file-alt"></i><span>Testimonials</span></a></li>

             <li class="<?php echo $routeName == 'blogs' ? 'active':'';?>"><a href="{{ route('admin-blogs-list') }}" class="iq-waves-effect"><i class="fa fa-address-card"></i><span>Blogs</span></a></li>
             <li class="<?php echo $routeName == 'blogs' ? 'active':'';?>"><a href="{{ route('admin-popular-search') }}" class="iq-waves-effect"><i class="fa fa-search"></i><span>Popular Search</span></a></li>
             <li class="<?php echo in_array($routeName , $adminsetting ) ? 'active' : ''; ?>">
                <a href="#adminsetting" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-cogs" aria-hidden="true"></i><span>Admin Setting</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                <ul id="adminsetting" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                    <li><a href="{{ route('admin-admin') }}">Admin</a></li>
                    <li><a href="{{ route('role') }}">Roles</a></li>
                   <li><a href="{{ route('setting') }}">Setting</a></li>
                   <li><a href="{{ route('admin-CampaignManagement') }}">Campaign Management</a></li>
                   <li><a href="{{ route('admin-email-template') }}">Email Template</a></li>
                </ul>
             </li>      
        
          </ul>
       </nav>
       <div class="p-3"></div>
    </div>
 </div>
