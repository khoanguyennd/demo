<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail()
    {

    	$data=[
    		'name'=>'Khang'
    	];
      Mail::send('sendmail', $data, function($message){
      	$message->from('tuanhai7393@gmail.com','tuấn hải');
      	$message->to('tuanhai7393', 'Hải');
      	$message->subject('Test mail');
      });
      
    }
}
