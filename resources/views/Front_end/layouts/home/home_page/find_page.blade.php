<style>
    .btn-label {
        position: relative;
        left: -30px;
        display: inline-block;
        padding: 6px 12px;
        color: #26ae61;
        border-radius: 3px 0 0 3px;
    }

    .btn-labeled {
        padding-top: 0;
        padding-bottom: 0;
    }

    .btn {
        /* margin-bottom: 10px; */
        margin-top: 10px !important;
        margin-right:0px !important; 
    }

</style>
<div class="container">
    <div class="row space-100">
        <div class="col-lg-7 col-md-12 col-xs-12">
            <div class="contents">
                <h2 class="head-title">Find the <br> job that fits your life</h2>
                <p>Aliquam vestibulum cursus felis. In iaculis iaculis sapien ac condimentum. Vestibulum congue
                    posuere lacus, id tincidunt nisi porta sit amet. Suspendisse et sapien varius, pellentesque dui
                    non.</p>
                @if (!Auth::guard('employers')->check())
                    <div class="job-search-form">
                        <form id="find_jobs_form" name="find_jobs_form">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-xs-12">
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="search_jobs" name="search_jobs"
                                            value="{{ isset($home_search) ? $home_search : '' }}"
                                            placeholder="Job Title or Company Name">
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-xs-12">
                                    <div class="form-group">
                                        <div class="search-category-container">
                                            <label class="styled-select">
                                                <select class="form-control" id="country" name="country" required>
                                                    <option class="custom-select" value="">Select Country</option>
                                                    @if (isset($country))
                                                        @foreach ($country as $country)
                                                            <option class="custom-select" value='{{ $country->id }}'
                                                                <?php if (isset($home_country)) {
                                                                    if ($home_country == $country->id) {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>{{ $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </label>
                                        </div>
                                        <i class="lni-map-marker"></i>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-xs-12">
                                    <button type="button" id="find_jobs" name="find_jobs" class="button"><i class="lni-search"></i></button>
                                </div>
                            </div>
                            {{-- ++++++++++++++++++++++++ --}}
                            <div class="row">
                                <h6 style="margin: 5px 0px 0px 27px; color:black">Popular Search</h6>
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                    @if (isset($popularSearch))
                                        @foreach ($popularSearch as $key => $value)
                                             <button type="button" class="btn btn-labeled popularSearchBtn" data-title="<?php echo isset($value->popular_search) ? $value->popular_search : ''?>" data-id="<?php echo isset($value->id) ? $value->id : ''?>" style="background:#d6d5d561; color:#2d2c2c;">
                                                <span class="btn-label"><i class="fa fa-search" aria-hidden="true"></i></span><span style="margin-left: -30px;"><?php echo isset($value->popular_search) ? $value->popular_search : ''?></span></button>          
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            {{-- +++++++++++++++++++++++++++++++ --}}
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-xs-12">
            <div class="intro-img">
                <img src="{{ asset('assets/theme/front_end/img/intro.png') }}" alt="">
            </div>
        </div>
    </div>
</div>

{{-- <section class="job-browse section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
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
                    </div>
                    @if (!Auth::guard('employers')->check())
                    <div id="jobs_search" class="job-listings">
                    </div>
                    @endif
                </div>
            </div>
    </div>
</section> --}}

{{-- @section('footersection') --}}
<script type="text/javascript" src="{{ asset('assets/front_end/js/home/findjobs.js') }}"></script>
{{-- @endsection --}}
