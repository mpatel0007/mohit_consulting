@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'New Password')
@section('pageheader', ' Enter Your New password')
@section('content')
    <section id="content" class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-xs-12">
                    <div class="page-login-form box">
                        <h3>
                            Set Your New password
                        </h3>
                        @if ( isset( $success ) )
                        <div class="alert alert-success">
                            <ul>
                                <li>{{ $success }}</li>
                                </ul>
                            </div>
                        @endif
                        @if ( isset( $error ) )
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ $error }}</li>
                                </ul>
                            </div>
                        @endif
                        @if (count($errors))
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.
                            <br />
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form class="login-form" method="POST" action="{{ route('front_end-set-new-password') }}">
                            {{ csrf_field() }}
                            <input type="hidden" id="newpasswordtoken" name="newpasswordtoken" value="{{$newpasswordtoken}}">
                            <input type="hidden" id="newpasswordhid" name="newpasswordhid" value="{{$newpasswordhid}}">
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter New Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter Re-enter Password">
                                </div>
                            </div>
                            <button class="btn removefocus btn-common log-btn mt-3">Submit</button>
                            <p class="text-center">Login ?<a href="{{ route('front_end-signin') }}"> Sign In</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/admin/js/degreetype.js')}}"></script>
@endsection
