@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Packages')
@section('pageheader', 'Packages')
@section('content')

<div id="content">
    <div class="container">
        <div class="row">
            <?php if($type == "1") { ?>
                @include('Front_end.candidate.ManageProfile.left_menu')
            <?php } else { ?>
                @include('Front_end.employers.jobs.leftside_menu')
            <?php } ?> 
   
            <?php     
            $freePackageText = 'Subscribed';
            $freePackageLink = 'javascript:void(0);';
            $onClick = '';
            if($packageID>0) { 
                $freePackageText = 'Downgrade';    
                $freePackageLink = 'javascript:void(0);';
                if($type == "1") {
                    $onClick = "downgrade('downgradepackage');";    
                } else {
                    $onClick = "downgrade('employeer-downgradepackage');";    
                }
            } ?>               


            <div class="col-lg-9 col-md-9 col-xs-12">
                <div class="job-alerts-item candidates">
                    <!-- <h3 class="alerts-title">Packages</h3> -->

                    <?php  if($msg == '1') { ?>    
                        <div class="alert alert-danger text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>You need to subscribe to access this package</p>
                        </div>        
                    <?php } ?>    

                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif    

                    <?php if($nextRenewalDate != '') { ?>
                        <h5 class="text-center">Renewal Date : <?php echo date("d F Y",strtotime($nextRenewalDate."+1 day")); ?></h5>
                    <?php } ?>    

                    <div class="row pricing-tables">  
                        <div class="col-lg-4 col-md-4 col-xs-12 mb-2">
                            <div class="pricing-table pricing-active border-color-red">
                                <div class="pricing-details">
                                    <div class="icon">
                                        <i class="lni-briefcase"></i>
                                    </div>
                                    <h2>Free</h2>
                                    <ul>   
                                        <li>Manage Profile</li>
                                        <li>Favourite Job</li>
                                        <li>Document Upload</li>
                                        <li>Apply Job</li>
                                    </ul>
                                    <div class="price"><span>$</span>0<span>/Month</span></div>
                                </div>
                                <div class="plan-button">
                                    <a href="<?php echo $freePackageLink; ?>" class="btn btn-border" onclick="<?php echo $onClick; ?>">
                                        <?php echo $freePackageText; ?>
                                    </a>
                                </div> 
                            </div>
                        </div>  
                        <?php if(!empty($data)) {     
                            foreach($data as $key => $value) {        
                                ?>         

                                <div class="col-lg-4 col-md-4 col-xs-12 mb-2">
                                    <div class="pricing-table pricing-active border-color-red">
                                        <div class="pricing-details">
                                            <div class="icon">
                                                <i class="lni-briefcase"></i>
                                            </div>
                                            <h2><?php echo ucfirst($value->package_title); ?></h2>
                                            <ul>   
                                                <?php if($value->package_for == '1') { ?>
                                                    <li>Including Free Package</li>
                                                    <li>Team Up</li>    
                                                    <li>&nbsp;</li>  
                                                    <li>&nbsp;</li>    
                                                <?php } else if($value->package_for == '0') { ?>    
                                                    <li>Manage Both</li>
                                                    <li>Manage Job</li>      
                                                    <li>Manage Application</li>    
                                                    <li>&nbsp;</li>  
                                                <?php } ?>    
                                            </ul>    
                                            <div class="price"><span>$</span><?php echo $value->package_price; ?><span>/Month</span></div>
                                        </div>
                                        <div class="plan-button">
                                            <?php if($packageID != $value->id) { 
                                                if($type == "1") { ?>

                                                    <?php if($packageFor == "0") { ?>
                                                        <a href="javascript:void(0);" class="btn btn-border" onclick="downgradePackage('front-end-candidate_payment',<?php echo $value->id; ?>,<?php echo $type; ?>);">Downgrade</a>
                                                    <?php } else { ?>         
                                                        <a href="javascript:void(0);" class="btn btn-border" onclick="upgradePackage('front-end-candidate_payment',<?php echo $value->id; ?>,<?php echo $type; ?>);">Upgrade</a>
                                                    <?php } ?>    
                                                    
                                                <?php } ?>         
                                            <?php } else { ?>    
                                                <a href="javascript:void(0);" class="btn btn-border">
                                                    Subscribed
                                                </a>
                                            <?php } ?>    
                                            
                                        </div> 
                                    </div>
                                </div>  
                            <?php } } else { ?>
                                <div>No package found</div>
                            <?php } ?>   
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footersection')
    <script type="text/javascript" src="{{ asset('assets/front_end/js/candidate/manageprofile.js') }}"></script>
    @endsection

