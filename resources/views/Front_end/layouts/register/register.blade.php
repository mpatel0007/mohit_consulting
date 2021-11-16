{{-- @extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Register')
@section('pageheader', 'Create Your account')
@section('content')
<section id="content" class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-xs-12">
                <div class="page-login-form box">
                    <h3>
                        Create Your account
                    </h3>
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
                    @if (count($errors))
                    <div class="alert alert-danger">
                        <!-- <strong>Whoops!</strong> There were some problems with your input.
                        <br /> -->
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul>
                        </ul>
                    </div>
                    <ul class="nav nav-tabs">
                        <li><a class="btn btn-lg active onfocus btn-common ml-3 mr-2 mb-2" data-toggle="tab" href="#candidate" onclick="$('#candidate').removeClass('d-none'); $('#Employers').addClass('d-none');">Candidate</a></li>
                        <li><a data-toggle="tab" href="#Employers" class="btn btn-lg onfocus btn-common ml-2 mb-2" onclick="$('#Employers').removeClass('d-none'); $('#candidate').addClass('d-none');">Employers</a></li>
                    </ul>
                    <div id="candidate">
                        <form method="POST" class="login-form mt-2" action="{{ route('front_end-signup-add') }}" id="candidateForm">
                            {{ csrf_field() }}
                            <input type="hidden" id="userType" name="userType" value="candidate">
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-user"></i>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Candidate Name">
                                </div>
                            </div>
                         
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Candidate Email Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-lock"></i>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Candidate Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-unlock"></i>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Retype Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                   <div class="col-md-1">&nbsp;</div>    
                                    <div class="col-md-11">
                                        @if(config('services.recaptcha.key'))
                                            <div class="g-recaptcha"
                                                data-sitekey="{{config('services.recaptcha.key')}}">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                           
                            <button class="btn btn-common log-btn mt-3" id="register">Register</button>
                        </form>
                    </div>
                    <div id="Employers" class="tab-pane fade d-none">
                        <form method="POST" class="login-form mt-2" action="{{ route('front_end-signup-add') }}">
                            {{ csrf_field() }}
                            <input type="hidden" id="userType" name="userType" value="employers">
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-user"></i>
                                    <input type="text" class="form-control" name="employersname" id="employersname" placeholder="Employers Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="email" class="form-control" name="companyemail" id="companyemail" placeholder="Employers Email Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-lock"></i>
                                    <input type="password" class="form-control" id="password" name="password" placeholder=" Employers Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-unlock"></i>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Retype Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                   <div class="col-md-1">&nbsp;</div>    
                                    <div class="col-md-11">
                                        @if(config('services.recaptcha.key'))
                                            <div class="g-recaptcha"
                                                data-sitekey="{{config('services.recaptcha.key')}}">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-common log-btn mt-3" id="register">Register</button>
                        </form>
                    </div>
                    <p class="text-center">Already have an account?<a href="{{ route('front_end-signin') }}"> Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/front_end/js/signup.js')}}"></script>
@endsection --}}


@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Register')
@section('pageheader', 'Create Your account')
@section('content')
<section id="content" class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 col-xs-12">
                <div class="page-login-form box">
                    <h3>
                        Create Your account
                    </h3>
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
                    @if (count($errors))
                    <div class="alert alert-danger">
                        <!-- <strong>Whoops!</strong> There were some problems with your input.
                        <br /> -->
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="alert alert-danger print-error-msg" style="display:none;">
                        <ul>
                        </ul>
                    </div>
                        <form method="POST" class="login-form mt-2" action="{{ route('front_end-signup-add') }}" id="candidateForm">
                            {{ csrf_field() }}
                            <input type="hidden" id="userType" name="userType" value="candidate">
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-user"></i>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-lock"></i>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-unlock"></i>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Retype Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                   <div class="col-md-1">&nbsp;</div>    
                                    <div class="col-md-11">
                                        @if(config('services.recaptcha.key'))
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-common log-btn mt-3" id="register">Register</button>
                        </form>
                    <p class="text-center">Already have an account?<a href="{{ route('front_end-signin') }}"> Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footersection')
{{-- <script type="text/javascript" src="{{ asset('assets/front_end/js/signup.js')}}"></script> --}}
@endsection