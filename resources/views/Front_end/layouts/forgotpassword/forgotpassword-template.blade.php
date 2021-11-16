{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome!</div>
                  <div class="card-body">
                    <h1> Hii user<br> </h1>
                    name : {{ $userdata["name"] }} <br>
                    email : {{ $userdata["email"] }} <br>
                       <h3>  
                                <a href="{{ route('front_end-new-password',[$userdata['hid'],$userdata['token']]) }}">Click me for set new password</a> 
                            </p>
                     </h3> 
               </div>
           </div>
       </div>
   </div>
</div> --}}

@php
$data = $userdata["description"];    
$subject = str_replace("{subject}",$userdata["subject"],$data); 
$email = str_replace("{email}",$userdata["email"],$subject); 
@endphp
{!! html_entity_decode($email) !!}
<a href="{{ route('front_end-new-password',[$userdata['hid'],$userdata['token']]) }}">Click me for set new password</a> 
