<div class="col-lg-3 col-md-3 col-xs-12">
    <div class="right-sideabr">
        <h4>Manage Account<?php //echo Request()->id; ?></h4>
        <ul class="list-item">
            {{-- <li><a href="notifications.html">Notifications <span class="notinumber">2</span></a></li> --}} 
            <li><a href="{{ route('front_end-candidate-changeprofile-view') }}" class="{{Request::path() ==  'candidate/changeprofile' ? 'text-success' : ''  }}">Profile</a></li>
            <li><a href="{{ route('front_end-candidate-document-view') }}" class="{{Request::path() ==  'candidate/document' ? 'text-success' : ''  }}">My Documents</a></li>
            {{-- <li><a href="{{ route('front_end-candidate-favourite-jobs-view') }}" class="{{Request::path() ==  'candidate/favouritejobs' ? 'text-success' : ''  }}" >Favourite Jobs</a></li> --}}    
            <li><a href="{{ route('front_end-candidate_manageprofile') }}" class="{{Request::path() ==  'candidate/manageprofile' ? 'text-success' : ''  }}">Applied Jobs</a></li>
            <li><a href="{{ route('front_end-candidate_package') }}" class="{{Request::path() ==  'candidate/packages' || Route::is('front-end-candidate_payment') ? 'text-success' : ''  }}">Packages</a></li>
            <li><a href="{{ route('front_end-candidate-teamup-list-view') }}" class="{{Request::path() ==  'candidate/teamup/view' ? 'text-success' : ''  }}">Team up</a></li>
            {{-- <li><a href="{{ route('front_end-candidate-team-request-view') }}" class="{{Request::path() ==  'candidate/team/request/view' ? 'text-success' : ''  }}">Team Request <span class="notinumber">{{Helper::CountOfRequest()}}</span></a></li>
            <li><a href="{{ route('front_end-candidate-team-joined-view') }}" class="{{Request::path() ==  'candidate/team/joined' ? 'text-success' : ''  }}">Joined Team</a></li> --}}
            {{-- ______________________________________________________________________________ --}}
            {{-- <li><a href="{{ route('front_end-jobs-form') }}" class="{{Request::path() ==  'postjobs' ? 'text-success' : ''  }}">Post Job</a></li> --}}
            <li><a href="{{ route('front_end-manage-companyprofile-view') }}" class="{{ Request::path() ==  'employers/companyprofile' ? 'text-success' : ''  }}">Manage Company Profile</a></li>
            <li><a href="{{ route('front_end-manage-jobs-view') }}" class="{{ Request::path() ==  'manage/job' ? 'text-success' : ''  }}">Manage Jobs</a></li>
            <li><a href="{{ route('front_end-manage-applications-view') }}" class="{{ Request::path() ==  'employers/manage/applications' ? 'text-success' : ''  }}">Manage Applications</a></li>
            <li><a href="{{ route('front-end-employers_payment') }}" class="{{Request::path() ==  'employers/packages' || Route::is('front-end-employer_payment') ? 'text-success' : ''  }}">Packages</a></li>
            <li><a href="{{ route('frontend-chatify') }}" class="{{Request::path() ==  'chatify' ? 'text-success' : ''  }}">Messages</a></li>  
            <li><a href="{{ route('front_end-candidate-changepassword-view') }}" class="{{Request::path() ==  'candidate/changepassword' ? 'text-success' : ''  }}">Change Password</a></li>
            {{-- <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sing Out</a> --}}

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li> 
        </ul>
    </div>
</div>