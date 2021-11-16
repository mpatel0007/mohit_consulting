@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Jobs Details')
@section('content')

    {{-- <div class="page-header">
        <div class="container"> --}}
            @section('pageheader_content')
            <div class="row">
                <div class="col-lg-8 col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper">
                        <div class="content" style="padding-left:0px;">
                            <h3 class="product-title">{{ ucfirst($job_details->jobtitle)}} </h3>
                            <p class="brand">{{$job_details->companyname}}.</p>
                            <div class="tags">
                                <p><span><i class="lni-map-marker"></i>{{  $job_details->country }} / {{  $job_details->state }} / 
                                    @php $cityy = ''; @endphp
                                    @foreach ($job_city as $k => $city)
                                        @php
                                            $cityy .= $city->city;
                                        @endphp
                        
                                        @if($k != (count($job_city)-1))
                                            @php
                                            $cityy .= " & ";
                                            @endphp
                                        @endif
                                    @endforeach
                                    {{  $cityy }}</p></span>
                                <p><span><i class="lni-calendar"></i>
                                    @php
                                        $oldDate = $job_details->created_at;
                                        $newDate = date("F j, Y", strtotime($oldDate));  
                                    @endphp
                                    {{ $newDate }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="month-price">
                        <span class="year">{{isset($job_details->salaryperiod) ? ucfirst($job_details->salaryperiod) : ''}}</span>
                        {{-- @php
                            setlocale(LC_MONETARY,"en_US");
                            $salaryfrom =  number_format($job_details->salaryfrom,2);
                        @endphp --}}
                        <div class="price">${{ isset($job_details->salary) ? $job_details->salary : ''}}</div>
                    </div>
                </div>
            </div>
@endsection
        {{-- </div>
    </div> --}}


    <section class="job-detail section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="content-area">
                        <h4>Job Description</h4>
                        <p> {!! $job_details->jobdescription !!}</p>
                        
                        @if($job_skill->count() > 0)
                        <h5>What You Need for this Position</h5>
                        <ul>
                            @foreach ($job_skill as $k => $jskill)
                                    <p>- {{$jskill->jobskill}}</p>
                            @endforeach
                        </ul>
                        @endif
                        <h5>Apply Now</h5>
                        <p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor,
                            nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate
                            cursus a sit amet mauris.</p>
                            @php
                                if($find_candidate == '' && $find_candidate == null){
                                    $button_text = 'Apply Now';
                                }else{
                                    $button_text = 'Applied';
                                }
                            @endphp

                        <?php if (Auth::guard('candidate')->check()) { ?>
                                <a href = "javascript:void(0)" id="apply_job"  data-id ="{{$job_details->id}}" class="btn removefocus btn-common" disabled>{{ csrf_field() }}{{$button_text}}</a></td>
                         <?php } else { ?>
                                <a href= "{{ route('front_end-signup') }}" class=" btn removefocus btn-common">Apply Now</a></td>
                         <?php } ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-xs-12">
                    <div class="sideber">
                        <div class="widghet">
                            <h3>Job Location</h3>
                            <div class="maps">
                                <div id="map" class="map-full">
                                    {!!$job_details->googlemap!!}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="widghet">
                            <h3>Share This Job</h3>
                            <div class="share-job">
                                <form method="post" class="subscribe-form">
                                    <div class="form-group">
                                        <input type="email" name="Email" class="form-control" placeholder="https://joburl.com" required="">
                                        <button type="submit" name="subscribe" class="btn removefocus btn-common sub-btn"><i
                                                class="lni-files"></i></button>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                                <ul class="mt-4 footer-social">
                                    <li><a class="facebook" href="#"><i class="lni-facebook-filled"></i></a></li>
                                    <li><a class="twitter" href="#"><i class="lni-twitter-filled"></i></a></li>
                                    <li><a class="linkedin" href="#"><i class="lni-linkedin-fill"></i></a></li>
                                    <li><a class="google-plus" href="#"><i class="lni-google-plus"></i></a></li>
                                </ul>
                                <div class="meta-tag">
                                    <span class="meta-part"><a href="#"><i class="lni-star"></i> Write a Review</a></span>
                                    <span class="meta-part"><a href="#"><i class="lni-warning"></i> Reports</a></span>
                                    <span class="meta-part"><a href="#"><i class="lni-share"></i> Share</a></span>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/findjobs.js') }}"></script>
@endsection
