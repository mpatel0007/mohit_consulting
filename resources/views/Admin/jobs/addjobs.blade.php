@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add Jobs')
@section('pagetitle', 'Jobs')
@section('pagesubtitle', 'Jobs')
@section('subtitle', 'Add Jobs')
@section('admincontent')


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Add Jobs</h4>
                        </div>
                    </div>
                <div class="iq-card-body">
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul></ul>
                    </div>
                        <form onsubmit="return false" method="post" id="addJobsform" class="needs-validation" novalidate name="addJobsform" autocomplete="false">
                            {{ csrf_field() }}
                            <input type="hidden" id="hid" name="hid" value="{{isset($Jobs_edit_data->id) ? $Jobs_edit_data->id : ''}}">
                            <input type="hidden" id="company_edit" name="company_edit" value="">
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="company">Company :</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" id="company" name="company" required @php if(isset($Jobs_edit_data->company_id)){ echo 'disabled';} @endphp>
                                        <option value="" >---- Select Company ----</option>
                                        @foreach($Companies as $company)
                                        <option class="custom-select" value='{{$company->id}}' <?php if(isset($Jobs_edit_data->company_id)){ if($Jobs_edit_data->company_id == $company->id){echo 'selected';}} ?> >{{$company->companyname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label for="jobtitle">Job Title :</label>
                                        </div>
                                        <div class="col-sm-10">
                                           <input type="text" class="form-control" id="Jobs_edit_data" name="jobtitle"  placeholder="Enter Job Title" value="{{isset($Jobs_edit_data->jobtitle) ? $Jobs_edit_data->jobtitle : ''}}" >

                                        </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="jobdescription"> Job description</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea id="jobdescription" class="form-control" required class="editor" name="jobdescription" rows="10" cols="80" >{{isset($Jobs_edit_data->jobdescription) ? $Jobs_edit_data->jobdescription : ''}}</textarea>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="jobskill">Skill :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="jobskill" name="jobskill" required>
                                            <option value="" selected="">---- Select Job skill ----</option>
                                            @foreach($jobskill as $jobskill)
                                            <option class="custom-select" value='{{$jobskill->id}}' <?php // if(isset($Jobs_edit_data->jobskill_id)){ if($Jobs_edit_data->jobskill_id == $jobskill->id){echo 'selected';}} ?> >{{$jobskill->jobskill}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="field_wrapper">
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="jobskill">Skill :</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="jobskill" name="jobskill" required>
                                            <option value="" selected="">---- Select Job skill ----</option>
                                            @foreach($jobskill as $jobskill)
                                            <option class="custom-select" value='{{$jobskill->id}}' <?php if(isset($Jobs_edit_data->jobskill_id)){ if($Jobs_edit_data->jobskill_id == $jobskill->id){echo 'selected';}} ?> >{{$jobskill->jobskill}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="career" name="career" required>
                                            <option value="" selected="">---- Select Career Level -----</option>
                                           @foreach($career as $careers)
                                            <option class="custom-select" value='{{$careers->id}}' <?php if(isset($Jobs_edit_data->careerlevel)){ if($Jobs_edit_data->careerlevel == $careers->id){echo 'selected';}} ?> >{{$careers->careerlevel}}</option>
                                            @endforeach
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
                                                            @foreach($get_jobskill as $get_skill)
                                                                <option value="{{$get_skill->id}}" <?php  echo (isset($Fillskill_id) && $get_skill->id == $Fillskill) ? 'selected="selected"' : "" ?> >{{$get_skill->jobskill}}</option>
                                                            @endforeach
                                                         </select>
                                                    @endforeach
                                                @endif 
                                        </div>
                                        <div class="col-sm-4 add_career_level">
                                             @if(isset($Filllevel_id))
                                            @foreach($Filllevel_id as $level_id) 
                                                 <select class="form-control" name="level[]" id="level{{$id}}">
                                                        @foreach($career as $careerlevel)
                                                            <option value="{{$careerlevel->id}}" <?php   echo (isset($Filllevel_id) && $careerlevel->id == $level_id ) ? 'selected="selected"' : "" ?>>{{$careerlevel->careerlevel}}</option>
                                                        @endforeach
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
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="country">Location :</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="country" name="country" required>
                                            <option value="" selected="" >---- Select Country ----</option>
                                            @foreach($country as $country)
                                            <option class="custom-select" value='{{$country->id}}' <?php if(isset($Jobs_edit_data->country_id)){ if($Jobs_edit_data->country_id == $country->id){echo 'selected';}} ?> >{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="state" name="state" required>
                                        <option value="" selected="">----- Select Country First ------ </option>
                                        @if(isset($state))
                                            @foreach($state as $state)
                                            <option value="{{$state->id}}" <?php if(isset($Jobs_edit_data->state_id)){ if($Jobs_edit_data->state_id == $state->id){echo 'selected';}}?>> {{$state->state_name}}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="city" name="city[]" multiple required data-placeholder="  ----- Select state first -----">
                                            @if(isset($city))
                                            @foreach($city as $city)
                                            <option value="{{$city->id}}" <?php echo (isset($Fillcity_id) && in_array($city->id, $Fillcity_id) ) ? 'selected="selected"' : ""   ?>> {{$city->city_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="state">State :</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="state" name="state" required>
                                        <option value="" selected="">----- Select Country First ------ </option>
                                        @if(isset($state))
                                            @foreach($state as $state)
                                            <option value="{{$state->id}}" <?php // if(isset($Jobs_edit_data->state_id)){ if($Jobs_edit_data->state_id == $state->id){echo 'selected';}}?>> {{$state->state_name}}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="city">City :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="city" name="city[]" multiple required>
                                            @if(isset($city))
                                            @foreach($city as $city)
                                            <option value="{{$city->id}}" <?php// echo (isset($Fillcity_id) && in_array($city->id, $Fillcity_id) ) ? 'selected="selected"' : ""   ?>> {{$city->city_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group row" style="display: none;">
                                    <div class="col-sm-2">
                                        <label for="freelance">Is Freelance :</label>   
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="freelance" name="freelance" required>
                                            <option value=" " selected="" >----Select Is Freelance----</option>
                                            <option value="yes" <?php if(isset($Jobs_edit_data->is_freelance)){ if($Jobs_edit_data->is_freelance == 'yes'){echo 'selected';}} ?>>Yas</option>
                                            <option value="no" <?php if(isset($Jobs_edit_data->is_freelance)){ if($Jobs_edit_data->is_freelance == 'no'){echo 'selected';}} ?>>No</option>
                                        </select>
                                      
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="career">Career Level :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="career" name="career"  required>
                                            <option value="" selected="" >---- Select Career Level ----</option>
                                            <option value="0" <?php // if(isset($Jobs_edit_data->careerlevel)){ if($Jobs_edit_data->careerlevel == '0'){echo 'selected';}} ?>>Department Head</option>
                                            <option value="1" <?php // if(isset($Jobs_edit_data->careerlevel)){ if($Jobs_edit_data->careerlevel == '1'){echo 'selected';}} ?>>Entery Level</option>
                                            <option value="2" <?php // if(isset($Jobs_edit_data->careerlevel)){ if($Jobs_edit_data->careerlevel == '2'){echo 'selected';}} ?>>Experienced Professional</option>
                                            <option value="3" <?php // if(isset($Jobs_edit_data->careerlevel)){ if($Jobs_edit_data->careerlevel == '3'){echo 'selected';}}?>>GM / CEO / Country Head / President</option>
                                            <option value="4" <?php // if(isset($Jobs_edit_data->careerlevel)){ if($Jobs_edit_data->careerlevel == '4'){echo 'selected';}}?>> Intern / Student</option>
                                        </select>
                                    
                                    </div>
                                </div> --}}
                                
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="salaryfrom">Salary :</label>
                                    </div>
                                    <div class="col-sm-3">
                                       {{-- <input type="text" class="form-control" id="Jobs_edit_data" name="salaryfrom"  placeholder="Enter Salary From" value="{{isset($Jobs_edit_data->salaryfrom) ? $Jobs_edit_data->salaryfrom : ''}}" > --}}
                                       <select class="form-control" id="salaryfrom" name="salaryfrom" required>
                                        <option value="" selected="" > Select Salary From </option>
                                        @foreach($salaries as $salaryfrom)
                                            <option class="custom-select" value='{{$salaryfrom->id}}' <?php if(isset($Jobs_edit_data->salaryfrom)){ if($Jobs_edit_data->salaryfrom == $salaryfrom->id){echo 'selected';}} ?> >{{$salaryfrom->salary}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-sm-3">
                                        {{-- <input type="text" class="form-control" id="Jobs_edit_data" name="salaryto"  placeholder="Enter Salary To" value="{{isset($Jobs_edit_data->salaryto) ? $Jobs_edit_data->salaryto : ''}}" > --}}
                                            <select class="form-control" id="salaryto" name="salaryto" required>
                                                <option value="" selected="" > Select Salary To </option>
                                                @foreach($salaries as $salaryto)
                                                     <option class="custom-select" value='{{$salaryto->id}}' <?php if(isset($Jobs_edit_data->salaryto)){ if($Jobs_edit_data->salaryto == $salaryto->id){echo 'selected';}} ?> >{{$salaryto->salary}}</option>
                                                 @endforeach
                                            </select>
                                     </div>
                                     {{-- <div class="col-sm-2">
                                        <input type="text" class="form-control" id="yearly_job_salary" name="yearly_job_salary" autocomplete="false" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57"  placeholder="Enter Yearly Salary " value="{{isset($Jobs_edit_data->yearly_job_salary) ? $Jobs_edit_data->yearly_job_salary : ''}}" >
                                     </div> --}}
                                     <div class="col-sm-2">
                                        <select class="form-control" id="salaryperiod" name="salaryperiod" >
                                            <option value=" " selected="">Salary Period</option>
                                            <option value="weekly" <?php if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'weekly'){echo 'selected';}} ?>>Weekly</option>
                                            <option value="monthly" <?php if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'monthly'){echo 'selected';}} ?>>Monthly</option>
                                            <option value="yearly" <?php if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'yearly'){echo 'selected';}} ?>>Yearly</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" id="hidesalary" name="hidesalary" required >
                                            <option value=" " selected=""   >Hide Salary</option>
                                            <option value="yes" <?php if(isset($Jobs_edit_data->hidesalary)){ if($Jobs_edit_data->hidesalary == 'yes'){echo 'selected';}} ?>>Yes</option>
                                            <option value="no" <?php if(isset($Jobs_edit_data->hidesalary)){ if($Jobs_edit_data->hidesalary == 'no'){echo 'selected';}} ?>>No</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="salaryto">Salary To :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="Jobs_edit_data" name="salaryto"  placeholder="Enter Salary To" value="{{isset($Jobs_edit_data->salaryto) ? $Jobs_edit_data->salaryto : ''}}" >
                             
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="salaryperiod">Salary Period :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="salaryperiod" name="salaryperiod" >
                                            <option value=" " selected="">----Select Salary Period----</option>
                                            <option value="weekly" <?php //if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'weekly'){echo 'selected';}} ?>>Weekly</option>
                                            <option value="monthly" <?php //if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'monthly'){echo 'selected';}} ?>>Monthly</option>
                                            <option value="yearly" <?php //if(isset($Jobs_edit_data->salaryperiod)){ if($Jobs_edit_data->salaryperiod == 'yearly'){echo 'selected';}} ?>>Yearly</option>
                                        </select>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="hidesalary">Hide Salary :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="hidesalary" name="hidesalary" required >
                                            <option value=" " selected="" >----Select Hide Salary----</option>
                                            <option value="yes" <?php //if(isset($Jobs_edit_data->hidesalary)){ if($Jobs_edit_data->hidesalary == 'yes'){echo 'selected';}} ?>>Yes</option>
                                            <option value="no" <?php //if(isset($Jobs_edit_data->hidesalary)){ if($Jobs_edit_data->hidesalary == 'no'){echo 'selected';}} ?>>No</option>
                                        </select>
                                    
                                    </div>
                                </div> --}}
                                
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="functional">Category & Sub Category :</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control" id="industry" name="industry" required>
                                            <option value="">---- Select Category ----</option>
                                            @foreach($industry as $industry)
                                            <option class="custom-select" value={{$industry->id }} <?php if(isset($Jobs_edit_data->industry_id)){ if($Jobs_edit_data->industry_id == $industry->id){echo 'selected';}} ?>>{{$industry->industry_name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    {{-- <div class="col-sm-5">
                                        <select class="form-control" id="subCategory" name="subCategory[]" multiple required data-placeholder=" ---- Sub Category ---- ">
                                        @if(isset($subCategories))
                                            @foreach($subCategories as $subCategory)
                                                <option class="custom-select" value={{$subCategory->id }}  <?php  //echo (isset($Jobfunctionalarea_id) && in_array($subCategory->id, $Jobfunctionalarea_id) ) ? 'selected="selected"' : ""?>>{{$subCategory->functional_area}}</option>
                                            @endforeach 
                                        @endif
                                        </select>
                                    </div> --}}
                                    <div class="col-sm-5">
                                        <select class="form-control" id="subCategory" name="subCategory[]" multiple required data-placeholder=" ---- Sub Category ---- ">
                                        @if(!empty($subCategories))
                                       
                                            @foreach($subCategories as $subCategory)
                                                <option class="custom-select" value={{$subCategory->id }}  <?php  echo (isset($Jobfunctionalarea_id) && in_array($subCategory->id, $Jobfunctionalarea_id) ) ? 'selected="selected"' : ""?>>{{$subCategory->functional_area}}</option>
                                            @endforeach 
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="jobtype">Job Type & Job Shift </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="jobtype" name="jobtype[]" required multiple data-placeholder=" -----Select Job type-----">
                                            <option value=""></option>
                                            <option value="contract" <?php echo (isset($jobTypes) && in_array('contract', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Contract</option>
                                            <option value="freelance" <?php echo (isset($jobTypes) && in_array('freelance', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Freelance</option>
                                            <option value="fulltime"<?php echo (isset($jobTypes) && in_array('fulltime', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Full Time/Permanent</option>
                                            <option value="internship" <?php echo (isset($jobTypes) && in_array('internship', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Internship</option>
                                            <option value="parttime"<?php echo (isset($jobTypes) && in_array('parttime', $jobTypes) ) ? 'selected="selected"' : ""  ?>>Part time</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="jobshift" name="jobshift">
                                            <option value=" " selected="" >---- Select Job Shift ----</option>
                                            <option value="first" <?php if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'first'){echo 'selected';}} ?>>First Shift</option>
                                            <option value="second" <?php if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'second'){echo 'selected';}} ?>>Second Shift</option>
                                            <option value="third" <?php if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'third'){echo 'selected';}} ?>>Third Shift</option>
                                            <option value="rotating" <?php if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'rotating'){echo 'selected';}} ?>>Rotating</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="positions" name="positions"  required>
                                            <option value="" selected="" >---- Select Positions# ----</option>
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
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="jobshift">Job Shift :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="jobshift" name="jobshift">
                                            <option value=" " selected="" >----Select Job Shift----</option>
                                            <option value="first" <?php //if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'first'){echo 'selected';}} ?>>First Shift</option>
                                            <option value="second" <?php //if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'second'){echo 'selected';}} ?>>Second Shift</option>
                                            <option value="third" <?php //if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'third'){echo 'selected';}} ?>>Third Shift</option>
                                            <option value="rotating" <?php //if(isset($Jobs_edit_data->jobshift)){ if($Jobs_edit_data->jobshift == 'rotating'){echo 'selected';}} ?>>Rotating</option>
                                        </select>
                                      
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="positions">Positions# :</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="positions" name="positions"  required>
                                            <option value="" selected="" >---- Select Positions# ----</option>
                                            <option value="1" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '1'){echo 'selected';}} ?>>1</option>
                                            <option value="2" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '2'){echo 'selected';}} ?>>2 </option>
                                            <option value="3" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '3'){echo 'selected';}}?>>3</option>
                                            <option value="4" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '4'){echo 'selected';}}?>>4 </option>
                                            <option value="5" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '5'){echo 'selected';}}?>>5 </option>
                                            <option value="6" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '6'){echo 'selected';}}?>>6 </option>
                                            <option value="7" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '7'){echo 'selected';}}?>>7 </option>
                                            <option value="8" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '8'){echo 'selected';}}?>>8 </option>
                                            <option value="9" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '9'){echo 'selected';}}?>>9 </option>
                                            <option value="10" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '10'){echo 'selected';}}?>>10 </option>
                                            <option value="11" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '11'){echo 'selected';}}?>>11 </option>
                                            <option value="12" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '12'){echo 'selected';}}?>>12 </option>
                                            <option value="13" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '13'){echo 'selected';}}?>>13 </option>
                                            <option value="14" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '14'){echo 'selected';}}?>>14 </option>
                                            <option value="15" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '15'){echo 'selected';}}?>>15 </option>
                                            <option value="16" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '16'){echo 'selected';}}?>>16 </option>
                                            <option value="17" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '17'){echo 'selected';}}?>>17 </option>
                                            <option value="18" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '18'){echo 'selected';}}?>>18 </option>
                                            <option value="19" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '19'){echo 'selected';}}?>>19 </option>
                                            <option value="20" <?php //if(isset($Jobs_edit_data->positions)){ if($Jobs_edit_data->positions == '20'){echo 'selected';}}?>>20 </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="gender" name="gender"  required>
                                            <option value="" selected="" >---- Select Gender ----</option>
                                            <option value="1" <?php //if(isset($Jobs_edit_data->gender)){ if($Jobs_edit_data->gender == '1'){echo 'selected';}} ?>>Male</option>
                                            <option value="2" <?php //if(isset($Jobs_edit_data->gender)){ if($Jobs_edit_data->gender == '2'){echo 'selected';}}?>>Female</option>
                                            <option value="3" <?php //if(isset($Jobs_edit_data->gender)){ if($Jobs_edit_data->gender == '3'){echo 'selected';}}?>> Other</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="gender">Gender:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="gender" name="gender[]" multiple required data-placeholder=" ---- Select Gender ----">
                                            <option value="1" <?php echo (isset($Fillgender) && in_array(1, $Fillgender) ) ? 'selected="selected"' : ""  ?>>Male</option>
                                            <option value="2" <?php echo (isset($Fillgender) && in_array(2, $Fillgender) ) ? 'selected="selected"' : ""  ?>>Female</option>
                                            <option value="3" <?php echo (isset($Fillgender) && in_array(3, $Fillgender) ) ? 'selected="selected"' : ""  ?>> Other</option>
                                        </select>
                                    </div>
                                </div>
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
                                        <label for="degreelevel">Degree Level & Experience:</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control" id="degreelevel" name="degreelevel[]" multiple required data-placeholder="  ---- Select Degree Level ----">
                                            {{-- <option value="" selected="" >----Select Degree Level----</option> --}}
                                            @foreach($degreelevel as $degreelevel)
                                            <option class="custom-select" value='{{$degreelevel->id}}' <?php echo (isset($Filldegreelevel_id) && in_array($degreelevel->id,$Filldegreelevel_id) ) ? 'selected="selected"' : ""  ?>>{{$degreelevel->degreelevel}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
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
                                
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="experience">Experience :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="experience" name="experience"  required>
                                            <option value="" selected="" >---- Select Experience ----</option>
                                            <option value="0" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '0'){echo 'selected';}} ?>>fresh</option>
                                            <option value="1" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '1'){echo 'selected';}} ?>>Less than 1 Year </option>
                                            <option value="2" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '2'){echo 'selected';}} ?>>1 Year</option>
                                            <option value="3" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '3'){echo 'selected';}}?>>2 Year</option>
                                            <option value="4" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '4'){echo 'selected';}}?>>3 Year</option>
                                            <option value="5" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '5'){echo 'selected';}}?>>4 Year</option>
                                            <option value="6" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '6'){echo 'selected';}}?>>5 Year</option>
                                            <option value="7" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '7'){echo 'selected';}}?>>6 Year</option>
                                            <option value="8" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '8'){echo 'selected';}}?>>7 Year</option>
                                            <option value="9" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '9'){echo 'selected';}}?>>8 Year</option>
                                            <option value="10" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '10'){echo 'selected';}}?>>9 Year</option>
                                            <option value="11" <?php //if(isset($Jobs_edit_data->experience)){ if($Jobs_edit_data->experience == '11'){echo 'selected';}}?>>More than 10 Year</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="rejectReason">Application Reject reason:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea id="rejectReason" class="form-control" required class="editor"
                                            name="rejectReason" rows="4" cols="50">
                                            {{isset($Jobs_edit_data->reject_reason) ? $Jobs_edit_data->reject_reason : ''}}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="status">Status:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="status" name="status" value="{{isset($Jobs_edit_data->status) ? $Jobs_edit_data->status : ''}}" required>
                                            <option value="1" <?php if(isset($Jobs_edit_data->status)){ if($Jobs_edit_data->status == '1'){echo 'selected';}} ?>> Active</option>
                                            <option value="0" <?php if(isset($Jobs_edit_data->status)){ if($Jobs_edit_data->status == '0'){echo 'selected';}}?>> Inactive</option>
                                        </select>
                                       
                                    </div>
                                </div>
                                <button type="submit" id="addJobs" name="addJobs" class="btn btn-primary">Submit</button>
                                <button type="submit" class="btn btn-secondary">Cancle</button>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/admin/js/jobs.js')}}"></script>
<script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/cms.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // admin.cms.initialize();
        CKEDITOR.replace('jobdescription', { customConfig: "{{ asset('assets/admin/custom_config.js')}}"});
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraAllowedContent ﻿= 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
    });
</script>
@endsection
