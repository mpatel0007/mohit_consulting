@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Resend account activation mail')
@section('pageheader', 'Resend account activation mail')
@section('content')
    <section id="content" class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-xs-12">
                    <div class="page-login-form box">
                        <h3>
                            Resend mail
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
                            <!-- <strong>Whoops!</strong> There were some problems with your input.
                            <br /> -->
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif  

                        <form class="login-form mt-2" method="POST" action="{{ route('front_end-resend-account-active-mail') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="input-icon">
                                    <i class="lni-envelope"></i>
                                    <input type="text" class="form-control" name="email" placeholder="Email Address">
                                </div>
                            </div>
                            <button class="btn removefocus btn-common log-btn mt-3">Submit</button>
                        </form>
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
