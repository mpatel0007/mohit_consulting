@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Documents')
@section('pageheader', 'Documents')
@section('content')

    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-lg-9 col-md-9 col-xs-12">
                    <div class="job-alerts-item candidates">
                        <h3 class="alerts-title">Documents</h3>
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

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- {{ route('front_end-candidate-resume-upload') }} --}}
                        <form onsubmit="return false" method="post" id="resumeForm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <!-- <div class="col-sm-2">
                                    <label for="strretaddress">Resume :</label>
                                </div> -->
                                <div class="col-md-7">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="upload_resume" name="upload_resume">
                                        <label class="custom-file-label" for="customFile">Resume</label>
                                    </div>
                                </div>
                                {{-- <div class="col-md-2">
                                    <button type="submit" class="btn btn-common removefocus">Upload</button>
                                </div> --}}
                                <div class="col-md-3">
                                    <a href="{{ route('front_end-candidate-resume-download') }}" class="btn btn-info mb-4"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                                </div>
                            </div>
                        </form>
                            
                        {{-- front_end-candidate-coverletter-upload --}}
                        <form onsubmit="return false" method="post" id="coverletterForm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <!-- <div class="col-sm-2">
                                    <label for="strretaddress">Cover Letter :</label>
                                </div> -->
                                <div class="col-md-7">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="cover_letter" name="cover_letter">
                                        <label class="custom-file-label" for="customFile">Cover Letter</label>
                                    </div>
                                </div> 
                                {{-- <div class="col-md-2">
                                    <button type="submit" class="btn btn-common removefocus">Upload</button>
                                </div> --}}
                                <div class="col-sm-3">
                                    <a href="{{ route('front_end-candidate-coverletter-download') }}" class="btn btn-info mb-4"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                                </div>
                            </div>
                        </form>
                            
                        <form onsubmit="return false" method="post" id="referencesForm" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <!-- <div class="col-sm-2">
                                    <label for="strretaddress">References :</label>
                                </div> -->
                                <div class="col-md-7">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="upload_references" name="upload_references">
                                        <label class="custom-file-label" for="customFile">References</label>
                                    </div>
                                </div>
                                {{-- <div class="col-md-2">
                                    <button type="submit" class="btn btn-common removefocus">Upload</button>
                                </div> --}}
                                <div>
                                    <a href="{{ route('front_end-candidate-references-download') }}" class="btn btn-info ml-3 mb-4"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                                </div>
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/manageprofile.js') }}"></script>
@endsection
