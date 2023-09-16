<?php
if($_POST)
{
    $to_email       = "barbara.lencinas@gmail.com"; //Recipient email, Replace with own email here
    $from_email     = 'noreply@your_domain.com'; //from mail, it is mandatory with some hosts and without it mail might endup in spam.
    
    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        
        $output = json_encode(array( //create JSON data
            'type'=>'error', 
            'text' => 'Sorry Request must be Ajax POST'
        ));
        die($output); //exit script outputting json data
    } 
    
    //Sanitize input data using PHP filter_var().
    $user_name      = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $user_email     = filter_var($_POST["user_email"], FILTER_SANITIZE_EMAIL);
	$subject        = "";
    $message        = filter_var($_POST["msg"], FILTER_SANITIZE_STRING);
    
    //additional php validation
    if(strlen($user_name)<4){ // If length is less than 4 it will output JSON error.
        $output = json_encode(array('type'=>'error', 'text' => 'El nombre es muy corto :('));
        die($output);
    }
    if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){ //email validation
        $output = json_encode(array('type'=>'error', 'text' => 'Por favor, ingresa un mail válido'));
        die($output);
    }
    if(strlen($message)<3){ //check emtpy message
        $output = json_encode(array('type'=>'error', 'text' => 'Por favor, detalla un poco más en qué puedo ayudarte'));
        die($output);
    }
    
    //email body
    $message_body = $message."\r\n\r\n-".$user_name."\r\nEmail : ".$user_email ;
    
    //proceed with PHP email.
    $headers = 'From: '. $from_email .'' . "\r\n" .
    'Reply-To: '.$user_email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    $send_mail = mail($to_email, $subject, $message_body, $headers);
    
    if(!$send_mail)
    {
        //If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
        $output = json_encode(array('type'=>'error', 'text' => 'No pudo enviarse el email! Por favor, chequea tu configuración PHP de email'));
        die($output);
    }else{
        $output = json_encode(array('type'=>'message', 'text' => 'Hola '.$user_name .' Muchas gracias por tu email'));
        die($output);
    }
}
?>