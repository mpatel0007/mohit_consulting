@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Forgot Password')
@section('pageheader', 'Forgot Your password')
@section('content')
    <section id="content" class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-xs-12">
                    <div class="page-login-form box">
                        <h3>
                            Forgot Your password
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
                        {{-- <ul class="nav nav-tabs">
                            <li class="active"><a class="btn btn-lg onfocus ml-3 mr-2 mb-2 removefocus btn-common" data-toggle="tab" href="#candidate" onclick="$('#candidate').removeClass('d-none'); $('#Employers').addClass('d-none');">Candidate</a></li>
                            <li><a data-toggle="tab" href="#Employers" class="btn btn-lg onfocus ml-2 mb-2 removefocus btn-common" onclick="$('#Employers').removeClass('d-none'); $('#candidate').addClass('d-none');">Employers</a></li>
                        </ul> --}}
                    {{-- <div id="candidate"> --}}
                        <form class="login-form mt-2" method="POST" action="{{ route('front_end-change-password') }}">
                            {{ csrf_field() }}
                            <input type="hidden" id="userType" name="userType" value="candidate">
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="text" class="form-control" name="email" placeholder="Candidate Email Address">
                                </div>
                            </div>
                            <button class="btn removefocus btn-common log-btn mt-3">Submit</button>
                        </form>
                    {{-- </div> --}}
                    {{-- <div id="Employers" class="tab-pane fade d-none">
                        <form class="login-form mt-2" method="POST" action="{{ route('front_end-change-password') }}">
                            {{ csrf_field() }}
                            <input type="hidden" id="userType" name="userType" value="employers">
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="text" class="form-control" name="email" placeholder="Employers Email Address">
                                </div>
                            </div>
                            <button class="btn removefocus btn-common  log-btn mt-3">Submit</button>
                        </form>
                    </div> --}}
                        <p class="text-center">Login ?<a href="{{ route('front_end-signin') }}"> Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/admin/js/degreetype.js')}}"></script>
@endsection
