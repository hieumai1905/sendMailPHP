<?php
//    $to = "hieumai1905it@gmail.com";
//    $subject = "Test mail";
//    $message = "Hello! This is a simple email message.";
//    $from = "maivanhieu19052002@gmail.com";
//    $headers = "From:" . $from;
//
//    $check = mail($to,$subject,$message,$headers);
//
//    if ($check) {
//        echo "Success";
//    }else{
//        echo "fail";
//    }


//Import PHPMailer classes into the global namespace
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
require "PHPMailer/src/Exception.php";
$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP

    $mail->CharSet = 'UTF-8';
    $mail->Host = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = '2701ef40d6cd99';                     //SMTP username
    $mail->Password = '2df27d897863f2';                               //SMTP password
    $mail->SMTPSecure = 'PLAIN, LOGIN and CRAM-MD5';            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('hieumai1905it@gmail.com', 'hieu gui');
    $mail->addAddress('maivanhhieu19052002@gmail.com', 'hieu nhan');     //Add a recipient
//    $mail->addAddress('ellen@example.com');               //Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body = 'Mã xác nhận của bạn là: <b style="color: red">123124</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

