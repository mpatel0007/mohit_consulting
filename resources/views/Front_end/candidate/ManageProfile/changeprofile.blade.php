@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Change profile')
@section('pageheader', 'Change profile')

@section('headersection')
<link rel="stylesheet" href="{{ asset('assets/img_cropper_css.css') }}">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.3/cropper.css'>
@endsection
@section('content')
@include('Front_end.candidate.ManageProfile.img_copper_modal')


<div id="content">
    <div class="container">  
        <div class="row">
            @include('Front_end.candidate.ManageProfile.left_menu')
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="job-alerts-item">
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul></ul>
                    </div>
                        <form onsubmit="return false" method="post" id="changeUserprofile" class="needs-validation" novalidate name="changeUserprofile" autocomplete="false">
                            {{ csrf_field() }}
                            <input type="hidden" id="hid" name="hid" value="{{ isset($Userprofile_edit_data->id) ? $Userprofile_edit_data->id : '' }}">
                            <div class="float-right">
                                        <label for="file-input">
                                            @if (isset($Userprofile_edit_data->profileimg))
                                                <img src="{{$Userprofile_edit_data->profileimg }}" width="100px" id="edit_img" alt="" title="">
                                            @else
                                            <img src="{{ asset('assets/front_end/images/noimage.jpg') }}"  style="cursor: pointer;" id="img_choose" class="float-right">                                                
                                            @endif
                                        </label>
                                        <input id="file-input" type="file" name="profileimg" accept="image/*"/>
                            </div>
                            <div class="form-group row">
                                {{-- <div class="col-sm-2">
                                    <label for="fname">Name :</label>
                                </div> --}}
                                <div class="col-sm-4">
                                    <label for="First Name" class="ml-2">First Name :</label>
                                    <input type="text" class="form-control" id="Userprofile_edit_data" name="fname" placeholder="Enter First Name" value="{{ isset($Userprofile_edit_data->name) ? $Userprofile_edit_data->name : '' }}" required>
                                </div>
                                <div class="col-sm-4">
                                    <label for="Middle Name" class="ml-2">Middle Name :</label>
                                    <input type="text" class="form-control" id="mname" name="mname" placeholder="Enter Middle Name" value="{{ isset($Userprofile_edit_data->mname) ? $Userprofile_edit_data->mname : '' }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="Last Name" class="ml-2">Last Name :</label>
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Last Name" value="{{ isset($Userprofile_edit_data->lname) ? $Userprofile_edit_data->lname : '' }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="dob" class="ml-2">Date of Birth :</label>
                                    <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter Date of Birth" value="{{ isset($Userprofile_edit_data->dateofbirth) ? $Userprofile_edit_data->dateofbirth : '' }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="country" class="ml-2">Country:</label>
                                    <select class="form-control" id="country" name="country" required>
                                        <option value="">Select Country</option>
                                        @foreach ($country as $country)
                                            <option class="custom-select" value='{{ $country->id }}' <?php if (isset($Userprofile_edit_data->country_id)) { if ($Userprofile_edit_data->country_id == $country->id) { echo 'selected'; }} ?> >{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="state" class="ml-2">State:</label>
                                    <select class="form-control" id="state" name="state" required>
                                        <option value="">Select State</option>
                                        @if (isset($state))
                                            @foreach ($state as $state)
                                                <option value="{{ $state->id }}" <?php if(isset($Userprofile_edit_data->state_id)) { if ($Userprofile_edit_data->state_id == $state->id) { echo 'selected'; }} ?>> {{ $state->state_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="city" class="ml-2">City:</label>
                                    <select class="form-control" id="city" name="city" required>
                                        <option value="">Select City</option>
                                        @if (isset($city))
                                            @foreach ($city as $city)
                                                <option value="{{ $city->id }}" <?php if(isset($Userprofile_edit_data->city_id)) { if ($Userprofile_edit_data->city_id == $city->id) { echo 'selected'; } } ?>> {{ $city->city_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="Mobile Number" class="ml-2">Mobile Number:</label>
                                    <input type="text" class="form-control" autocomplete="false"
                                        onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57"
                                        id="mobile" name="mobile" placeholder="Mobile Number"
                                        value="{{ isset($Userprofile_edit_data->mobile) ? $Userprofile_edit_data->mobile : '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="Degree Level" class="ml-2">Degree Level :</label>
                                    <select class="form-control" id="degreelevel" name="degreelevel[]" multiple required data-placeholder="Select Degree Level">
                                        @foreach ($degreelevel as $degreelevel)
                                            <option class="custom-select" value='{{ $degreelevel->id }}' <?php echo isset($Filldegreelevel_id) && in_array($degreelevel->id,
                                                $Filldegreelevel_id) ? 'selected="selected"' : ''; ?>>{{ $degreelevel->degreelevel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="Experience" class="ml-2">Experience :</label>
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
                            <div class="field_wrapper">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="Skill" class="ml-2">Skill :</label>
                                        <select class="form-control" id="jobskill" name="jobskill" required>
                                            <option value="" selected="">Select Job Skill</option>
                                            @foreach ($jobskill as $jobskill_id)
                                                <option class="custom-select" value='{{ $jobskill_id->id }}' <?php if(isset($Userprofile_edit_data->jobskill_id)) { if($Userprofile_edit_data->jobskill_id == $jobskill_id->id) { echo 'selected'; } } ?> >{{ $jobskill_id->jobskill }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="Career Level" class="ml-2">Career Level :</label>   
                                        <select class="form-control" id="career" name="career" required>
                                            <option value="" selected="">Select Career Level</option>
                                            @foreach ($career as $careers)
                                                <option class="custom-select" value='{{ $careers->id }}' <?php if (isset($Userprofile_edit_data->careerlevel)) {if ($Userprofile_edit_data->careerlevel == $careers->id) {echo 'selected';}} ?> >{{ $careers->careerlevel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="add_row" class="thumbs mt-4" style="cursor: pointer;" onclick="add_skill_level()"><i class="fa fa-plus fa-2x mt-2" id='add_button' aria-hidden="true"></i></div>
                                    {{-- <button class="add_button " id="add_button" title="Add field"><i class="fa fa-plus fa-2x mt-1" aria-hidden="true"></i></button> --}}
                                </div>
                            </div>
                            <div class="field_wrapper">
                                <div class="form-group row">
                                    <?php $id = 1; ?>

                                    <?php $id++; ?>
                                    <div class="col-sm-4 add_skill">
                                        @if (isset($Fillskill_id))
                                            @foreach ($Fillskill_id as $Fillskill)
                                                <select class="form-control mb-1" name="skill[]" id="skill{{ $id }}">
                                                    @foreach ($jobskill as $get_skill)
                                                        <option value="{{ $get_skill->id }}" <?php echo
                                                            isset($Fillskill_id) && $get_skill->id == $Fillskill ?
                                                            'selected="selected"' : ''; ?>
                                                            >{{ $get_skill->jobskill }}</option>
                                                    @endforeach
                                                </select>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-sm-4 add_career_level">
                                        @if (isset($Filllevel_id))
                                            @foreach ($Filllevel_id as $level_id)
                                                <select class="form-control mb-1" name="level[]" id="level{{ $id }}">
                                                    @foreach ($career as $careerlevel)
                                                        <option value="{{ $careerlevel->id }}" <?php echo
                                                            isset($Filllevel_id) && $careerlevel->id == $level_id ?
                                                            'selected="selected"' : ''; ?>>{{ $careerlevel->careerlevel }}</option>
                                                    @endforeach
                                                </select>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-sm-2 add_icon">
                                        @if (isset($count))
                                            @for ($m = 1; $m <= $count; $m++)
                                                <div id="row{{ $id }}" class="thumbs mb-2" style="cursor: pointer;"
                                                    onclick="edit_remove_button({{ $id }})"><i
                                                        class="fa fa-minus-square fa-2x mt-2" id='{{ $id }}'
                                                        aria-hidden="true"></i></div>
                                            @endfor
                                        @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="Category" class="ml-2">Category :</label>
                                <select class="form-control" id="industry" name="industry" required>
                                    <option value=""> Category</option>
                                    @if ($industry)
                                        @foreach($industry as $industry)
                                                <option class="custom-select" value={{$industry->id }} <?php if(isset($Userprofile_edit_data->industry_id)){ if($Userprofile_edit_data->industry_id == $industry->id){echo 'selected';}} ?>>{{$industry->industry_name}}</option>
                                        @endforeach 
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="Sub Category" class="ml-2">Sub Category :</label>
                                <select class="form-control" id="subCategory" name="subCategory[]" multiple required data-placeholder="Sub Category">
                                @if(isset($Userprofilefunctionalarea_id))
                                    @foreach($subCategories as $subCategory)
                                        <option class="custom-select" value={{$subCategory->id }}  <?php echo (isset($Userprofilefunctionalarea_id) && in_array($subCategory->id, $Userprofilefunctionalarea_id) ) ? 'selected="selected"' : ""?>>{{$subCategory->functional_area}}</option>
                                    @endforeach 
                                @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="Current Salary" class="ml-2">Current Salary :</label>
                                {{-- <input type="text" class="form-control" id="csalary" name="csalary" placeholder="Current Salary" value="{{ isset($Userprofile_edit_data->currentsalary) ? $Userprofile_edit_data->currentsalary : '' }}"> --}}
                                <select class="form-control" id="csalary" name="csalary" required>
                                    <option value="" selected="">Current Salary</option>
                                      @foreach($salaries as $CurrentSalary)
                                         <option class="custom-select" value='{{$CurrentSalary->id}}' <?php if(isset($Userprofile_edit_data->currentsalary)){ if($Userprofile_edit_data->currentsalary == $CurrentSalary->id){echo 'selected';}} ?> >{{$CurrentSalary->salary}}</option>
                                       @endforeach
                                   </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="Desired Salary" class="ml-2">Desired Salary :</label>
                                {{-- <input type="text" class="form-control" id="esalary" name="esalary" placeholder="Desired Salary" value="{{ isset($Userprofile_edit_data->expectedsalary) ? $Userprofile_edit_data->expectedsalary : '' }}"> --}}
                                <select class="form-control" id="esalary" name="esalary" required>
                                    <option value="" selected="">Desired Salary</option>
                                      @foreach($salaries as $DesiredSalary)
                                         <option class="custom-select" value='{{$DesiredSalary->id}}' <?php if(isset($Userprofile_edit_data->expectedsalary)){ if($Userprofile_edit_data->expectedsalary == $DesiredSalary->id){echo 'selected';}} ?> >{{$DesiredSalary->salary}}</option>
                                       @endforeach
                                   </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="Address" class="ml-2">Address :</label>
                                <textarea class="form-control" id="strretaddress" name="strretaddress" rows="3">{{ isset($Userprofile_edit_data->streetaddress) ? $Userprofile_edit_data->streetaddress : '' }}</textarea>
                            </div>
                        </div>
                        <button type="submit" id="addUserprofile" name="addUserprofile"  class="btn btn-primary">Submit</button>
                        <a href="{{ route('front_end-candidate_manageprofile')}}"  class="btn btn-secondary">Cancle</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div>
    <label for="userprofileimg" class="ml-2">Profile Image :</label>
<div class="custom-file">
    <input type="file" class="custom-file-input" id="profileimg" name="profileimg">
    <label class="custom-file-label" for="customFile">Profile Image</label>
</div>
<div class="image-upload">
    <label for="file-input">
        @if (isset($Userprofile_edit_data->profileimg))
            <img src="{{ asset('assets/admin/userprofileImg/' . $Userprofile_edit_data->profileimg . '') }}" width="100px" id="edit_img" alt="" title="">
        @else
        <img src="{{ asset('assets/front_end/images/noimage.jpg') }}"  style="cursor: pointer;" id="img_choose" class="float-right">                                                
        @endif
    </label>
    <input id="file-input" type="file" name="profileimg"/>
</div>
<input type="button" id="btnCrop" class="btn btn-common" value="Crop" />
<input type="button" id="btnRestore" value="Restore" class="btn-btn-denger" />

<div class="col-sm-3">
<img src="" id="profile-img-tag" width="100px" style="border-radius: 50%; hight:100px;"/>
</div>
<div class="col-sm-3">
@if (isset($Userprofile_edit_data->profileimg))
    <img src="{{ asset('assets/admin/userprofileImg/' . $Userprofile_edit_data->profileimg . '') }}" width="100px" id="edit_img" alt="" title="">
@endif
</div>
</div> --}}

@endsection
@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/manageprofile.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/img_cropper_js.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.3/cropper.js'></script>
    {{-- <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#file-input").change(function() {
            readURL(this);
        });
    </script> --}}
@endsection
