@extends('Admin.layouts.login.index')
@section('title', 'Admin Login')
@section('admincontent')

      <!-- loader Start -->
      {{-- <div id="loading"></div> --}}
    <!-- loader END -->
    
      <section class="sign-in-page">
          <div class="container p-0">
              <div class="row no-gutters">
                  <div class="col-sm-12 align-self-center">
                      <div class="sign-in-from bg-white">
                          <h1 class="mb-0">Sign in</h1>
                          <p>Enter your email address and password to access admin panel.</p>
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
                                  <strong>Whoops!</strong>Some problems with your input.
                                  <br>
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif
                              <form method="POST" action="{{ route('admin_login_proccess') }}" class="mt-4">
                                @csrf   
                                {{-- <div class="form-group">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                
                                    <div class="">
                                        <input id="email" type="email" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>

                                    <div class="">
                                        <input id="password" type="password" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                 <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                        <div class="form-check">
                                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>                
                                            <label class="custom-control-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div> --}}
                                {{-- <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">Don't have an account? <a href="{{ route('register') }}">Sign up</a></span>
                                </div> --}}
                                <div class="form-group">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <div class="input-icon">
                                        <i class="lni-user"></i>
                                        <input type="email" id="email" class="form-control" name="email"
                                            placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <div class="input-icon">
                                        <i class="lni-lock"></i>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Password">
                                    </div>
                                </div>
                                <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                        <div class="form-check">
                                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>                
                                            <label class="custom-control-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </div>
                                {{-- <div class="float-right">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div> --}}
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </section>
@endsection