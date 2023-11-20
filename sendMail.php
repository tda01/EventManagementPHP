<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'phpMailer/src/Exception.php';
require 'phpMailer/src/PHPMailer.php';
require 'phpMailer/src/SMTP.php';


$mail = new PHPMailer(true);

try {
    //Server settings

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'vlad.12.moise.3@gmail.com';
    $mail->Password   = 'ybcgjskmfdciewkm';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('vlad.12.moise.3@gmail.com');
    $mail->addAddress('alexturcu790@gmail.com');

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'S-a trimis';
    $mail->Body    = '<h1>S-a trimis!</h1>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}