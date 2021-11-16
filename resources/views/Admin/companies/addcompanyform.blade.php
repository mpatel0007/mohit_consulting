@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add Company')
@section('pagetitle', 'Companies')
@section('pagesubtitle', 'Companies')
@section('subtitle', 'Add Company')
@section('headersection')
<link rel="stylesheet" href="{{ asset('assets/img_cropper_css.css') }}">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.3/cropper.css'>
@endsection
@section('admincontent')
@include('Admin.companies.img_copper_modal')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Add Company</h4>
                        </div>
                    </div>
                <div class="iq-card-body">
                       <div class="alert alert-danger print-error-msg" style="display:none;">
                            <ul></ul>
                        </div>
                        <form onsubmit="return false" method="post" id="addCompanyform" class="needs-validation" novalidate name="addCompanyform" autocomplete="false">
                            {{ csrf_field() }}
                            <input type="hidden" id="hid" name="hid" value="{{isset($Companies_edit_data->id) ? $Companies_edit_data->id : ''}}">
                            <input type="hidden" id="croppedImageDataURL" name="croppedImageDataURL" value=" ">
                            <div class="float-right">
                                <label for="file-input">
                                    <label for="file-input">
                                        @if (isset($Companies_edit_data->companylogo))
                                            <img src="{{ $Companies_edit_data->companylogo }}" width="100px" id="edit_img" alt="" title="">
                                        @else
                                            <img src="{{ asset('assets/front_end/images/noimage.jpg') }}"  style="cursor: pointer;" id="img_choose" class="float-right">                                                
                                        @endif
                                    </label>
                                    <input id="file-input" type="file" name="profileimg" accept="image/*"/>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="User" style="margin-left: -15px;">User :</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" id="User" name="User" required @php if(isset($Companies_edit_data->user_id)) { echo 'disabled'; } @endphp>
                                        <option value="">---- Select User ----</option>
                                        @foreach($Users as $User)
                                        <option class="custom-select" value='{{$User->id}}' <?php if(isset($Companies_edit_data->user_id)){ if($Companies_edit_data->user_id == $User->id){echo 'selected';}} ?> >{{$User->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="companylog" style="margin-left: -15px;">Company Details :</label>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="companyname" name="companyname"  placeholder="Enter Company Name" value="{{isset($Companies_edit_data->companyname) ? $Companies_edit_data->companyname : ''}}" required>
                                 </div>
                                 <div class="col-sm-5">
                                    <input type="email" class="form-control" id="companyemail" name="companyemail"  placeholder="Enter Company Email" value="{{isset($Companies_edit_data->companyemail) ? $Companies_edit_data->companyemail : ''}}" required>
                                 </div>
                            </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label>Password :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" value="" required>

                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="companyseo">Company SEO :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="companyseo" name="companyseo"  placeholder="Company SEO" value="{{isset($Companies_edit_data->companyseo) ? $Companies_edit_data->companyseo : ''}}" >

                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="Ownership">Ownership :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="ownershiptype" name="ownershiptype" >
                                            <option value="">---- Select Ownership Type ----</option>
                                            <option value="1" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '1'){echo 'selected';}} ?>>Sole Proprietorship</option>
                                            <option value="2" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '2'){echo 'selected';}} ?>>Public</option>
                                            <option value="3" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '3'){echo 'selected';}} ?>>Private</option>
                                            <option value="4" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '4'){echo 'selected';}} ?>>Government</option>
                                            <option value="5" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '5'){echo 'selected';}} ?>>NGO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="Category & Sub Category">Category & Sub Category :</label>
                                    </div>
                                    {{-- <div class="col-sm-5">
                                        <select class="form-control" id="industry" name="industry[]" multiple required data-placeholder=" ---- Category ---- ">
                                            @foreach($industry as $industry)
                                            <option class="custom-select" value={{$industry->id }}  <?php // echo (isset($Companyindustry_id) && in_array($industry->id, $Companyindustry_id) ) ? 'selected="selected"' : ""?>>{{$industry->industry_name}}</option>
                                            @endforeach 
                                        </select>
                                    </div> --}}
                                 
                                    <div class="col-sm-4">
                                        <select class="form-control" id="industry" name="industry" required >
                                            <option value="">---- Category ----</option>
                                            @foreach($industry as $industry)
                                                <option class="custom-select" value={{$industry->id }} <?php if(isset($Companies_edit_data->industry_id)){ if($Companies_edit_data->industry_id == $industry->id){echo 'selected';}} ?>>{{$industry->industry_name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="subCategory" name="subCategory[]" multiple required data-placeholder=" ---- Sub Category ---- ">
                                        @if(!empty($subCategories))
                                            @foreach($subCategories as $subCategory)
                                                <option class="custom-select" value={{$subCategory->id }}  <?php  echo (isset($Companyfunctionalarea_id) && in_array($subCategory->id, $Companyfunctionalarea_id) ) ? 'selected="selected"' : ""?>>{{$subCategory->functional_area}}</option>
                                            @endforeach 
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="Company Location">Company Location :</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="country" name="country" required>
                                            <option value="">---- Select Country ----</option>
                                            @foreach($country as $country)
                                            <option class="custom-select" value='{{$country->id}}' <?php if(isset($Companies_edit_data->country_id)){ if($Companies_edit_data->country_id == $country->id){echo 'selected';}} ?> >{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="state" name="state" required>
                                        <option value="">----- Select Country First ------ </option>
                                        @if(isset($state))
                                            @foreach($state as $state)
                                            <option value="{{$state->id}}" <?php if(isset($Companies_edit_data->state_id)){ if($Companies_edit_data->state_id == $state->id){echo 'selected';}}?>> {{$state->state_name}}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="city" name="city[]" multiple required data-placeholder="  ----- Select State first -----">
                                            @if(isset($city))
                                            @foreach($city as $city)
                                            <option value="{{$city->id}}" <?php echo (isset($Fillcity_id) && in_array($city->id, $Fillcity_id) ) ? 'selected="selected"' : ""   ?>> {{$city->city_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="companydetail">Company Details :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea id="companydetail" class="form-control" class="editor" name="companydetail" rows="10" cols="80" >{{isset($Companies_edit_data->companydetail) ? $Companies_edit_data->companydetail : ''}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="location">Location & Website :</label>
                                    </div>
                                    <div class="col-sm-5">
                                       <input type="text" class="form-control" id="location" name="location"  placeholder="Location" value="{{isset($Companies_edit_data->location) ? $Companies_edit_data->location : ''}}" >        
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="website" name="website"  placeholder="Website" value="{{isset($Companies_edit_data->website) ? $Companies_edit_data->website : ''}}" >
                                     </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="website">Website :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="website" name="website"  placeholder="Website" value="{{isset($Companies_edit_data->website) ? $Companies_edit_data->website : ''}}" >
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="googlemap">Google Map</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <textarea class="form-control" placeholder="Google Map" id="googlemap" name="googlemap" rows="2" >{{isset($Companies_edit_data->googlemap) ? $Companies_edit_data->googlemap : ''}}</textarea>
                                    </div>  
                                </div>
{{-- 
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="numberofoffices">Number of offices:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="numberofoffices" name="numberofoffices" value="{{isset($Companies_edit_data->numberofoffices) ? $Companies_edit_data->numberofoffices : ''}}" >
                                            <option value="">---- Select Number of offices ----</option>
                                            <option value="1" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '1'){echo 'selected';}} ?>>1</option>
                                            <option value="2" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '2'){echo 'selected';}} ?>>2</option>
                                            <option value="3" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '3'){echo 'selected';}} ?>>3</option>
                                            <option value="4" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '4'){echo 'selected';}} ?>>4</option>
                                            <option value="5" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '5'){echo 'selected';}} ?>>5</option>
                                            <option value="6" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '6'){echo 'selected';}} ?>>6</option>
                                            <option value="7" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '7'){echo 'selected';}} ?>>7</option>
                                            <option value="8" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '8'){echo 'selected';}} ?>>8</option>
                                            <option value="9" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '9'){echo 'selected';}} ?>>9</option>
                                            <option value="10" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '10'){echo 'selected';}} ?>>10</option>
                                            <option value="11" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '11'){echo 'selected';}} ?>>11</option>
                                            <option value="12" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '12'){echo 'selected';}} ?>>12</option>
                                            <option value="13" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '13'){echo 'selected';}} ?>>13</option>
                                            <option value="14" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '14'){echo 'selected';}} ?>>14</option>
                                            <option value="15" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '15'){echo 'selected';}} ?>>15</option>
                                            <option value="16" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '16'){echo 'selected';}} ?>>16</option>
                                            <option value="17" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '17'){echo 'selected';}} ?>>17</option>
                                            <option value="18" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '18'){echo 'selected';}} ?>>18</option>
                                            <option value="19" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '19'){echo 'selected';}} ?>>19</option>
                                            <option value="20" <?php //if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '20'){echo 'selected';}} ?>>20</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="numberofemployees">Offices & Employees:</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="numberofoffices" name="numberofoffices" value="{{isset($Companies_edit_data->numberofoffices) ? $Companies_edit_data->numberofoffices : ''}}" >
                                            <option value="">---- Select Number of offices ----</option>
                                            <option value="1" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '1'){echo 'selected';}} ?>>1</option>
                                            <option value="2" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '2'){echo 'selected';}} ?>>2</option>
                                            <option value="3" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '3'){echo 'selected';}} ?>>3</option>
                                            <option value="4" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '4'){echo 'selected';}} ?>>4</option>
                                            <option value="5" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '5'){echo 'selected';}} ?>>5</option>
                                            <option value="6" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '6'){echo 'selected';}} ?>>6</option>
                                            <option value="7" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '7'){echo 'selected';}} ?>>7</option>
                                            <option value="8" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '8'){echo 'selected';}} ?>>8</option>
                                            <option value="9" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '9'){echo 'selected';}} ?>>9</option>
                                            <option value="10" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '10'){echo 'selected';}} ?>>10</option>
                                            <option value="11" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '11'){echo 'selected';}} ?>>11</option>
                                            <option value="12" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '12'){echo 'selected';}} ?>>12</option>
                                            <option value="13" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '13'){echo 'selected';}} ?>>13</option>
                                            <option value="14" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '14'){echo 'selected';}} ?>>14</option>
                                            <option value="15" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '15'){echo 'selected';}} ?>>15</option>
                                            <option value="16" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '16'){echo 'selected';}} ?>>16</option>
                                            <option value="17" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '17'){echo 'selected';}} ?>>17</option>
                                            <option value="18" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '18'){echo 'selected';}} ?>>18</option>
                                            <option value="19" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '19'){echo 'selected';}} ?>>19</option>
                                            <option value="20" <?php if(isset($Companies_edit_data->numberofoffices)){ if($Companies_edit_data->numberofoffices == '20'){echo 'selected';}} ?>>20</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                       <input type="text" class="form-control" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="numberofemployees" name="numberofemployees"  placeholder="Employees" value="{{isset($Companies_edit_data->numberofemployees) ? $Companies_edit_data->numberofemployees : ''}}" >
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="establishedin" name="establishedin"  placeholder="Established in" value="{{isset($Companies_edit_data->establishedin) ? $Companies_edit_data->establishedin : ''}}" >
                                     </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="establishedin">Established in :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="establishedin" name="establishedin"  placeholder="Established in" value="{{isset($Companies_edit_data->establishedin) ? $Companies_edit_data->establishedin : ''}}" >
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="fax">Number :</label>
                                    </div>
                                    <div class="col-sm-5">
                                       <input type="text" class="form-control" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="fax" name="fax"  placeholder="Fax" value="{{isset($Companies_edit_data->fax) ? $Companies_edit_data->fax : ''}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" autocomplete="false" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="phone" name="phone"  placeholder="Phone" value="{{isset($Companies_edit_data->phone) ? $Companies_edit_data->phone : ''}}" >
                                     </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="phone">Phone :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" autocomplete="false" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="phone" name="phone"  placeholder="Phone" value="{{isset($Companies_edit_data->phone) ? $Companies_edit_data->phone : ''}}" >
                                    </div>

                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="facebook">Social Media:</label>
                                    </div>
                                    <div class="col-sm-4">
                                       <input type="text" class="form-control" id="facebook" name="facebook"  placeholder="Facebook" value="{{isset($Companies_edit_data->facebook) ? $Companies_edit_data->facebook : ''}}">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="twitter" name="twitter"  placeholder="Twitter" value="{{isset($Companies_edit_data->twitter) ? $Companies_edit_data->twitter : ''}}">
                                     </div>
                                     <div class="col-sm-3">
                                        <input type="text" class="form-control" id="linkedin" name="linkedin"  placeholder="Linked in" value="{{isset($Companies_edit_data->linkedin) ? $Companies_edit_data->linkedin : ''}}">
                                     </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="twitter">Twitter :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="twitter" name="twitter"  placeholder="Twitter" value="{{isset($Companies_edit_data->twitter) ? $Companies_edit_data->twitter : ''}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="linkedin">Linkedin :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="linkedin" name="linkedin"  placeholder="Linked in" value="{{isset($Companies_edit_data->linkedin) ? $Companies_edit_data->linkedin : ''}}">
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="google">Google+ & Pinterest :</label>
                                    </div>
                                    <div class="col-sm-5">
                                       <input type="text" class="form-control" id="google" name="google"  placeholder="Google+" value="{{isset($Companies_edit_data->google) ? $Companies_edit_data->google : ''}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="pinterest" name="pinterest"  placeholder="Pinterest" value="{{isset($Companies_edit_data->pinterest) ? $Companies_edit_data->pinterest : ''}}">
                                     </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="pinterest">Pinterest :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="pinterest" name="pinterest"  placeholder="Pinterest" value="{{isset($Companies_edit_data->pinterest) ? $Companies_edit_data->pinterest : ''}}">
                                    </div>
                                </div> --}}


                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="state">State :</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="state" name="state" required>
                                        <option value="">----- Select Country First ------ </option>
                                        @if(isset($state))
                                            @foreach($state as $state)
                                            <option value="{{$state->id}}" <?php // if(isset($Companies_edit_data->state_id)){ if($Companies_edit_data->state_id == $state->id){echo 'selected';}}?>> {{$state->state_name}}</option>
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
                                            <option value="{{$city->id}}" <?php // if(isset($Companies_edit_data->city_id)){ if($Companies_edit_data->city_id == $city->id){echo 'selected';}}?>> {{$city->city_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div> --}}

                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="city">City :</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="city" name="city[]" multiple required>
                                            @if(isset($city))
                                            @foreach($city as $city)
                                            <option value="{{$city->id}}" <?php // echo (isset($Fillcity_id) && in_array($city->id, $Fillcity_id) ) ? 'selected="selected"' : ""   ?>> {{$city->city_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="package">Package & Status :</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control" id="package" name="package" >
                                            <option value="">---- Select Package ----</option>
                                            @foreach($package as $package)
                                            <option value="{{$package->id}}" <?php if(isset($Companies_edit_data->package_id)){ if($Companies_edit_data->package_id == $package->id){echo 'selected';}}?>> @if($package->status == '1' && $package->package_for == '0') {{$package->package_title}} @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control" id="status" name="status" value="{{isset($Companies_edit_data->status) ? $Companies_edit_data->status : ''}}">
                                            <option value="1" <?php if(isset($Companies_edit_data->status)){ if($Companies_edit_data->status == '1'){echo 'selected';}} ?>> Active</option>
                                            <option value="0" <?php if(isset($Companies_edit_data->status)){ if($Companies_edit_data->status == '0'){echo 'selected';}}?>> Inactive</option>
                                        </select>
                                    </div>
                                </div>
{{-- 
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="status">Status:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="status" name="status" value="{{isset($Companies_edit_data->status) ? $Companies_edit_data->status : ''}}">
                                            
                                            <option value="1" <?php //if(isset($Companies_edit_data->status)){ if($Companies_edit_data->status == '1'){echo 'selected';}} ?>> Active</option>
                                            <option value="0" <?php //if(isset($Companies_edit_data->status)){ if($Companies_edit_data->status == '0'){echo 'selected';}}?>> Inactive</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <button type="submit" id="addcompany" name="addcompany" class="btn btn-primary">Submit</button>
                                <button type="submit" class="btn btn-secondary">Cancle</button>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footersection')
<script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/companies.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/company_img_cropper.js')}}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.3/cropper.js'></script>

<script type="text/javascript">
    $(document).ready(function () {
        // admin.cms.initialize();
        CKEDITOR.replace('companydetail', { customConfig: "{{ asset('assets/admin/custom_config.js')}}"});
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraAllowedContent ﻿= 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
    });
</script>
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
    $("#companylog").change(function(){
        readURL(this);
    });
    </script> --}}
@endsection
