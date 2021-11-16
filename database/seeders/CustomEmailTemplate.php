<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emailtemplate;
use DB;

class CustomEmailTemplate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_template')->insert([
            // $template = [   
                ['title' => 'Register',
                'subject' => 'Register Successfully',
                'description' => '<p>&lt;div style=&quot;&nbsp;border-style:&nbsp;solid;border-width: 2px;&quot;&gt;&lt;h1 style=&quot;background-color:black; padding:50px;text-align:center;color:white&quot;&gt;{subject}&lt;/h1&gt;&lt;b&gt; name &lt;/b&gt;:&nbsp;{name}&nbsp;&lt;br&gt;&lt;b&gt;email &lt;/b&gt;&nbsp;:&nbsp;{email}&nbsp;&lt;br&gt;&lt;hr&gt;&lt;p&gt;&nbsp;After the user press the submit button and everything in the registration form is correct he is automatically registered and logged in. And the message is shown in a pop up window. However, I am not sure which form is better to use. Please, explain which sentence is better and why. Thanks.&lt;p&gt;&lt;/div&gt;</p>',
                'template_name' => 'register'],
                ['title' => 'Forgot password',
                'subject' => 'Forgot password ',
                'description' => '<p>&lt;div style=&quot;&nbsp;border-style:&nbsp;solid;border-width: 2px;&quot;&gt;&lt;h1 style=&quot;background-color:black; padding:50px;text-align:center;color:white&quot;&gt;{subject}&lt;/h1&gt;&lt;b&gt;email &lt;/b&gt;:&nbsp;{email}&nbsp;&lt;br&gt;&lt;hr&gt;&lt;p&gt;We&nbsp;sending&nbsp;you&nbsp;this&nbsp;email&nbsp;because&nbsp;you&nbsp;requested&nbsp;a&nbsp;password&nbsp;reset.&nbsp;Click&nbsp;on&nbsp;this&nbsp;link&nbsp;to&nbsp;create&nbsp;new&nbsp;Password:&lt;/p&gt;&lt;/div&gt;</p>',
                'template_name' => 'forgotpassword'],
                ['title' => 'Team Up',
                'subject' => 'Team Up',
                'description' => '<p>&lt;h1 style=&quot;background-color:black; padding:50px;text-align:center;color:white&quot;&gt;{subject}&lt;/h1&gt;&lt;h2&gt;&nbsp;Hii&nbsp;{name}&lt;br&gt;&lt;p&gt;It&rsquo;s&nbsp;&nbsp;{logincandidate}&lt;/h2&gt;.&lt;br&gt;&nbsp;It&nbsp;was&nbsp;great&nbsp;to&nbsp;speak&nbsp;with&nbsp;you&nbsp;about&nbsp;Work&nbsp;together.&nbsp;&lt;br&gt;I&nbsp;read&nbsp;about&nbsp;your&nbsp;skill&nbsp;and&nbsp;experience&nbsp;and&nbsp;about&nbsp;your&nbsp;project.you&nbsp;can&nbsp;work&nbsp;with&nbsp;me&nbsp;,&nbsp;if&nbsp;you&nbsp;are&nbsp;interested.&lt;/p&gt;</p>',
                'template_name' => 'teamup'],
                ['title' => 'Contact Us',
                'subject' => 'Contact Us',
                'description' => '<p>&lt;div style=&quot;&nbsp;border-style:&nbsp;solid;border-width: 2px;&quot;&gt;&lt;h1 style=&quot;background-color:black; padding:50px;text-align:center;color:white&quot;&gt;{subject}&lt;/h1&gt;&lt;b&gt;name :&lt;/b&gt; {name}&lt;br&gt;&lt;b&gt;email :&lt;/b&gt;&nbsp;{email}&nbsp;&lt;br&gt;&lt;b&gt;Mail&nbsp;Subject :&lt;/b&gt; {msgSubject}&lt;br&gt;&lt;b&gt;User&nbsp;Message&nbsp;:&lt;/b&gt; {userMessage}&lt;br&gt;&lt;p&gt;Thanks&nbsp;for&nbsp;Contacting&nbsp;us,&nbsp;our&nbsp;team&nbsp;will&nbsp;be&nbsp;contact&nbsp;you&nbsp;as&nbsp;soon&nbsp;as&nbsp;Possible.&nbsp;&lt;/p&gt;&lt;/div&gt;</p>',
                'template_name' => 'contactus']
            ]);
         
            // Emailtemplate::create($template[0]);
            
    }
    
}
