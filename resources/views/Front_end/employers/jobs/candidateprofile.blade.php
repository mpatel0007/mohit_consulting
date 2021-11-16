@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Candidate Details')
@section('pageheader', 'Candidate Details')
@section('content')


<div class="section">
    @include('Front_end.candidate.ManageProfile.team_request_modal')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-8 col-xs-12">
                <div class="inner-box my-resume">
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{!! \Session::get('error') !!}</li>
                            </ul>
                        </div>
                    @endif
                    <div class="author-resume">
                        <div class="thumb">
                            @if(isset($query->profileimg))
                                 <img src="{{ $query->profileimg }}" width="100px"  alt="Profile Image" title="">
                            @else
                                    <img src="{{ asset('assets/front_end/images/noimage.jpg') }}" alt="no Image" class="Candidate_img" style="width:100px">
                            @endif
                        </div>

                        <div class="author-info">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3>{{isset($query->name) ? $query->name : ''}} {{ isset($query->mname) ? $query->mname : ''}} {{ isset($query->lname) ? $query->lname : ''}}</h3>
                                    <p class="sub-title">{{isset($query->functional_area) ? $query->functional_area : ''}}</p>
                                    <p><span class="address"><i class="lni-map-marker"></i>{{isset($query->city) ? $query->city : ''}}, {{isset($query->state) ? $query->state : ''}} , {{isset($query->country) ? $query->country : ''}}</p>
                                    <p></span> 
                                        <?php if(isset($query->phone)){ ?>
                                            <span><i class="lni-phone"></i> Phone : {{isset($query->phone) ? $query->phone : ''}}</span> , 
                                        <?php } ?>
                                        <?php if(isset($query->mobile)){ ?>
                                            <span><i class="ti-phone"></i> Mobile : {{isset($query->mobile) ? $query->mobile : ''}}</span>
                                        <?php } ?>
                                    </p>
                                    <p><span><i class="lni-calendar"></i>
                                        @php
                                        $oldDate = $query->dateofbirth;
                                        $newDate = date("F j, Y", strtotime($oldDate));  
                                        @endphp
                                        {{ $newDate }}</span></p>
                                </div>
                                <?php if(isset($teamUpList) && $teamUpList == 1){ ?>
                                        <div class="col-sm-4">
                                            <?php  if(count($requestStatus) > 0){ ?>
                                                             @if ($requestStatus[0]->status == 1)
                                                                    <button type="button" class="btn btn-sm btn-common my-1"  id="ConnectNow" disabled>Teamup Request Accepted</button>
                                                                @elseif ($requestStatus[0]->status == 2)
                                                                    <button type="button" class="btn btn-sm btn-warning my-1" id="ConnectNow" disabled>Teamup Requested</button>
                                                                @elseif ($requestStatus[0]->status == 0)
                                                                    <button type="button" class="btn btn-sm btn-danger my-1" id="ConnectNow" disabled>Teamup Request Deny</button>
                                                            @endif                                       
                                                   <?php }else { ?>
                                                    <button class="btn brn-sm btn-secondary ConnectNow" data-id="{{$candidate_id}}" data-teamid="{{$teamID}}">Send Teamup Request</button>    
                                                <?php } ?>
                                        </div>
                                <?php }
                                ?>
                            </div>
                            
                            {{-- <p>
                                {{isset($query->maritalstatus) ? $query->maritalstatus : ''}}
                            </p> --}}
                        </div>
                    </div>
                    {{-- <?php  // if(count($requestDescription) > 0){ ?>
                        <?php  // if(isset($team_request) && $team_request == 1){  ?>
                            <div id="showHiddenDescription" style="margin-bottom: -10px; margin-top: 5px; cursor: pointer;"><b>Click to read description!</b></div>
                            <hr>
                                <div id="descriptionDiv" style="display:none; margin-top: -22px;">
                                        <div class="about-me item">
                                            <h4><b>Description:</b></h4>
                                                <p>
                                                    {!! $requestDescription[0]->description !!}
                                                </p>
                                            <hr>
                                        </div>
                                </div>
                        <?php // } ?>
                    <?php // } ?> --}}
                    <div class="about-me item" style="margin-top: -22px;">
                        <h3>Address</h3>
                        <p>{{isset($query->streetaddress) ? $query->streetaddress : ''}}</p>
                    </div>
                  
                    <div class="work-experence item">
                        <h3>Work Experience</h3>
                        <h4>{{isset($query->functional_area) ? $query->functional_area : ''}}</h4>
                        {{-- <h5>Bannana INC.</h5> --}}
                        <h4>Experience <b>{{isset($query->experience) ? $query->experience : ''}}</b></h4>
                        <p>Current Salary : {{isset($query->salary) ? $query->salary : ''}}</p>
                        {{-- <p>Desired Salary : {{isset($query->expectedsalary) ? $query->expectedsalary : ''}} </p> --}}
                    </div>
                    <div class="work-experence item">
                        <p><h3>Skills</h3> - 
                            @if ($query->jobskill)
                                    {{$query->jobskill}}      
                                    @if ($query->id == $jobskill[0]->userprofile_id)
                                    @php
                                            $skills = array();
                                            foreach($jobskill as $skill){
                                                $skills[] = $skill->jobskill;
                                            }
                                    @endphp        
                                    @foreach ($skills as $ket => $skill)
                                        <br> - {{$skill}}
                                    @endforeach
                                    @endif    
                            @else
                                No Skill found.
                            @endif
                        </p>
                    </div>
                    <div>
                        @if($query->id != '' && $query->id != null )
                            <a href="{{ route('front_end-employer-candidate-resume-download',['c_id' => $query->id ]) }}" class="btn btn-info mt-4"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a>
                            <a href="{{ route('front_end-employer-candidate-coverletter-download',['c_id' => $query->id ]) }}" class="btn btn-info mt-4"><i class="fa fa-download" aria-hidden="true"></i> Download Cover Letter</a>
                            <a href="{{ route('front_end-employer-candidate-references-download',['c_id' => $query->id ]) }}" class="btn btn-info mt-4"><i class="fa fa-download" aria-hidden="true"></i> Download References</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/teamup.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('descriptionTeamReq', {
                customConfig: "{{ asset('assets/admin/custom_config.js') }}"
            });
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.extraAllowedContent = 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
        });
    </script>
@endsection
