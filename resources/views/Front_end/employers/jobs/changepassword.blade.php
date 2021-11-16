@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Change Password')
@section('pageheader', 'Change Password')
@section('content')

    <div id="content">
        <div class="container">
            <div class="row">
                @include('Front_end.candidate.ManageProfile.left_menu')
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="job-alerts-item">
                        <h3 class="alerts-title">Change Password</h3>
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
                                <strong>Whoops!</strong> There were some problems with your input.
                                <br />
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('front_end-employer-changepassword') }}" id="changepasswordForm">
                            {{ csrf_field() }}
                            <div class="form-group is-empty">
                                <label class="control-label">Old Password*</label>
                                <input class="form-control" id="oldpassword" name="oldpassword" type="password" required>
                                <span class="material-input"></span>
                            </div>
                            <div class="form-group is-empty">
                                <label class="control-label">New Password*</label>
                                <input class="form-control" id="password" name="password" type="password" required>
                                <span class="material-input"></span>
                            </div>
                            <div class="form-group is-empty">
                                <label class="control-label">Confirm Password*</label>
                                <input class="form-control"  id="confirm_password" name="confirm_password" type="password" required>
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" id="changepassword" name="changepassword" class="btn btn-primary">Save Change</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/front_end/js/employers/jobs.js') }}"></script>
@endsection
