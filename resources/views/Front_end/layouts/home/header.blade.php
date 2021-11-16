    <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar">
        <div class="container">
            <div class="theme-header clearfix">

                <div class="navbar-header">
                    <div id="preloader">
                        <div class="loader" id="loader-1"></div>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar"
                        aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        <span class="lni-menu"></span>
                        <span class="lni-menu"></span>
                        <span class="lni-menu"></span>
                    </button>
                    <a href="{{ route('front_end-home') }}" class="navbar-brand"><img src="{{ asset('assets/theme/front_end/img/logo.png') }}" alt=""></a>
                    {{-- <a href="{{ route('front_end-home') }}" class="navbar-brand"><img src="{{ asset('assets/admin/settingimage/'.$Helper::setting()->headerlogo.'') }}" alt=""></a> --}}
                </div>
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="navbar-nav mr-auto w-100 justify-content-end">
                        <li>
                            <a class="nav-link" href="{{ route('front_end-home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front_end-contact') }}">Contact</a>
                        </li>
                        @if(Auth::guard('employers')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"> Welcome {{Auth::guard('employers')->user()->companyname}}
                            </a>
                            <ul class="dropdown-menu">
                                {{-- <li><a class="dropdown-item " href="{{ route('front_end-jobs-form') }}">Add Job</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-manage-jobs-view') }}">Manage Jobs</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-manage-companyprofile-view') }}">Manage Company Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-changepassword-view') }}">Change Password</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-manage-applications-view') }}">Manage Applications</a></li> --}}
                                {{-- <li><a class="dropdown-item" href="browse-resumes.html">Browse Resumes</a></li> --}}
                            </ul>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('front_end-home') }}">Welcome {{Auth::guard('employers')->user()->companyname}}</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        <li class="button-group">
                            <a href="{{ route('front_end-jobs-form') }}" class="button btn btn-common">Post a Job</a>
                        </li>
                        @endif
                        @if(Auth::guard('candidate')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Welcome {{ucfirst(Auth::guard('candidate')->user()->name)}}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('front_end-candidate-changeprofile-view') }}">Manage Profile</a></li>
                                <!-- <li><a class="dropdown-item" href="{{ route('front_end-candidate-favourite-jobs-view') }}">Favourite Jobs</a></li> -->
                                <li><a class="dropdown-item" href="{{ route('front_end-candidate_manageprofile') }}">Applied Jobs</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-candidate-teamup-list-view') }}">Team up</a></li>
                                <!-- <li><a class="dropdown-item"  href="{{ route('front_end-candidate-team-request-view') }}">Team Request <span class="notification"> {{Helper::CountOfRequest()}}</span></a></li> -->
                                <!-- <li><a class="dropdown-item" href="{{ route('front_end-candidate-team-joined-view') }}" >Joined Team</a></li> -->
                                <!-- <li><a class="dropdown-item" href="{{ route('front_end-candidate-changeprofile-view') }}">Profile</a></li> -->
                                <li><a class="dropdown-item" href="{{ route('front_end-candidate_package') }}">Packages</a></li>
                                {{-- <li><a class="dropdown-item" href="{{ route('front_end-candidate-changepassword-view') }}">Change Password</a></li> --}}
                                {{-- ______________________________________________ --}}
                                <li><a class="dropdown-item " href="{{ route('front_end-jobs-form') }}">Add Job</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-manage-jobs-view') }}">Manage Jobs</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-manage-companyprofile-view') }}">Manage Company Profile</a></li>
                                {{-- <li><a class="dropdown-item" href="{{ route('front_end-changepassword-view') }}">Change Password</a></li> --}}
                                <li><a class="dropdown-item" href="{{ route('front_end-manage-applications-view') }}">Manage Applications</a></li>
                            </ul> 
                        </li>
                        {{-- <li>
                            <a class="nav-link" href="{{ route('front_end-home') }}">Welcome {{ucfirst(Auth::guard('candidate')->user()->name)}}</a>
                        </li> --}}
                        <li>
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form1').submit();"> {{ __('Logout') }}</a>
                            <form id="logout-form1" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                        <li class="button-group">
                            <a href="{{route('front_end-find-jobs-view')}}" class="button btn btn-common">Find Job</a>
                        </li>
                        @endif 
                        @if(!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Sign In
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('front_end-signin') }}">Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-signup') }}">Register</a></li>
                                <li><a class="dropdown-item" href="{{ route('front_end-forgot-password') }}">Forgot Password</a></li>
                            </ul>
                        </li>
                         <li class="button-group">
                            <a href="{{ route('front_end-signup') }}" class="button btn btn-common">Post a Job</a> &nbsp;
                        </li>
                        <li class="button-group">
                            <a href="{{route('front_end-find-jobs-view')}}" class="button btn btn-common">Find Job</a>
                        </li> 
                        @endif
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="mobile-menu" data-logo="{{ asset('assets/theme/front_end/img/logo-mobile.png')}}"></div>
    </nav>
    

