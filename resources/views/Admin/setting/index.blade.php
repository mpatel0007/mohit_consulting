@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Setting')
@section('pagetitle', 'Admin Setting')
@section('pagesubtitle', 'Admin Setting')
@section('subtitle', 'Setting')
@section('admincontent')

<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Setting</h4>
                        </div>
                    </div>
                <div class="iq-card-body">
                       <div class="alert alert-danger print-error-msg" style="display:none;">
                            <ul></ul>
                        </div>
                        <form onsubmit="return false" method="post" id="settingform" class="needs-validation" novalidate name="settingform" autocomplete="false">
                            {{ csrf_field() }}
                            <input type="hidden" id="hid" name="hid" value="{{isset($setting_data) ? $setting_data->id : ''}}">
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="headerlogo">Header logo :</label>
                                </div>
                                <div class="col-sm-8">
                                   <div class="custom-file">
             
									<input type="file" class="custom-file-input file1" id="headerlogo" name="headerlogo" value="{{isset($setting_data->headerlogo) ? $setting_data->headerlogo : ''}}">
									<label class="custom-file-label" for="customFile">{{ (isset($setting_data->headerlogo)) ? $setting_data->headerlogo : '' }}</label>
								</div>
                                </div>
                                <div class="col-sm-2">
                                    @if(isset($setting_data->headerlogo))
                                    <img src="{{ asset('assets/admin/settingimage/'.$setting_data->headerlogo.'') }}" width="100px" style="border-style: solid; border-color: gray;" id ="setting_img" alt="" title="">
                                @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="footerlogo">footer logo :</label>
                                </div>
                                <div class="col-sm-8">
                                   <div class="custom-file">
									<input type="file" class="custom-file-input file2" id="footerlogo" name="footerlogo" value="{{isset($setting_data->footerlogo) ? $setting_data->footerlogo : ''}}">
									<label class="custom-file-label" for="customFile">{{ (isset($setting_data->footerlogo)) ? $setting_data->footerlogo : '' }}</label>
								</div>
                                </div>
                                <div class="col-sm-2">
                                    @if(isset($setting_data->headerlogo))
                                    <img src="{{ asset('assets/admin/settingimage/'.$setting_data->footerlogo.'') }}" width="100px" style="border-style: solid; border-color: gray;" id ="setting_img" alt="" title="">
                                @endif
                                </div>
                            </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="infoaddress">Info Address :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea id="infoaddress" placeholder="Info Address" class="form-control"  name="infoaddress" rows="3" cols="80" >{{isset($setting_data->infoaddress) ? $setting_data->infoaddress : ''}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="infoemail">Info Email :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="email" class="form-control" id="infoemail" name="infoemail"  placeholder="Enter Info Email" value="{{isset($setting_data->infoemail) ? $setting_data->infoemail : ''}}" required>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="inquiryemail">Inquiry Email :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="email" class="form-control" id="inquiryemail" name="inquiryemail"  placeholder="Enter Inquiry Email" value="{{isset($setting_data->inquiryemail) ? $setting_data->inquiryemail : ''}}" required>

                                    </div>
                                </div>
                                <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label for="infocontactnumber">Info contact Number :</label>
                                        </div>
                                        <div class="col-sm-10">
                                           <input type="text" class="form-control" id="infocontactnumber" name="infocontactnumber"  placeholder="Info Contact Number" value="{{isset($setting_data->infocontactnumber) ? $setting_data->infocontactnumber : ''}}" required>
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="footerdiscription">Footer Discription :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea id="footerdiscription" placeholder="Footer Discription" class="form-control"  name="footerdiscription" rows="3" cols="80" >{{isset($setting_data->footerdiscription) ? $setting_data->footerdiscription : ''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="facebook">Facebook :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="facebook" name="facebook"  placeholder="Facebook" value="{{isset($setting_data->facebook) ? $setting_data->facebook : ''}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="twitter">Twitter :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="twitter" name="twitter"  placeholder="Twitter" value="{{isset($setting_data->twitter) ? $setting_data->twitter : ''}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="linkedin">Linkedin :</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="linkedin" name="linkedin"  placeholder="Linked in" value="{{isset($setting_data->linkedin) ? $setting_data->linkedin : ''}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="Location Iframe">Location Iframe:</label>
                                    </div>
                                    <div class="col-sm-10">
                                       <input type="text" class="form-control" id="iframe" name="iframe"  placeholder="Location Iframe" value="{{isset($setting_data->iframe) ? $setting_data->iframe : ''}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="copyright">Copyright content :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea id="copyright" placeholder="Copyright content" class="form-control"  name="copyright" rows="2" cols="80" >{{ isset($setting_data->copyrightcontent) ? $setting_data->copyrightcontent : ''}}</textarea>
                                    </div>
                                </div>
            
                                <button type="submit" id="submitbtn" name="submitbtn" class="btn btn-primary">Submit</button>
                                <button type="submit" class="btn btn-secondary">Cancel</button>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/admin/js/setting.js')}}"></script>
<script type="text/javascript">
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
    </script>
@endsection
