@php
$data = $data1["description"];    
$subject = str_replace("{subject}",$data1["subject"],$data); 
$name = str_replace("{name}",$data1["name"],$subject);
$email = str_replace("{email}",$data1["email"],$name); 
@endphp
{!! html_entity_decode($email) !!}
<button><a href="{{ route('front_end-active-account',[$data1['Userid'] , $data1['UserType']])}}" style="text-decoration: none; color: inherit;">Active Your Account</a></button> 
<button><a href="{{ route('front_end-signin')}}" style="text-decoration: none; color: inherit;">Click here for login</a></button>