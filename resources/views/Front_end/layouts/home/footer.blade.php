{{-- <footer> --}}
<section class="footer-Content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="widget">
                        <div class="footer-logo"><img src="{{ asset('assets/theme/front_end/img/logo-footer.png') }}" alt=""></div>
                        <div class="textwidget">
                            <?php //echo Helper::setting() ?>
                            <p>{{isset(Helper::setting()->footerdiscription) ? Helper::setting()->footerdiscription : ''}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4 col-xs-12">
                    <div class="widget">
                        <h3 class="block-title">Quick Links</h3>
                        <ul class="menu">
                            <li><a href="{{url('cms/about-us')}}">About Us</a></li>
                            <li><a href="{{url('cms/support')}}">Support</a></li>
                            {{-- <li><a href="#">License</a></li> --}}
                            <li><a href="{{route ( 'front_end-contact' ) }}">Contact</a></li>
                        </ul>
                        <ul class="menu">
                            <li><a href="{{url('cms/terms-conditions')}}">Terms & Conditions</a></li>
                            <li><a href="{{url('cms/privacy')}}">Privacy</a></li>
                            <!-- <li><a href="#">Refferal Terms</a></li>
                            <li><a href="#">Product License</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-xs-12">
                    <div class="widget">
                        <h3 class="block-title">Connect with us</h3>
                        <!-- <p>Sed consequat sapien faus quam bibendum convallis.</p> -->
                        <!-- <form method="post" id="subscribe-form" name="subscribe-form" class="validate">
                            <div class="form-group is-empty">
                                <input type="email" value="" name="Email" class="form-control" id="EMAIL"
                                    placeholder="Enter Email..." required="">
                                <button type="submit" name="subscribe" id="subscribes" class="btn removefocus btn-common sub-btn"><i
                                        class="lni-envelope"></i></button>
                                <div class="clearfix"></div>
                            </div>
                        </form> -->
                        <ul class="mt-3 footer-social">
                            <li><a class="facebook" href="{{isset(Helper::setting()->facebook) ? Helper::setting()->facebook : ''}}" target="_blank"><i class="lni-facebook-filled"></i></a></li>
                            <li><a class="twitter" href="{{isset(Helper::setting()->twitter) ? Helper::setting()->twitter : ''}}" target="_blank"><i class="lni-twitter-filled"></i></a></li>
                            <li><a class="linkedin" href="{{isset(Helper::setting()->linkedin) ? Helper::setting()->linkedin : ''}}" target="_blank"><i class="lni-linkedin-fill"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{-- </footer> --}}
    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="site-info text-center">
                        {{-- <p>Designed and Developed by <a href="https://uideck.com/" rel="nofollow">UIdeck</a></p> --}}
                        <p>{{isset(Helper::setting()->copyrightcontent) ? Helper::setting()->copyrightcontent : '' }}</p> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="back-to-top">
        <i class="lni-arrow-up"></i>
    </a>
    
    <script src="{{ asset('assets/theme/front_end/js/popper.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/theme/front_end/js/color-switcher.js') }}"></script> -->
    <script src="{{ asset('assets/theme/front_end/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/theme/front_end/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('assets/theme/front_end/js/jquery.counterup.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/theme/front_end/js/waypoints.min.js') }}"></script> --}}
    <script src="{{ asset('assets/theme/front_end/js/form-validator.min.js') }}"></script>
    <script src="{{ asset('assets/theme/front_end/js/contact-form-script.js') }}"></script>
    <script src="{{ asset('assets/theme/front_end/js/main.js') }}"></script>
