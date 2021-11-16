<section id="latest-jobs" class="section bg-gray">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Latest Jobs</h2>
        </div>
        <div class="row">
            <?php if(count($activeJobs) > 0) { 
                        $count = 0;
                        foreach($activeJobs as $key => $value) {    
                            if($count == 6) {
                                break;
                            }
            ?>    
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="jobs-latest">
                    <div class="content">
                        <h3><a href="{{ route('front_end-job_details_view', ['job_id' => $value->id]) }}">{{ucfirst($value->jobtitle)}}</a></h3>
                        <p class="brand">{{ucfirst($value->companyname)}}</p>
                        <div class="tags">
                            <span><i class="lni-map-marker"></i> {{ucfirst($value->country_name)}}</span>
                            <!-- <span><i class="lni-user"></i>John Smith</span> -->
                        </div>
                        <?php 
                        $jobType = explode(',',$value->jobtype);
                        if(!empty($jobType)) {
                            foreach($jobType as $jobKey => $jobValue) {
                        ?>
                        <span class="full-time">{{ucfirst($jobValue)}}</span>
                        <?php } } ?>
                    </div>
                    <div class="save-icon">
                        @if (Auth::guard('candidate')->check())
                        <button id="make_Favourite" type="button">
                                <p><i class="fa fa-heart fa-2x favourite make_favourite {{$value->id}} {{isset($value->wishlist_id) ? 'text-success'  : '' }}" {{isset($value->wishlist_id)  ? 'data-status = 1'  : 'data-status = 0' }}  aria-hidden="true" id="favourite" data-id="{{$value->id}}"></i></p>
                        </button>
                        @endif
                        @if(!Auth::guard('employers')->user() && !Auth::guard('candidate')->user())
                                <a href='{{ route('front_end-signup') }}'><p><i class="fa fa-heart fa-2x" aria-hidden="true" id="favourite"></i></p></a>
                         @endif
                         @if (Auth::guard('employers')->check())
                                <a href='javascript:void(0)'><p><i class="fa fa-heart fa-2x" style="cursor: not-allowed;" aria-hidden="true" id="favourite"></i></p></a>
                         @endif
                    </div>
                </div>
            </div>
            <?php } } ?>
            <div class="col-12 text-center mt-4">
                <a href="{{route('front_end-find-jobs-view')}}" class="btn removefocus btn-common">Browse All Jobs</a>
            </div>
        </div>
    </div>
</section>
@section('footersection')
<script type="text/javascript" src="{{ asset('assets/front_end/js/home/findjobs.js') }}"></script>
@endsection
