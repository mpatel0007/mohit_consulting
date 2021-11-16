<div id="loader" class=""></div> 
                         {{-- <div id="CandidateList"> --}}
                            <div class="row" id="table_data">
                                @foreach ($Candidates as $key => $Candidate)
                                    <div class="col-sm-3 ml-3" style="min-width: 345px; min-height: 295px;">
                                        <div class="post-job box" style="min-width: 340px; min-height: 290px;">
                                            <div class="card mb-3" style="max-width: 18rem;">
                                                <div class="card-header"><a href="{{ route('front_end-candidate_details_view', ['candidate_id' => $Candidate->id ,'teamID' => $teamID,'teamuplist' => 1 ]) }}">
                                                        {{ isset($Candidate->name) ? ucfirst($Candidate->name) : '' }}
                                                        {{ isset($Candidate->mname) ? ucfirst($Candidate->mname) : '' }}
                                                        {{ isset($Candidate->lname) ? ucfirst($Candidate->lname) : '' }}</a>
                                                </div>
                                                <div class="card-body">
                                                    <div>
                                                        @if (isset($Candidate->profileimg) && trim($Candidate->profileimg)!='')
                                                            <img src="{!!  $Candidate->profileimg !!}" class="Candidate_img" alt="Candidate Profile" style="width:90px">
                                                        @else
                                                            <img src="{{ asset('assets/front_end/images/noimage.jpg') }}" alt="Candidate Profile" class="Candidate_img" style="width:90px">
                                                        @endif

                                                        @if (isset($team_details))
                                                            @foreach ($team_details as $key => $team_detail)
                                                                @if ($Candidate->id == $team_detail->candidate_id)    
                                                                        @if ($team_detail->status == 1)
                                                                            <button type="button" class="btn btn-sm btn-common ml-3 ConnectNow"  id="ConnectNow" disabled>Accepted</button>
                                                                        @elseif ($team_detail->status == 2)
                                                                            <button type="button" class="btn btn-sm btn-warning ml-3 ConnectNow" id="ConnectNow" disabled>Requested</button>
                                                                        @elseif ($team_detail->status == 0)
                                                                            <button type="button" class="btn btn-sm btn-danger ml-3 ConnectNow" id="ConnectNow" disabled>Deny</button>
                                                                       @endif                                                              
                                                                @endif  
                                                            @endforeach
                                                        @endif
                                                        @if(isset($team_details))
                                                            @if(array_search($Candidate->id, array_column($team_details, 'candidate_id')) !== false)
                                                                {{-- <button type="button" class="btn btn-sm btn-common ml-3 ConnectNow" data-id='{{ $Candidate->id }}' id="ConnectNow">Connect Now</button> --}}
                                                            @else
                                                            <button type="button" class="btn btn-sm btn-common ml-3 ConnectNow" data-id='{{ $Candidate->id }}' id="ConnectNow">Connect Now</button>
                                                        @endif
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-common ml-3 ConnectNow" data-id='{{ $Candidate->id }}' id="ConnectNow">Connect Now</button>                                                            
                                                        @endif
                                                        <p> Skill : 
                                                            {{ $Candidate->jobskill }}
                                                            @if ($Candidate->jobskill == '')
                                                                No Skill Found !
                                                            @endif
                                                            @if ($Candidate->id == $jobskill[0]->userprofile_id)
                                                                @php
                                                                    $skills = [];
                                                                    foreach ($jobskill as $skill) {
                                                                        $skills[] = $skill->jobskill;
                                                                    }
                                                                @endphp
                                                                @foreach ($skills as $ket => $skill)
                                                                    / {{ $skill }}
                                                                @endforeach
                                                                
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div style="margin : 5px 0px 0px 6px ">
                                {!! $Candidates->links() !!}
                            </div>
                        {{-- </div> --}}