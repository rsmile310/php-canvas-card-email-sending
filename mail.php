<?php
define('UPLOAD_DIR', 'images/');  
$img = $_POST['imgBase64'];  
$email = $_POST['email'];

$img = str_replace('data:image/png;base64,', '', $img);  
$img = str_replace(' ', '+', $img);  
$data = base64_decode($img);  
$file = UPLOAD_DIR . uniqid() . '.png';  
$success = file_put_contents($file, $data);  
// print $success ? $file : 'Unable to save the file.';  
// $domain = $_POST['domain'];
$to = $email; 
$from = 'host@host.com'; 
$subject = "You received a grating card!"; 
 
$htmlContent = ' 
    <html> 
    <head> 
        <title>Welcome to CodexWorld</title> 
    </head> 
    <body> 
        <img src="https://www.labwork.com.br/youtube/'.$file.'" width="400px" height="auto"/>
    </body> 
    </html>'; 
 
// Set content-type header for sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
 
// Additional headers 
$headers .= 'From: '.$from;

// Send email 
if(mail($to, $subject, $htmlContent, $headers)){ 
    echo json_encode(true); 
}else{ 
   echo json_encode(false); 
}
?>