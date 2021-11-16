@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Contact')
@section('pageheader', 'Contact')
@section('content')

<section id="contact" class="section">
<div id="loader"></div>
    <div class="contact-form">
        <div class="container">
            <div class="row contact-form-area">
                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class="contact-block">
                        <div class="alert alert-danger print-error-msg" style="display:none;">
                            <ul></ul>
                        </div>
                        <h2>Contact Form</h2>
                        <form id="contactForm" name="contactForm" method="post" onsubmit="return false">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                                        required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Email" id="email" class="form-control"
                                        name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Subject" id="msg_subject" name="msg_subject"
                                        class="form-control" required>
                                    </div>
                                </div>          
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="message" placeholder="Your Message"
                                        name="message" rows="5" required></textarea>
                                    </div>
                                    <div class="submit-button">
                                        <button class="btn btn-common" id="submitbtn" type="submit">Send
                                        Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-sm-12">
                    <div class="contact-right-area wow fadeIn">
                        <h2>Contact Address</h2>
                        <div class="contact-info">
                            <div class="single-contact">
                                <div class="contact-icon">
                                    <i class="lni-map-marker"></i>
                                </div>
                                <p><address>{{ (isset(Helper::setting()->infoaddress)) ? Helper::setting()->infoaddress : '' }}</address></p>
                            </div>
                            <div class="single-contact">
                                <div class="contact-icon">
                                    <i class="lni-envelope"></i>
                                </div>
                                {{-- <p><b>Customer Support:</b> <a href="mailto:{{isset(Helper::setting()->inquiryemail) ? Helper::setting()->inquiryemail : ''}}"><span class="__cf_email__">{{isset(Helper::setting()->inquiryemail) ? Helper::setting()->inquiryemail : ''}}<br></span></a></p> --}}
                                <p><b>Customer Support:</b> <a href="mailto:{{isset(Helper::setting()->inquiryemail) ? Helper::setting()->inquiryemail : ''}}"><span class="__cf_email__">{{isset(Helper::setting()->inquiryemail) ? Helper::setting()->inquiryemail : ''}}<br></span></a></p>
                                <p><b>Technical Support:</b> <a href="mailto:{{isset(Helper::setting()->infoemail) ? Helper::setting()->infoemail : ''}}"><span class="__cf_email__">{{isset(Helper::setting()->infoemail) ? Helper::setting()->infoemail : ''}}</span></a></p>
                            </div>
                            <div class="single-contact">
                                <div class="contact-icon">
                                    <i class="lni-phone-handset"></i>
                                </div>
                                <p><b>Main Office:</b> {{ (isset(Helper::setting()->infocontactnumber)) ? Helper::setting()->infocontactnumber : '' }}</p>
                                <p><b>Customer Support:</b> {{ (isset(Helper::setting()->infocontactnumber)) ? Helper::setting()->infocontactnumber : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <!-- <div id="conatiner-map"> -->
                        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13004080.414077152!2d-104.65693512785852!3d37.27559283318413!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited+States!5e0!3m2!1sen!2sin!4v1530855407925" allowfullscreen=""></iframe> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
    @section('footersection')
    <script type="text/javascript" src="{{ asset('assets/front_end/js/pages/contact.js') }}"></script>
    @endsection
