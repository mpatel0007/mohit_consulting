{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome!</div>
                  <div class="card-body">
                    <h1> Hii user<br> </h1>
                Dear {{$CampaignData['name']}},<br>
                    name : {{ $userdata["name"] }} <br>
                    email : {{ $CampaignData["email"] }} <br>
                       <h3>  
                           <p>
                               {!!$CampaignData['description'] !!}
                            </p>
                     </h3> 
               </div>
           </div>
       </div>
   </div>
</div> --}}

@php
$template_data = $CampaignData["description"];    
$subject = str_replace("{subject}",$CampaignData["subject"],$template_data); 
$name = str_replace("{name}",$CampaignData["name"],$subject); 
$email = str_replace("{email}",$CampaignData["email"],$name); 
@endphp
{!! html_entity_decode($email) !!}