@extends('Admin.layouts.dashbord.index')
@section('admindashboardtitle', 'Add Blog')
@section('pagetitle', 'Blogs')
@section('pagesubtitle', 'Blogs')
@section('subtitle', 'Add Blog')
@section('admincontent')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="fa fa-cog" aria-hidden="true"></i> Add Blog</h4>
                        </div>  
                    </div>
                <div class="iq-card-body">
                       <div class="alert alert-danger print-error-msg" style="display:none;">
                            <ul></ul>
                        </div>
                        <form onsubmit="return false" method="post" id="addBlogform" class="needs-validation" novalidate name="addBlogform" autocomplete="false">
                            {{ csrf_field() }}
                            <input type="hidden" id="hid" name="hid" value="{{isset($blogsData->id) ? $blogsData->id : ''}}">
                            
                            <img src="" id="blog-img-tag" width="100px" />
                            @if(isset($blogsData->image))  
                            <img src="{{ asset('assets/admin/blogs/'.$blogsData->image.'') }}" width="100px" id ="edit_img" alt="" title="">    
                            @endif
                            
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="companylog">Image :</label>
                                </div>
                                <div class="col-sm-10">
                                   <div class="custom-file">
									    <input type="file" class="custom-file-input" id="bloglog" name="bloglog" value="{{isset($blogsData->image) ? $blogsData->image : ''}}">
									    <label class="custom-file-label" for="customFile">Choose Photo</label>
								    </div>
                                </div>
                            </div>
                                <div class="form-group row">
                                        <div class="col-sm-2">
                                            <label for="companyname">Title :</label>
                                        </div>
                                        <div class="col-sm-10">
                                           <input type="text" class="form-control" id="title" name="title"  placeholder="Title" value="{{isset($blogsData->title) ? $blogsData->title : ''}}" required>
                                        </div>
                                </div>
                              

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="companydetail">Description :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <textarea id="description" class="form-control" class="editor" name="description" rows="10" cols="80" >{{isset($blogsData->description) ? $blogsData->description : ''}}</textarea>
                                    </div>
                                </div>    

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label for="status">Status:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="status" name="status" value="{{isset($blogsData->status) ? $blogsData->status : ''}}">
                                            <option value="1" <?php if(isset($blogsData->status)){ if($blogsData->status == '1'){echo 'selected';}} ?>> Active</option>
                                            <option value="0" <?php if(isset($blogsData->status)){ if($blogsData->status == '0'){echo 'selected';}}?>> Inactive</option>
                                        </select>
                                    </div>
                                </div> 
                                <button type="submit" id="addblog" name="addblog" class="btn btn-primary">Submit</button>
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
<script type="text/javascript" src="{{ asset('assets/admin/js/blogs.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // admin.cms.initialize();
        CKEDITOR.replace('description', { customConfig: "{{ asset('assets/admin/custom_config.js')}}"});
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraAllowedContent ﻿= 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
    });
</script>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();    
            reader.onload = function (e) {
                $('#blog-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#bloglog").change(function(){
        readURL(this);
    });
    </script>
@endsection
