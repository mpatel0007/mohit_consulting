<div id="browse-jobs" class="section bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="text-wrapper">
                    <div>
                        <h3><?php echo count($totalJobs); ?>+ Browse Jobs</h3>
                        <p>Search all the open positions on the web. Get your own personalized salary estimate. Read
                            reviews on over <?php echo count($activeCompanies); ?> companies worldwide. The right job is out there.</p>
                        <a class="btn removefocus btn-common" href="{{route('front_end-find-jobs-view')}}">Search jobs</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="img-thumb">
                    <img class="img-fluid" src="{{ asset('assets/front_end/img/search.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
