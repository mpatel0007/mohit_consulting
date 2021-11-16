<section class="category section bg-gray">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Browse Categories</h2>
            <p>Most popular categories of portal, sorted by popularity</p>
        </div>

        <div class="row">
            <?php if(!empty($ActivehomeCategory)) { 
                        $count = 0;   
                        foreach($ActivehomeCategory as $key => $Category) {
            ?>
            
            <div class="col-lg-3 col-md-6 col-xs-12 f-category">
                    <a href="{{ route('front_end-find-jobs-view', ['Category_id' => $Category['id']]) }}">
                    {{-- <a href="{{ route('front_end-find-jobs', ['Category_id' => $Category['id']]) }}"> --}}

                    <div class="icon bg-color-<?php echo $count + 1; ?>">
                        <i class="<?php echo $homeCategoryIcon[$count]; ?>"></i>
                    </div>
                    <h3>{{isset($Category['industry_name']) ? $Category['industry_name'] : ''}}</h3> 
                    {{-- <p>({{$Category['count']}} jobs)</p> --}}
                </a>
            </div>
            <?php $count++; } } ?>
        </div>
    </div>
</section>



