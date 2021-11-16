@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Payment')
@section('pageheader', 'Payment')
@section('content')

<style>
.hide {
    display: none;
}
</style>

<div id="loader"></div>
<div id="content">
    <div class="container">  
        <div class="row">
            <?php if($type == "1") { ?>
                @include('Front_end.candidate.ManageProfile.left_menu')
            <?php } else { ?>    
                @include('Front_end.employers.jobs.leftside_menu')
            <?php } ?>  
            
            <div class="col-lg-9 col-md-9 col-xs-12">
                <div class="job-alerts-item candidates">

                 @if (Session::has('success'))
                 <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
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
                    <strong>Whoops!</strong> There were some problems with your input.
                    <br />
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form role="form" action="{{ route('dopayment') }}" method="post" class="validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                    {{ csrf_field() }} 

                    <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed collapseTab" type="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
                                            Billing Address 
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                            <div class='form-row'>
                                                <div class='col-xs-12 col-md-12 form-group'>
                                                    <label class='control-label'>Address :</label> 
                                                    <input class='form-control' type='text' id="address" name="address" value="{{ isset($BillingaddressData[0]['address']) ? $BillingaddressData[0]['address'] : '' }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="country" class="ml-2">Country :</label>
                                                <select class="form-control" id="country" name="country" required>
                                                    <option value="">Select Country</option>
                                                    @foreach ($country as $country)
                                                        <option class="custom-select" value='{{ $country->id }}' <?php if (isset($BillingaddressData[0]['country_id'])) { if ($BillingaddressData[0]['country_id'] == $country->id) { echo 'selected'; }} ?> >{{ $country->country_name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="state" class="ml-2">State :</label>
                                                <select class="form-control" id="state" name="state" required>
                                                    <option value="">Select State</option>
                                                
                                                    @if (!empty($state[0]))
                                                        @foreach ($state as $state)
                                                            <option value="{{ $state->id }}" <?php if(isset($BillingaddressData[0]['state_id'])) { if ($BillingaddressData[0]['state_id'] == $state->id) { echo 'selected'; }} ?>> {{ $state->state_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="city" class="ml-2">City :</label>
                                                <select class="form-control" id="city" name="city" required>
                                                    <option value="">Select City</option>
                                                    @if (!empty($city[0]))
                                                        @foreach ($city as $city)
                                                            <option value="{{ $city->id }}" <?php if(isset($BillingaddressData[0]['city_id'])) { if ($BillingaddressData[0]['city_id'] == $city->id) { echo 'selected'; } } ?>> {{ $city->city_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                    </div>
                                </div>
                            </div>

                        <div class="card">
                            <div class="card-header" id="headingOne">
                              <h5 class="mb-0">
                                    <button class="btn btn-link collapsed collapseTab" type="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                    Payment
                                    </button>
                              </h5>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                              <div class="card-body">
                                      <div>
                                              <div class='form-row row'>
                                                  <div class='col-md-12 hide error form-group'>
                                                      <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                                  </div>
                                              </div>
                          
                                              <div class='form-row row'>
                                                  <div class='col-xs-12 col-md-12 form-group required'>
                                                      <label class='control-label'>Name on Card</label> 
                                                      <input class='form-control' type='text' id="cardName" name="cardName">
                                                  </div>
                                              </div>
                          
                                              <div class='form-row row'>
                                                  <div class='col-xs-12 col-md-12 form-group required'>
                                                      <label class='control-label'>Card Number</label> 
                                                      <input autocomplete='off' class='form-control card-num' name="cardNum" id="cardNum" type='text'>
                                                  </div>
                                              </div>
                          
                                              <div class='form-row row'>
                                                  <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                      <label class='control-label'>CVC</label> 
                                                      <input autocomplete='off' class='form-control card-cvc' placeholder='415' type='text'>
                                                  </div>
                                                  <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                      <label class='control-label'>Expiration Month</label> <input
                                                      class='form-control card-expiry-month' placeholder='MM' type='text'>
                                                  </div>
                                                  <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                      <label class='control-label'>Expiration Year</label> 
                                                      <input class='form-control card-expiry-year' placeholder='YYYY' type='text'>
                                                  </div>
                                              </div>
                          
                                              <div class="row">
                                                  <div class="col-xs-12">
                                                      <input type="hidden" name="packageId" id="packageId" value="<?php echo $data[0]->id; ?>">
                                                      <input type="hidden" name="stripe-publishable-key" id="stripe-publishable-key" value="{{ env('STRIPE_KEY') }}"> 
                                                      <button class="btn btn-danger btn-lg btn-block" type="submit">Pay Now ($<?php echo $data[0]->package_price; ?>)</button>
                                                  </div>
                                              </div>
                                      </div>
                              </div>
                            </div>
                          </div>
                    
                    </div>

            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection
@section('footersection')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>    
<script type="text/javascript">
    $(function() {
        var $form         = $(".validation");
        $('form.validation').bind('submit', function(e) {
            $("#loader").addClass('emailloader');
            var $form         = $(".validation"),
            inputVal = ['input[type=email]', 'input[type=password]',
            'input[type=text]', 'input[type=file]',
            'textarea'].join(', '),
            $inputs       = $form.find('.required').find(inputVal),
            $errorStatus = $form.find('div.error'),
            valid         = true;
            $errorStatus.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
              var $input = $(el);
              if ($input.val() === '') {
                $("#loader").removeClass('emailloader');
                $input.parent().addClass('has-error');
                $errorStatus.removeClass('hide');
                e.preventDefault();
            }
        });

            if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                number: $('.card-num').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeHandleResponse);
          }

      });

        function stripeHandleResponse(status, response) {
            if (response.error) {
                $("#loader").removeClass('emailloader');
                $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
            } else {
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
    $('#country').on('change', function () {
    var country = $(this).val();
    $.ajax({
        url: BASE_URL +  '/city/getcountrystate',
        // url: BASE_URL + '/' + ADMIN + '/city/getcountrystate',
        type: 'post',
        data: {
            country: country,
            "_token": $("[name='_token']").val(),
        },

        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                $('#state').html('');
                var result = data.list;
                $('#state').html(result);
            }
        }
    });
});

$('#state').on('change', function () {
    var state = $(this).val();
    $.ajax({
        url: BASE_URL + '/city/getstatecity',
        // url: BASE_URL + '/' + ADMIN + '/city/getstatecity',
        type: 'post',
        data: {
            state: state,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            var data = JSON.parse(response);
            if (data.status == 1) {
                $('#city').html('');
                var result = data.list;
                $('#city').html(result);
            }
        }
    });
});
</script>
@endsection


 