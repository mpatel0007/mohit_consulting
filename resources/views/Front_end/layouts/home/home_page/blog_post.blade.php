<section id="blog" class="section">

    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Blog Post</h2>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit ellentesque dignissim quam et <br> metus effici
                turac fringilla lorem facilisis.</p> -->
        </div>   
        <div class="row">
            <?php if(!empty($activeBlogs)) { 
                foreach($activeBlogs as $key => $value) {
            ?>
            <div class="col-lg-4 col-md-6 col-xs-12 blog-item">
                <div class="blog-item-wrapper">
                    <div class="blog-item-img">
                        <a href="{{ route('front_end-blog_details', ['blogId' => $value->id]) }}">
                            <img src="{{ asset('assets/admin/blogs/'.$value->image.'') }}" alt="">
                        </a>
                    </div>
                    <div class="blog-item-text">
                        <h3><a href="javascript:void(0);"><?php echo $value->title; ?></a></h3>
                        <!-- <p><?php echo $value->description; ?></p> -->
                    </div>    
                    <a class="readmore" href="{{ route('front_end-blog_details', ['blogId' => $value->id]) }}">View Blog</a>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>
</section>
