@extends('Admin.layouts.login.index')
@section('title', 'Register Page')
@section('content')
{{-- <div id="loading">   
</div> --}}
<!-- loader END -->
  <!-- Sign in Start -->
  <section class="sign-in-page">
      <div class="container p-0">
          <div class="row no-gutters">
              <div class="col-sm-12 align-self-center">
                  <div class="sign-in-from bg-white">
                      <h1 class="mb-0">Sign Up</h1>
                      <p>fill up details to sign up.</p>
                      <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Full Name') }}</label>

                            <div>
                                <input id="name" type="text" placeholder="Your Full Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <div>
                                <input id="email" type="email" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <div>
                                <input id="password" type="password" placeholder="Enter password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <div>
                                <input id="password-confirm" type="password" placeholder="Enter confirm password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                            <div class="float-right">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Sign Up') }}
                                </button>
                            </div>

                          <div class="sign-info" style="margin-top : 60px">
                              <span class="dark-color d-inline-block line-height-2">Already Have Account ? <a href="{{ route('login') }}">Log In</a></span>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>
@endsection