@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Post New Job')
@section('pageheader', 'Post New Job')
@section('content')
@section('headersection')
{{-- <script src="/Layouts/en-us/js/jquery-ui.min.js"></script> --}}
@endsection
{{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<!------ Include the above in your HEAD tag ---------->

<div id="content">
    <div class="container">
        <div class="row">
            @include('Front_end.candidate.ManageProfile.left_menu')
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="job-alerts-item">
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul></ul>
                    </div>
                    {{-- <h3 class="job-title">Post New Job</h3> --}}
                    {{-- <nav> 
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link alltabs active" id="nav-home-tab" data-toggle="tab"  role="tab" aria-controls="nav-home" aria-selected="true">Job Details</a>
                            <a class="nav-item nav-link alltabs" id="nav-profile-tab" data-toggle="tab"  role="tab" aria-controls="nav-profile" aria-selected="false">Location</a>
                            <a class="nav-item nav-link alltabs" id="nav-contact-tab" data-toggle="tab"  role="tab" aria-controls="nav-contact" aria-selected="false">Salary Details</a>
                            <a class="nav-item nav-link alltabs" id="nav-about-tab" data-toggle="tab"  role="tab" aria-controls="nav-about" aria-selected="false">Job Type</a>
                            <a class="nav-item nav-link alltabs" id="nav-other-tab" data-toggle="tab"  role="tab" aria-controls="nav-other" aria-selected="false">Other</a>
                        </div>
                    </nav> --}}
                    <nav> 
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="testing nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Job Details</a>
                            <a class="testing nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Location</a>
                            <a class="testing nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Salary Details</a>
                            <a class="testing nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Job Type</a>
                            <a class="testing nav-item nav-link" id="nav-other-tab" data-toggle="tab" href="#nav-other" role="tab" aria-controls="nav-other" aria-selected="false">Other</a>
                        </div>
                    </nav>
                    <form class="form-ad"  id="postJobsform">
                    <div class="tab-content tab-validate py-3 px-3 px-sm-0" id="nav-tabContent">
                            {{ csrf_field() }}
                            <input type="hidden" id="hid" name="hid" value="{{isset($Jobs_edit_data->id) ? $Jobs_edit_data->id : ''}}">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="jobtitle">Job Title :</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="Jobs_edit_data" name="jobtitle"
                                                value="{{isset($Jobs_edit_data->jobtitle) ? $Jobs_edit_data->jobtitle : ''}}" 
                                                    placeholder="Enter Job Title">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="jobdescription"> Job description</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <textarea id="jobdescription" class="form-control" required class="editor"
                                                    name="jobdescription" rows="10" cols="80">{{isset($Jobs_edit_data->jobdescription) ? $Jobs_edit_data->jobdescription : ''}}
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="field_wrapper">
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label for="jobskill">Skill :</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="jobskill" name="jobskill" required>
                                                        <option value="" selected="">Select Job skill</option>
                                                        <?php if(!empty($jobskill)) { ?> 
                                                        @foreach($jobskill as $jobskill)
                                                        <option class="custom-select" value='{{$jobskill->id}}' <?php if(isset($Jobs_edit_data->jobskill_id)){ if($Jobs_edit_data->jobskill_id == $jobskill->id){echo 'selected';}} ?> >{{$jobskill->jobskill}}</option>
                                                        @endforeach
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="career" name="career" required>
                                                        <option value="" selected="">Select Career Level</option>
                                                    <?php if(!empty($career)) { ?> 
                                                    @foreach($career as $careers)
                                                        <option class="custom-select" value='{{$careers->id}}' <?php if(isset($Jobs_edit_data->careerlevel)){ if($Jobs_edit_data->careerlevel == $careers->id){echo 'selected';}} ?> >{{$careers->careerlevel}}</option>
                                                        @endforeach
                                                    <?php } ?> 
                                                    </select>
                                                </div>
                                                {{-- <button class="add_button btn" id="add_button" title="Add field"><i class="fa fa-plus fa-2x mt-2" aria-hidden="true"></i></button> --}}
                                                <div id="add_row" class="thumbs" style="cursor: pointer;" onclick="add_skill_level()"><i class="fa fa-plus fa-2x mt-2" id='add_button' aria-hidden="true"></i></div>
                                            </div>
                                        </div> 
                                        <div class="field_wrapper">
                                            <?php $id = 1; ?>
                                            <div class="form-group row" >
                                                <div class="col-sm-2">
                                                    <label for="jobskill"> </label>
                                                </div>
                                                <?php $id++;?>
                                                <div class="col-sm-4 add_skill">
                                                        @if(isset($Fillskill_id))
                                                            @foreach($Fillskill_id as $Fillskill)
                                                                <select class="form-control" name="skill[]" id="skill{{$id}}">
                                                                    <?php if(!empty($get_jobskill)) { ?>
                                                                    @foreach($get_jobskill as $get_skill)
                                                                        <option value="{{$get_skill->id}}" <?php  echo (isset($Fillskill_id) && $get_skill->id == $Fillskill) ? 'selected="selected"' : "" ?> >{{$get_skill->jobskill}}</option>
                                                                    @endforeach
                                                                    <?php } ?>
                                                                </select>
                                                            @endforeach
                                                        @endif 
                                                </div>
                                                <div class="col-sm-4 add_career_level">
                                                    @if(isset($Filllevel_id))
                                                    @foreach($Filllevel_id as $level_id) 
                                                        <select class="form-control" name="level[]" id="level{{$id}}">
                                                                <?php if(!empty($career)) { ?>
                                                                @foreach($career as $careerlevel)
                                                                    <option value="{{$careerlevel->id}}" <?php   echo (isset($Filllevel_id) && $careerlevel->id == $level_id ) ? 'selected="selected"' : "" ?>>{{$careerlevel->careerlevel}}</option>
                                                                @endforeach
                                                                <?php } ?>
                                                        </select>
                                                @endforeach
                                                @endif  
                                                </div>
                                                <div class="col-sm-2 add_icon">
                                                    @if(isset($count))
                                                        @for($m=1; $m<=$count; $m++)
                                                            <div id="row{{$id}}" class="thumbs" style="cursor: pointer;" onclick="edit_remove_button({{$id}})"><i class="fa fa-minus-square fa-2x mt-2" id='{{$id}}' aria-hidden="true"></i></div>
                                                        @endfor
                                                    @endisset
                                                </div>
                                        </div>
                                    <button type="button" id="next_1" class="btn removefocus btn-common">Next</button>
                                    <?php
                                    if(isset($Jobs_edit_data)) {
                                    ?>
                                        <button type="button" id="postJobs" name="postJobs" class="btn removefocus btn-common postJobs">Submit</button>
                                        <button type="button" class="btn btn-secondary">Cancel</button>
                                    <?php
                                        }
                                    ?>
                                </div>                 
                    </div>   
                                {{-- _______________________________________________________ --}}
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label for="country">Country :</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="country" name="country" required>
                                                        <option value="" selected="" >Select Country</option>
                                                        @foreach($country as $country)
                                                        <option class="custom-select" value='{{$country->id}}' <?php if(isset($Jobs_edit_data->country_id)){ if($Jobs_edit_data->country_id == $country->id){echo 'selected';}} ?> >{{$country->country_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label for="state">State :</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="state" name="state" required>
                                                    <option value="" selected="">Select Country First</option>
                                                    @if(isset($state))
                                                        @foreach($state as $state)
                                                        <option value="{{$state->id}}" <?php if(isset($Jobs_edit_data->state_id)){ if($Jobs_edit_data->state_id == $state->id){echo 'selected';}}?>> {{$state->state_name}}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label for="city">City :</label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <select class="form-control" id="city" name="city[]" multiple required data-placeholder="Select state">
                                                        @if(isset($city))
                                                            @foreach($city as $city)
                                                                    <option value="{{$city->id}}" <?php echo (isset($Fillcity_id) && in_array($city->id, $Fillcity_id) ) ? 'selected="selected"' : ""   ?>> {{$city->city_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        <button type="button" id="next_2" class="btn  removefocus btn-common">Next</button>
                                        <?php
                                            if(isset($Jobs_edit_data)) {
                                            ?>
                                                <button type="button" id="postJobs" name="postJobs" class="btn removefocus btn-common postJobs">Submit</button>
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            <?php
                                                }
                                        ?>
                                    </div>
                                {{-- _______________________________________________________ --}}
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="salaryfrom">Salary Range :</label>
                                            </div>
                                            <div class="col-sm-4">
                                                {{-- <input type="text" class="form-control" id="Jobs_edit_data" name="salaryfrom"  placeholder="Enter Salary From" value="{{isset($Jobs_edit_data->salaryfrom) ? $Jobs_edit_data->salaryfrom : ''}}" > --}}
                                                <select class="form-control" id="salaryfrom" name="salaryfrom" required>
                                                    <option value="" selected="" > Select Salary From </option>
                                                    @foreach($salaries as $salaryfrom)
                                                        <option class="custom-select" value='{{$salaryfrom->id}}' <?php if(isset($Jobs_edit_data->salaryfrom)){ if($Jobs_edit_data->salaryfrom == $salaryfrom->id){echo 'selected';}} ?> >{{$salaryfrom->salary}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                {{-- <input type="text" class="form-control" id="Jobs_edit_data" name="salaryto"  placeholder="Enter Salary To" value="{{isset($Jobs_edit_data->salaryto) ? $Jobs_edit_data->salaryto : ''}}" > --}}
                                                <select class="form-control" id="salaryto" name="salaryto" required>
                                                    <option value="" selected="" > Select Salary To </option>
                                                    @foreach($salaries as $salaryto)
                                                        <option class="custom-select" value='{{$salaryto->id}}' <?php if(isset($Jobs_edit_data->salaryto)){ if($Jobs_edit_data->salaryto == $salaryto->id){echo 'selected';}} ?> >{{$salaryto->salary}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="salaryperiod">Salary Period :</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="salaryperiod" name="salaryperiod" >
                                                    <option value=" " selected="">Select Salary Period</option>
                                                    <option value="weekly" <?php if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'weekly'){echo 'selected';}} ?>>Weekly</option>
                                                    <option value="monthly" <?php if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'monthly'){echo 'selected';}} ?>>Monthly</option>
                                                    <option value="yearly" <?php if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'yearly'){echo 'selected';}} ?>>Yearly</option>
                                                </select>
                                            
                                            </div>
                                        </div>
                                    <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="hidesalary">Hide Salary:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="hidesalary" name="hidesalary" required >
                                                    <option value=" " selected="" >Select Hide Salary</option>
                                                    <option value="yes" <?php if(isset($Jobs_edit_data->hidesalary)){ if($Jobs_edit_data->hidesalary == 'yes'){echo 'selected';}} ?>>Yes</option>
                                                    <option value="no" <?php if(isset($Jobs_edit_data->hidesalary)){ if($Jobs_edit_data->hidesalary == 'no'){echo 'selected';}} ?>>No</option>
                                                </select>
                                            
                                            </div>
                                    </div>
                                    <button type="button" id="next_3" class="btn  removefocus btn-common">Next</button>   
                                    <?php
                                            if(isset($Jobs_edit_data)) {
                                            ?>
                                                <button type="button" id="postJobs" name="postJobs" class="btn removefocus btn-common postJobs">Submit</button>
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            <?php
                                                }
                                    ?>
                                </div>
                                {{-- _______________________________________________________ --}}
                                <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="Category ">Category :</label>
                                            </div>
                                        <div class="col-sm-10">
                                                <select class="form-control" id="industry" name="industry" required>
                                                    <option value="">Category</option>
                                                    @foreach($industry as $industry)
                                                        <option class="custom-select" value={{$industry->id }} <?php if(isset($Jobs_edit_data->industry_id)){ if($Jobs_edit_data->industry_id == $industry->id){echo 'selected';}} ?>>{{$industry->industry_name}}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="Sub Category">Sub Category :</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="subCategory" name="subCategory[]" multiple required data-placeholder="Sub Category">
                                                @if(isset($Jobfunctionalarea_id))
                                                    @foreach($subCategories as $subCategory)
                                                        <option class="custom-select" value={{$subCategory->id }}  <?php  echo (isset($Jobfunctionalarea_id) && in_array($subCategory->id, $Jobfunctionalarea_id) ) ? 'selected="selected"' : ""?>>{{$subCategory->functional_area}}</option>
                                                    @endforeach 
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="jobtype">Job Type :</label>
                                            </div>
                                            <div class="col-sm-10">

                                                <select class="form-control" id="jobtype" name="jobtype[]" multiple required data-placeholder="Job type">
                                                    <option value="contract" <?php echo (isset($jobTypes) && in_array('contract', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Contract</option>
                                                    <option value="freelance" <?php echo (isset($jobTypes) && in_array('freelance', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Freelance</option>
                                                    <option value="fulltime"<?php echo (isset($jobTypes) && in_array('fulltime', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Full Time/Permanent</option>
                                                    <option value="internship" <?php echo (isset($jobTypes) && in_array('internship', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Internship</option>
                                                    <option value="parttime"<?php echo (isset($jobTypes) && in_array('parttime', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Part time</option>
                                                </select>
                                            
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="jobshift">Job Shift :</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="jobshift" name="jobshift">
                                                    <option value=" " selected="" >Select Job Shift</option>
                                                    <option value="first" <?php if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'first'){echo 'selected';}} ?>>First Shift</option>
                                                    <option value="second" <?php if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'second'){echo 'selected';}} ?>>Second Shift</option>
                                                    <option value="third" <?php if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'third'){echo 'selected';}} ?>>Third Shift</option>
                                                    <option value="rotating" <?php if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'rotating'){echo 'selected';}} ?>>Rotating</option>
                                                </select>
                                            
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <label for="positions">Positions# :</label>
                                            </div>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="positions" name="positions"  required>
                                                    <option value="" selected="" >Select Positions</option>
                                                    <option value="1" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '1'){echo 'selected';}} ?>>1</option>
                                                    <option value="2" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '2'){echo 'selected';}} ?>>2 </option>
                                                    <option value="3" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '3'){echo 'selected';}}?>>3</option>
                                                    <option value="4" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '4'){echo 'selected';}}?>>4 </option>
                                                    <option value="5" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '5'){echo 'selected';}}?>>5 </option>
                                                    <option value="6" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '6'){echo 'selected';}}?>>6 </option>
                                                    <option value="7" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '7'){echo 'selected';}}?>>7 </option>
                                                    <option value="8" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '8'){echo 'selected';}}?>>8 </option>
                                                    <option value="9" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '9'){echo 'selected';}}?>>9 </option>
                                                    <option value="10" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '10'){echo 'selected';}}?>>10 </option>
                                                    <option value="11" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '11'){echo 'selected';}}?>>11 </option>
                                                    <option value="12" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '12'){echo 'selected';}}?>>12 </option>
                                                    <option value="13" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '13'){echo 'selected';}}?>>13 </option>
                                                    <option value="14" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '14'){echo 'selected';}}?>>14 </option>
                                                    <option value="15" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '15'){echo 'selected';}}?>>15 </option>
                                                    <option value="16" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '16'){echo 'selected';}}?>>16 </option>
                                                    <option value="17" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '17'){echo 'selected';}}?>>17 </option>
                                                    <option value="18" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '18'){echo 'selected';}}?>>18 </option>
                                                    <option value="19" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '19'){echo 'selected';}}?>>19 </option>
                                                    <option value="20" <?php if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '20'){echo 'selected';}}?>>20 </option>
                                                </select>
                                            
                                            </div>
                                        </div>
                                    <button type="button" id="next_4" class="btn  removefocus btn-common">Next</button>
                                    <?php
                                        if(isset($Jobs_edit_data)) {
                                        ?>
                                            <button type="button" id="postJobs" name="postJobs" class="btn removefocus btn-common postJobs">Submit</button>
                                            <button type="button" class="btn btn-secondary">Cancel</button>
                                        <?php
                                            }
                                    ?>
                                </div>
                                {{-- _______________________________________________________ --}}
                                        <div class="tab-pane fade" id="nav-other" role="tabpanel" aria-labelledby="nav-other-tab">
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label for="jed">Job expriry date :</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <input type="date" class="form-control" id="jed" name="jed"  placeholder="Enter Job expriry date" value="{{isset($Jobs_edit_data->jobexprirydate) ? $Jobs_edit_data->jobexprirydate : ''}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label for="degreelevel">Degree Level:</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" id="degreelevel" name="degreelevel[]" multiple required data-placeholder="Select Degree Level">
                                                            @foreach($degreelevel as $degreelevel)
                                                            <option class="custom-select" value='{{$degreelevel->id}}' <?php echo (isset($Filldegreelevel_id) && in_array($degreelevel->id,$Filldegreelevel_id) ) ? 'selected="selected"' : ""  ?>>{{$degreelevel->degreelevel}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label for="experience">Experience :</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" id="experience" name="experience"  required>
                                                            <option value="" selected="" >---- Select Experience ----</option>
                                                            <option value="fresh" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == 'fresh'){echo 'selected';}} ?>>fresh</option>
                                                            <option value="Less than 1 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == 'Less than 1 Year'){echo 'selected';}} ?>>Less than 1 Year </option>
                                                            <option value="1 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '1 Year'){echo 'selected';}} ?>>1 Year</option>
                                                            <option value="2 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '2 Year'){echo 'selected';}}?>>2 Year</option>
                                                            <option value="3 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '3 Year'){echo 'selected';}}?>>3 Year</option>
                                                            <option value="4 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '4 Year'){echo 'selected';}}?>>4 Year</option>
                                                            <option value="5 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '5 Year'){echo 'selected';}}?>>5 Year</option>
                                                            <option value="6 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '6 Year'){echo 'selected';}}?>>6 Year</option>
                                                            <option value="7 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '7 Year'){echo 'selected';}}?>>7 Year</option>
                                                            <option value="8 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '8 Year'){echo 'selected';}}?>>8 Year</option>
                                                            <option value="9 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '9 Year'){echo 'selected';}}?>>9 Year</option>
                                                            <option value="More than 10 Year" <?php if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == 'More than 10 Year'){echo 'selected';}}?>>More than 10 Year</option>
                                                        </select>
                                                    
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label for="rejectReason">Application Reject reason:</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <textarea id="rejectReason" class="form-control" required class="editor"
                                                            name="rejectReason" rows="10" cols="80">
                                                            {{isset($Jobs_edit_data->reject_reason) ? $Jobs_edit_data->reject_reason : ''}}
                                                        </textarea>
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group row">
                                                    <div class="col-sm-2">
                                                        <label for="status">Status:</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" id="status" name="status" value="{{isset($Jobs_edit_data->status) ? $Jobs_edit_data->status : ''}}" required>
                                                            <option value="1" <?php //if(isset($Jobs_edit_data->status)){ if($Jobs_edit_data->status == '1'){echo 'selected';}} ?>> Active</option>
                                                            <option value="0" <?php //if(isset($Jobs_edit_data->status)){ if($Jobs_edit_data->status == '0'){echo 'selected';}}?>> Inactive</option>
                                                        </select>
                                                    
                                                    </div>
                                                </div> --}}
                                            <button type="button" id="postJobs" name="postJobs" class="btn removefocus btn-common postJobs">Submit</button>
                                            <button type="button" class="btn btn-secondary">Cancel</button>
                                    </div>
                                {{-- _______________________________________________________ --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/front_end/js/employers/jobs.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/cms.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // admin.cms.initialize();
            CKEDITOR.replace('jobdescription', {
                customConfig: "{{ asset('assets/admin/custom_config.js') }}"
            });
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.height='150px';
            CKEDITOR.config.extraAllowedContent = 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
        });

    </script>
@endsection
