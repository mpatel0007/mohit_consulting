@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add User')
@section('pagetitle', 'User Profile')
@section('pagesubtitle', 'Users')
@section('subtitle', 'Add User')

@section('headersection')
<link rel="stylesheet" href="{{ asset('assets/img_cropper_css.css') }}">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.3/cropper.css'>
@endsection

@section('admincontent')
@include('Admin.userprofile.img_copper_modal')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Add User</h4>
                        </div>
                    </div>
                <div class="iq-card-body">
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul></ul>
                    </div>
                        <form onsubmit="return false" method="post" id="addUserprofileform" class="needs-validation" novalidate name="addUserprofileform" autocomplete="false">
                            {{ csrf_field() }}
                            <input type="hidden" id="croppedImageDataURL" name="croppedImageDataURL" value=" ">
                            <input type="hidden" id="hid" name="hid" value="{{isset($Userprofile_edit_data->id) ? $Userprofile_edit_data->id : ''}}">
                            <div class="float-right">
                                <label for="file-input">
                                    @if (isset($Userprofile_edit_data->profileimg))
                                        <img src="{{$Userprofile_edit_data->profileimg }}" width="100px" id="edit_img" alt="" title="">
                                    @else
                                    <img src="{{ asset('assets/front_end/images/noimage.jpg') }}"  style="cursor: pointer;" id="img_choose" class="float-right">                                                
                                    @endif
                                </label>
                                <input id="file-input" type="file" name="profileimg" accept="image/*"/>
                                {{-- <div id="result" class="result" ></div> --}}
                            </div>
                                <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label for="fname" style="margin-left: -15px;">Name :</label>
                                        </div>
                                        <div class="col-sm-4">
                                           <input type="text" class="form-control" id="Userprofile_edit_data" name="fname"  placeholder="Enter First Name" value="{{isset($Userprofile_edit_data->name) ? $Userprofile_edit_data->name : ''}}" required>    
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="mname" name="mname"  placeholder="Enter Middle Name" value="{{isset($Userprofile_edit_data->mname) ? $Userprofile_edit_data->mname : ''}}" >
                                         </div>
                                         <div class="col-sm-3">
                                            <input type="text" class="form-control" id="lname" name="lname"  placeholder="Enter Last Name" value="{{isset($Userprofile_edit_data->lname) ? $Userprofile_edit_data->lname : ''}}" required>
                                         </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="mname">Middle Name :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="mname" name="mname"  placeholder="Enter Middle Name" value="{{isset($Userprofile_edit_data->mname) ? $Userprofile_edit_data->mname : ''}}" >
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="lname">Last Name :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="lname" name="lname"  placeholder="Enter Last Name" value="{{isset($Userprofile_edit_data->lname) ? $Userprofile_edit_data->lname : ''}}" required>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="email" style="margin-left: -15px;">Email :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="email" class="form-control" id="email" name="email"  placeholder="Enter Email" value="{{isset($Userprofile_edit_data->email) ? $Userprofile_edit_data->email : ''}}" required>
                                    
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label>Password :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" value="">
                                      
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="fathername">Father Name :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="fathername" name="fathername"  placeholder="Enter Father Name" value="{{isset($Userprofile_edit_data->fathername) ? $Userprofile_edit_data->fathername : ''}}" >
                                  
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="dob">Date of Birth & Gender & Marital :</label>
                                    </div>
                                    <div class="col-sm-4">
                                       <input type="date" class="form-control" id="dob" name="dob"  placeholder="Enter Date of Birth" value="{{isset($Userprofile_edit_data->dateofbirth) ? $Userprofile_edit_data->dateofbirth : ''}}" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="gender" name="gender"  required>
                                            <option value="">---- Select Gender ----</option>
                                            <option value="1" <?php if(isset($Userprofile_edit_data->gender)){ if($Userprofile_edit_data->gender == '1'){echo 'selected';}} ?>>Male</option>
                                            <option value="2" <?php if(isset($Userprofile_edit_data->gender)){ if($Userprofile_edit_data->gender == '2'){echo 'selected';}}?>>Female</option>
                                            <option value="3" <?php if(isset($Userprofile_edit_data->gender)){ if($Userprofile_edit_data->gender == '3'){echo 'selected';}}?>> Other</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="marital" name="marital" >
                                            <option value="">---- Select marital ----</option>
                                            <option value="1" <?php if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '1'){echo 'selected';}} ?>>Divorced</option>
                                            <option value="2" <?php if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '2'){echo 'selected';}}?>>Married</option>
                                            <option value="3" <?php if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '3'){echo 'selected';}}?>>Separated</option>
                                            <option value="4" <?php if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '4'){echo 'selected';}}?>>Single</option>
                                            <option value="5" <?php if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '5'){echo 'selected';}}?>>Widow/er</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="gender">Gender:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="gender" name="gender"  required>
                                            <option value="">---- Select Gender ----</option>
                                            <option value="1" <?php //if(isset($Userprofile_edit_data->gender)){ if($Userprofile_edit_data->gender == '1'){echo 'selected';}} ?>>Male</option>
                                            <option value="2" <?php //if(isset($Userprofile_edit_data->gender)){ if($Userprofile_edit_data->gender == '2'){echo 'selected';}}?>>Female</option>
                                            <option value="3" <?php //if(isset($Userprofile_edit_data->gender)){ if($Userprofile_edit_data->gender == '3'){echo 'selected';}}?>> Other</option>
                                        </select> 
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="marital">Marital Status:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="marital" name="marital" >
                                            <option value="">---- Select marital ----</option>
                                            <option value="1" <?php //if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '1'){echo 'selected';}} ?>>Divorced</option>
                                            <option value="2" <?php //if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '2'){echo 'selected';}}?>>Married</option>
                                            <option value="3" <?php //if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '3'){echo 'selected';}}?>>Separated</option>
                                            <option value="4" <?php //if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '4'){echo 'selected';}}?>>Single</option>
                                            <option value="5" <?php //if(isset($Userprofile_edit_data->maritalstatus)){ if($Userprofile_edit_data->maritalstatus == '5'){echo 'selected';}}?>>Widow/er</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="country">Location :</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="country" name="country" required>
                                            <option value="">---- Select Country ----</option>
                                            @foreach($country as $country)
                                            <option class="custom-select" value='{{$country->id}}' <?php if(isset($Userprofile_edit_data->country_id)){ if($Userprofile_edit_data->country_id == $country->id){echo 'selected';}} ?> >{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="state" name="state" required>
                                        <option value="">----- Select Country First ------ </option>
                                        @if(isset($state))
                                            @foreach($state as $state)
                                            <option value="{{$state->id}}" <?php if(isset($Userprofile_edit_data->state_id)){ if($Userprofile_edit_data->state_id == $state->id){echo 'selected';}}?>> {{$state->state_name}}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="city" name="city" required>
                                            <option value="">----- Select State First ------ </option>
                                            @if(isset($city))
                                                @foreach($city as $city)
                                                <option value="{{$city->id}}" <?php if(isset($Userprofile_edit_data->city_id)){ if($Userprofile_edit_data->city_id == $city->id){echo 'selected';}}?>> {{$city->city_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="state">State :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="state" name="state" required>
                                        <option value="">----- Select Country First ------ </option>
                                        @if(isset($state))
                                            @foreach($state as $state)
                                            <option value="{{$state->id}}" <?php //if(isset($Userprofile_edit_data->state_id)){ if($Userprofile_edit_data->state_id == $state->id){echo 'selected';}}?>> {{$state->state_name}}</option>
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
                                        <select class="form-control" id="city" name="city" required>
                                            <option value="">----- Select State First ------ </option>
                                            @if(isset($city))
                                                @foreach($city as $city)
                                                <option value="{{$city->id}}" <?php //if(isset($Userprofile_edit_data->city_id)){ if($Userprofile_edit_data->city_id == $city->id){echo 'selected';}}?>> {{$city->city_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="phone">Number :</label>
                                    </div>
                                    <div class="col-sm-5">
                                       <input type="text" class="form-control" autocomplete="false" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="phone" name="phone"  placeholder="Phone" value="{{isset($Userprofile_edit_data->phone) ? $Userprofile_edit_data->phone : ''}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" autocomplete="false" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="mobile" name="mobile"  placeholder="Mobile Number" value="{{isset($Userprofile_edit_data->mobile) ? $Userprofile_edit_data->mobile : ''}}" >
                                     </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="mobile">Mobile Number:</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" autocomplete="false" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="mobile" name="mobile"  placeholder="Mobile Number" value="{{isset($Userprofile_edit_data->mobile) ? $Userprofile_edit_data->mobile : ''}}" >
                                    </div>
                                   
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="experience">Degree Level & Experience:</label>
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
                                            <option value="">---- Select Experience ----</option>
                                            <option value="fresh" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == 'fresh'){echo 'selected';}} ?>>fresh</option>
                                            <option value="Less than 1 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == 'Less than 1 Year'){echo 'selected';}} ?>>Less than 1 Year </option>
                                            <option value="1 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '1 Year'){echo 'selected';}} ?>>1 Year</option>
                                            <option value="2 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '2 Year'){echo 'selected';}}?>>2 Year</option>
                                            <option value="3 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '3 Year'){echo 'selected';}}?>>3 Year</option>
                                            <option value="4 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '4 Year'){echo 'selected';}}?>>4 Year</option>
                                            <option value="5 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '5 Year'){echo 'selected';}}?>>5 Year</option>
                                            <option value="6 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '6 Year'){echo 'selected';}}?>>6 Year</option>
                                            <option value="7 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '7 Year'){echo 'selected';}}?>>7 Year</option>
                                            <option value="8 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '8 Year'){echo 'selected';}}?>>8 Year</option>
                                            <option value="9 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == '9 Year'){echo 'selected';}}?>>9 Year</option>
                                            <option value="More than 10 Year" <?php if(isset($Userprofile_edit_data->experience)){ if($Userprofile_edit_data->experience == 'More than 10 Year'){echo 'selected';}}?>>More than 10 Year</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="career">Career Level :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="career" name="career"  required>
                                            <option value="">---- Select Career Level ----</option>
                                            <option value="0" <?php // if(isset($Userprofile_edit_data->careerlevel)){ if($Userprofile_edit_data->careerlevel == '0'){echo 'selected';}} ?>>Department Head</option>
                                            <option value="1" <?php //if(isset($Userprofile_edit_data->careerlevel)){ if($Userprofile_edit_data->careerlevel == '1'){echo 'selected';}} ?>>Entery Level</option>
                                            <option value="2" <?php //if(isset($Userprofile_edit_data->careerlevel)){ if($Userprofile_edit_data->careerlevel == '2'){echo 'selected';}} ?>>Experienced Professional</option>
                                            <option value="3" <?php //if(isset($Userprofile_edit_data->careerlevel)){ if($Userprofile_edit_data->careerlevel == '3'){echo 'selected';}}?>>GM / CEO / Country Head / President</option>
                                            <option value="4" <?php //if(isset($Userprofile_edit_data->careerlevel)){ if($Userprofile_edit_data->careerlevel == '4'){echo 'selected';}}?>> Intern / Student</option>
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
                                                @foreach($jobskill as $jobskill_id)
                                                <option class="custom-select" value='{{$jobskill_id->id}}' <?php if(isset($Userprofile_edit_data->jobskill_id)){ if($Userprofile_edit_data->jobskill_id == $jobskill_id->id){echo 'selected';}} ?> >{{$jobskill_id->jobskill}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="career" name="career" required>
                                                <option value="" selected="">Select Career Level</option>
                                               @foreach($career as $careers)
                                                <option class="custom-select" value='{{$careers->id}}' <?php if(isset($Userprofile_edit_data->careerlevel)){ if($Userprofile_edit_data->careerlevel == $careers->id){echo 'selected';}} ?> >{{$careers->careerlevel}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="add_row" class="thumbs" style="cursor: pointer;" onclick="add_skill_level()"><i class="fa fa-plus fa-2x mt-2" id='add_button' aria-hidden="true"></i></div>
                                        {{-- <button class="add_button " id="add_button" title="Add field"><i class="fa fa-plus fa-2x mt-1" aria-hidden="true"></i></button> --}}
                                    </div>
                                </div>  
                                    <div class="field_wrapper">
                                        <div class="form-group row">
                                         <?php $id = 1; ?>
                                            <div class="col-sm-2">
                                                <label for="jobskill"> </label>
                                            </div>
                                            <?php $id++;?>
                                            <div class="col-sm-4 add_skill">
                                                @if(isset($Fillskill_id))
                                                    @foreach($Fillskill_id as $Fillskill)
                                                        <select class="form-control" name="skill[]" id="skill{{$id}}">
                                                            @foreach($jobskill as $get_skill)
                                                                <option value="{{$get_skill->id}}" <?php echo (isset($Fillskill_id) && $get_skill->id == $Fillskill) ? 'selected="selected"' : "" ?> >{{$get_skill->jobskill}}</option>
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
                                                                <option value="{{$careerlevel->id}}" <?php  echo (isset($Filllevel_id) && $careerlevel->id == $level_id ) ? 'selected="selected"' : "" ?>>{{$careerlevel->careerlevel}}</option>
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
                                        <label for="industry">Category & Sub Category :</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control" id="industry" name="industry" required>
                                            <option value="">---- Select Category ----</option>
                                            @foreach($industry as $industry)
                                            <option class="custom-select" value={{$industry->id }} <?php if(isset($Userprofile_edit_data->industry_id)){ if($Userprofile_edit_data->industry_id == $industry->id){echo 'selected';}} ?>>{{$industry->industry_name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    {{-- <div class="col-sm-5">
                                        <select class="form-control" id="functional" name="functional" required>
                                            <option value="">---- Select Sub Category----</option>
                                            @foreach($functional_area as $functional)
                                            <option class="custom-select" value={{$functional->id }} <?php // if(isset($Userprofile_edit_data->functional_id)){ if($Userprofile_edit_data->functional_id == $functional->id){echo 'selected';}} ?>>{{$functional->functional_area}}</option>
                                            @endforeach 
                                        </select>
                                    </div> --}}
                                    <div class="col-sm-5">
                                        <select class="form-control" id="subCategory" name="subCategory[]" multiple required data-placeholder=" ---- Sub Category ---- ">
                                        @if(isset($subCategories))
                                            @foreach($subCategories as $subCategory)
                                                <option class="custom-select" value={{$subCategory->id }}  <?php  echo (isset($Userprofilefunctionalarea_id) && in_array($subCategory->id, $Userprofilefunctionalarea_id) ) ? 'selected="selected"' : ""?>>{{$subCategory->functional_area}}</option>
                                            @endforeach 
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="functional">Category :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="functional" name="functional" required>
                                            <option value="">---- Select Category----</option>
                                            @foreach($functional_area as $functional)
                                            <option class="custom-select" value={{$functional->id }} <?php //if(isset($Userprofile_edit_data->functional_id)){ if($Userprofile_edit_data->functional_id == $functional->id){echo 'selected';}} ?>>{{$functional->functional_area}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div> --}}
                                    
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="csalary"> Salary :</label>
                                    </div>
                                    <div class="col-sm-5">
                                       {{-- <input type="text" class="form-control" id="csalary" name="csalary"  placeholder="Current Salary" value="{{isset($Userprofile_edit_data->currentsalary) ? $Userprofile_edit_data->currentsalary : ''}}" > --}}
                                       <select class="form-control" id="csalary" name="csalary" required>
                                         <option value="" selected="">Current Salary</option>
                                           @foreach($salaries as $CurrentSalary)
                                              <option class="custom-select" value='{{$CurrentSalary->id}}' <?php if(isset($Userprofile_edit_data->currentsalary)){ if($Userprofile_edit_data->currentsalary == $CurrentSalary->id){echo 'selected';}} ?> >{{$CurrentSalary->salary}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        {{-- <input type="text" class="form-control" id="esalary" name="esalary"  placeholder="Desired Salary" value="{{isset($Userprofile_edit_data->expectedsalary) ? $Userprofile_edit_data->expectedsalary : ''}}" > --}}
                                        <select class="form-control" id="esalary" name="esalary" required>
                                            <option value="" selected="">Desired Salary</option>
                                              @foreach($salaries as $DesiredSalary)
                                                 <option class="custom-select" value='{{$DesiredSalary->id}}' <?php if(isset($Userprofile_edit_data->expectedsalary)){ if($Userprofile_edit_data->expectedsalary == $DesiredSalary->id){echo 'selected';}} ?> >{{$DesiredSalary->salary}}</option>
                                               @endforeach
                                           </select>
                                     </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="esalary">Desired Salary:</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="esalary" name="esalary"  placeholder="Expected Salary" value="{{isset($Userprofile_edit_data->expectedsalary) ? $Userprofile_edit_data->expectedsalary : ''}}" >
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="strretaddress">Street Address :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <textarea class="form-control" id="strretaddress" name= "strretaddress" rows="5">{{isset($Userprofile_edit_data->streetaddress) ? $Userprofile_edit_data->streetaddress : ''}}</textarea>
                                    </div>  
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="status">Status:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="status" name="status" value="{{isset($Userprofile_edit_data->status) ? $Userprofile_edit_data->status : ''}}" required>
                                            <option value="1" <?php if(isset($Userprofile_edit_data->userstatus)){ if($Userprofile_edit_data->userstatus == '1'){echo 'selected';}} ?>> Active</option>
                                            <option value="0" <?php if(isset($Userprofile_edit_data->userstatus)){ if($Userprofile_edit_data->userstatus == '0'){echo 'selected';}}?>> Inactive</option>
                                        </select>
                                      
                                    </div>
                                </div>
                                <button type="submit" id="addUserprofile" name="addUserprofile" class="btn btn-primary">Submit</button>
                                <button type="submit" class="btn btn-secondary">Cancle</button>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/admin/js/userprofile.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/userprofile_img_cropper.js')}}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.3/cropper.js'></script>
{{-- <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();    
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profileimg").change(function(){
        readURL(this);
    });
    </script> --}}
@endsection
