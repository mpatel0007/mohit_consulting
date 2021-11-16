@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Change Company Information')
@section('pageheader', 'Change Company Information')
@section('headersection')
<link rel="stylesheet" href="{{ asset('assets/img_cropper_css.css') }}">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.3/cropper.css'>
@endsection
@section('content')
@include('Front_end.employers.jobs.img_copper_modal')
<div id="content">
    <div class="container">
        <div class="row">
            @include('Front_end.candidate.ManageProfile.left_menu')
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="job-alerts-item">
                        <div class="alert alert-danger print-error-msg" style="display:none;">
                            <ul></ul>
                        </div>
                        <form onsubmit="return false" method="post" id="CompanyProfile" class="needs-validation" novalidate name="CompanyProfile" autocomplete="false">
                            {{ csrf_field() }}
                            <input type="hidden" id="hid" name="hid" value="{{isset($Companies_edit_data->id) ? $Companies_edit_data->id : ''}}">
                            {{-- <div class="row">
                                <div class="image-upload col-sm-3">
                                    <label for="file-input">
                                        @if (isset($Companies_edit_data->companylogo))
                                            <img src="{{$Companies_edit_data->companylogo }}" width="100px" id="edit_img" alt="" title="">
                                        @else
                                            <img src="{{ asset('assets/front_end/images/noimage.jpg') }}"  style="cursor: pointer;" id="img_choose" class="float-right">                                                
                                        @endif
                                    </label>
                                    <input id="file-input" type="file" name="profileimg" accept="image/*"/>
                                </div>
                                <div class="col-sm-4">
                                    <div id="result" class="result"></div>
                                </div>
                            </div> --}}
                            
                            <div class="form-group row">
                                {{-- <div class="col-sm-5"> --}}
                                    {{-- <label for="companylog" class="ml-2">Company Details :</label> --}}
                                   {{-- <input type="file" class="form-control" id="companylog" name="companylog"  value="{{isset($Companies_edit_data->companylog) ? $Companies_edit_data->companyname : ''}}">
                                   <div class="custom-file">
									    <input type="file" class="custom-file-input" id="companylog" name="companylog" value="{{isset($Companies_edit_data->companylog) ? $Companies_edit_data->companylog : ''}}">
									    <label class="custom-file-label" for="customFile">Choose Photo</label>
								    </div> --}}
                                {{-- </div> --}}
                                <div class="col-sm-9">
                                    <label for="Company Name" class="ml-2">Company Name :</label>
                                    <input type="text" class="form-control" id="companyname" name="companyname"  placeholder="Enter Company Name" value="{{isset($Companies_edit_data->companyname) ? $Companies_edit_data->companyname : ''}}" required>
                                 </div>
                                 <div class="image-upload col-sm-3">
                                    <label for="file-input">
                                        @if (isset($Companies_edit_data->companylogo))
                                            <img src="{{$Companies_edit_data->companylogo }}" width="100px" id="edit_img" alt="" title="">
                                        @else
                                            <img src="{{ asset('assets/front_end/images/noimage.jpg') }}"  style="cursor: pointer;" id="img_choose" class="float-right">                                                
                                        @endif
                                    </label>
                                    <input id="file-input" type="file" name="profileimg" accept="image/*"/>
                                </div>
                            </div>         
                              
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="Company Email" class="ml-2">Company Email :</label>
                                        <input type="email" class="form-control" id="companyemail" name="companyemail"  placeholder="Enter Company Email" value="{{isset($Companies_edit_data->companyemail) ? $Companies_edit_data->companyemail : ''}}" required>
                                     </div>
                                    <div class="col-sm-6">
                                        <label for="Ownership" class="ml-2">Ownership :</label>
                                        <select class="form-control" id="ownershiptype" name="ownershiptype" >
                                            <option value="">Select Ownership Type</option>
                                            <option value="1" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '1'){echo 'selected';}} ?>>Sole Proprietorship</option>
                                            <option value="2" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '2'){echo 'selected';}} ?>>Public</option>
                                            <option value="3" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '3'){echo 'selected';}} ?>>Private</option>
                                            <option value="4" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '4'){echo 'selected';}} ?>>Government</option>
                                            <option value="5" <?php if(isset($Companies_edit_data->ownershiptype)){ if($Companies_edit_data->ownershiptype == '5'){echo 'selected';}} ?>>NGO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="Category" class="ml-2">Category :</label>
                                        <select class="form-control" id="industry" name="industry" required >
                                            <option value="">---- Category ----</option>
                                            @foreach($industry as $industry)
                                                <option class="custom-select" value={{$industry->id }} <?php if(isset($Companies_edit_data->industry_id)){ if($Companies_edit_data->industry_id == $industry->id){echo 'selected';}} ?>>{{$industry->industry_name}}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="Sub Category" class="ml-2">Sub Category :</label>
                                        <select class="form-control" id="subCategory" name="subCategory[]" multiple required data-placeholder=" ---- Sub Category ---- ">
                                        @if(isset($Companyfunctionalarea_id))
                                            @foreach($subCategories as $subCategory)
                                                <option class="custom-select" value={{$subCategory->id }}  <?php  echo (isset($Companyfunctionalarea_id) && in_array($subCategory->id, $Companyfunctionalarea_id) ) ? 'selected="selected"' : ""?>>{{$subCategory->functional_area}}</option>
                                            @endforeach 
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="Country" class="ml-2">Country :</label>
                                        <select class="form-control" id="country" name="country" required>
                                            <option value="">Country</option>
                                            @foreach($country as $country)
                                            <option class="custom-select" value='{{$country->id}}' <?php if(isset($Companies_edit_data->country_id)){ if($Companies_edit_data->country_id == $country->id){echo 'selected';}} ?> >{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="State" class="ml-2">State :</label>
                                        <select class="form-control" id="state" name="state" required>
                                        <option value="">State</option>
                                        @if(isset($state))
                                            @foreach($state as $state)
                                            <option value="{{$state->id}}" <?php if(isset($Companies_edit_data->state_id)){ if($Companies_edit_data->state_id == $state->id){echo 'selected';}}?>> {{$state->state_name}}</option>
                                            @endforeach
                                        @endif
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="City" class="ml-2">City :</label>
                                        <select class="form-control" id="city" name="city[]" multiple required data-placeholder="City">
                                            @if(isset($city))
                                            @foreach($city as $city)
                                            <option value="{{$city->id}}" <?php echo (isset($Fillcity_id) && in_array($city->id, $Fillcity_id) ) ? 'selected="selected"' : ""   ?>> {{$city->city_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="Company Details" class="ml-2">Company Details :</label>
                                        <textarea id="companydetail" class="form-control" class="editor" name="companydetail" rows="2" cols="50" >{{isset($Companies_edit_data->companydetail) ? $Companies_edit_data->companydetail : ''}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="Location" class="ml-2">Location :</label>
                                       <input type="text" class="form-control" id="location" name="location"  placeholder="Location" value="{{isset($Companies_edit_data->location) ? $Companies_edit_data->location : ''}}" >        
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="Website" class="ml-2">Website :</label>
                                        <input type="text" class="form-control" id="website" name="website"  placeholder="Website" value="{{isset($Companies_edit_data->website) ? $Companies_edit_data->website : ''}}" >
                                     </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="Google Map" class="ml-2">Google Map :</label>
                                       <textarea class="form-control" placeholder="Google Map" id="googlemap" name="googlemap" rows="2" >{{isset($Companies_edit_data->googlemap) ? $Companies_edit_data->googlemap : ''}}</textarea>
                                    </div>  
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="Offices" class="ml-2">Offices :</label>
                                        <select class="form-control" id="numberofoffices" name="numberofoffices" value="{{isset($Companies_edit_data->numberofoffices) ? $Companies_edit_data->numberofoffices : ''}}" >
                                            <option value="">Number of offices</option>
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
                                    <div class="col-sm-4">
                                        <label for="Employees" class="ml-2">Employees :</label>
                                       <input type="text" class="form-control" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="numberofemployees" name="numberofemployees"  placeholder="Employees" value="{{isset($Companies_edit_data->numberofemployees) ? $Companies_edit_data->numberofemployees : ''}}" >
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="Established in" class="ml-2">Established in :</label>
                                        <input type="text" class="form-control" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="establishedin" name="establishedin"  placeholder="Established in" value="{{isset($Companies_edit_data->establishedin) ? $Companies_edit_data->establishedin : ''}}" >
                                     </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="Fax Number" class="ml-2">Fax Number :</label>
                                       <input type="text" class="form-control" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 67" id="fax" name="fax"  placeholder="Fax" value="{{isset($Companies_edit_data->fax) ? $Companies_edit_data->fax : ''}}">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="Phone Number" class="ml-2">Phone Number :</label>
                                        <input type="text" class="form-control" autocomplete="false" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" id="phone" name="phone"  placeholder="Phone" value="{{isset($Companies_edit_data->phone) ? $Companies_edit_data->phone : ''}}" >
                                     </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="Facebook" class="ml-2">Facebook :</label>
                                       <input type="text" class="form-control" id="facebook" name="facebook"  placeholder="Facebook" value="{{isset($Companies_edit_data->facebook) ? $Companies_edit_data->facebook : ''}}">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="Twitter" class="ml-2">Twitter :</label>
                                        <input type="text" class="form-control" id="twitter" name="twitter"  placeholder="Twitter" value="{{isset($Companies_edit_data->twitter) ? $Companies_edit_data->twitter : ''}}">
                                     </div>
                                     <div class="col-sm-4">
                                        <label for="Linked in" class="ml-2">Linked in :</label>
                                        <input type="text" class="form-control" id="linkedin" name="linkedin"  placeholder="Linked in" value="{{isset($Companies_edit_data->linkedin) ? $Companies_edit_data->linkedin : ''}}">
                                     </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="Google+" class="ml-2">Google+ :</label>
                                       <input type="text" class="form-control" id="google" name="google"  placeholder="Google+" value="{{isset($Companies_edit_data->google) ? $Companies_edit_data->google : ''}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="Pinterest" class="ml-2">Pinterest :</label>
                                        <input type="text" class="form-control" id="pinterest" name="pinterest"  placeholder="Pinterest" value="{{isset($Companies_edit_data->pinterest) ? $Companies_edit_data->pinterest : ''}}">
                                     </div>
                                </div>
               
                                {{-- <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="package">Package & Status :</label>
                                    </div>
                                    <div class="col-sm-5">
                                        <select class="form-control" id="package" name="package" >
                                            <option value="">---- Select Package ----</option>
                                            @foreach($package as $package)
                                            <option value="{{$package->id}}" <?php // if(isset($Companies_edit_data->package_id)){ if($Companies_edit_data->package_id == $package->id){echo 'selected';}}?>> @if($package->status == '1' && $package->package_for == '0') {{$package->package_title}} @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="status" name="status" value="{{isset($Companies_edit_data->status) ? $Companies_edit_data->status : ''}}">
                                            <option value="1" <?php //if(isset($Companies_edit_data->status)){ if($Companies_edit_data->status == '1'){echo 'selected';}} ?>> Active</option>
                                            <option value="0" <?php //if(isset($Companies_edit_data->status)){ if($Companies_edit_data->status == '0'){echo 'selected';}}?>> Inactive</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <button type="submit" id="addcompany" name="addcompany" class="btn btn-primary">Submit</button>
                                <a href="{{ route('front_end-manage-jobs-view')}}" class="btn btn-secondary">Cancle</a>
                         </form>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection

    @section('footersection')
    <script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset('assets/front_end/js/employers/companyinfo.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/front_end/js/employers/img_copper_js.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.3/cropper.js'></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // admin.cms.initialize();
            CKEDITOR.replace('companydetail', { customConfig: "{{ asset('assets/admin/custom_config.js')}}"});
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.height='160px';
            CKEDITOR.config.extraAllowedContent ﻿= 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
        });
    </script>
    @endsection
