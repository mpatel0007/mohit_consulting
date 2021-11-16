

@php
$template_data = $data["description"];    
$subject = str_replace("{subject}",$data["subject"],$template_data); 
$name = str_replace("{name}",$data["name"],$subject); 
$logincandidate = str_replace("{logincandidate}",$data["login_candidate"],$name); 

@endphp
{!! html_entity_decode($logincandidate) !!}
    <button style="background-color:white; color:black;border: 2px solid #4CAF50;"><a href="{{ route('front_end-candidate-team-request-accept-mail',[$data['candidateId'],$data['candidateTeamid']]) }}" style="text-decoration: none; ">Accept Team Up Request</a></button>
    <button style="background-color: white; color: black; border: 2px solid #f44336;"><a href="{{ route('front_end-candidate-team-request-deny-mail',[$data['candidateId'],$data['candidateTeamid']]) }}" style="text-decoration: none;" class="button2">Deny Team Up Request</a></button>

