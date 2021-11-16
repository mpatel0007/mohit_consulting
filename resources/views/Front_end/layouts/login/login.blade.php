@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Login')
@section('pageheader', 'Login')
@section('content')

    <section id="content" class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-xs-12">
                    <div class="page-login-form box">
                        <h3>
                            Login
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
                       <!--  <ul class="nav nav-tabs">
                            <li ><a class="btn btn-lg active onfocus ml-3 mr-2 mb-2 btn-common" data-toggle="tab"
                                    href="#candidate"
                                    onclick="$('#candidate').removeClass('d-none'); $('#Employers').addClass('d-none');">Candidate</a>
                            </li>
                            <li><a data-toggle="tab" href="#Employers" class="btn btn-lg onfocus  mb-2 ml-2 btn-common"
                                    onclick="$('#Employers').removeClass('d-none'); $('#candidate').addClass('d-none');">Employers</a>
                            </li>
                        </ul> -->
                        <div  id="candidate">
                            <form class="login-form mt-2" method="POST" action="{{ route('front_end-signin-add') }}"
                                id="candidateForm">
                                {{ csrf_field() }}
                                <input type="hidden" id="userType" name="userType" value="candidate" required>
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="text" id="email" class="form-control" name="email"
                                            placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Keep Me Signed In</label>
                                </div>
                                <button class="btn btn-common log-btn">Submit</button>
                            </form>
                        </div>

                        {{-- <div id="Employers" class="tab-pane fade d-none">
                            <form class="login-form mt-2" method="POST" action="{{ route('front_end-signin-add') }}"
                                id="EmployersForm">
                                {{ csrf_field() }}
                                <input type="hidden" id="userType" name="userType" value="employers">
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="text" id="email" class="form-control" name="email"
                                            placeholder="Employers Email" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Employers Password" required>
                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Keep Me Signed In</label>
                                </div>
                                <button class="btn btn-common log-btn">Submit</button>
                            </form>
                        </div> --}}
                        <ul class="form-links">
                            <li class="text-center"><a href="{{ route('front_end-signup') }}">Don't have an account ?</a></li>
                        </ul>
                        {{-- <ul class="form-links">
                            <li class="text-center"><a href="{{ route('front_end-resend-account-active-view') }}">Resend Account Activation Mail ?</a></li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footersection')
    {{-- <script type="text/javascript" src="{{ asset('assets/admin/js/degreetype.js') }}"></script> --}}
@endsection
