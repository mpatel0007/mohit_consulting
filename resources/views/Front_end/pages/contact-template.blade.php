{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome!</div>
                <div class="card-body">
                    <h1>Hii<br> </h1>
                    name : {{ $userdata["name"] }} <br> 
                    email : {{ $userdata["email"] }} <br>
                    mail Subject : {{ $userdata["msg_subject"] }} <br>
                    User Message : {{ $userdata["message"] }} <br>
                    <h3>  
                     <p>Thanks for Contacting us, our team will be contact you as soon as Possible<br>
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
$name = str_replace("{name}",$userdata["name"],$subject); 
$email = str_replace("{email}",$userdata["email"],$name); 
$msgSubject = str_replace("{msgSubject}",$userdata["msg_subject"],$email); 
$userMessage = str_replace("{userMessage}",$userdata["message"],$msgSubject); 
@endphp
{!! html_entity_decode($userMessage) !!}
