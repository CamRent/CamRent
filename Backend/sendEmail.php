<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/PHPMailer/src/Exception.php';
require 'vendor/phpmailer/PHPMailer/src/PHPMailer.php';
require 'vendor/phpmailer/PHPMailer/src/SMTP.php';

require_once "usefulFunctions.php";
require_once "vendor/autoload.php";
require_once "emailConfig.php";


function sendEmail($pdo, $email,$activationcode ="test", $password){
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 1;                                  // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';    // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'camrenthtl3r@gmail.com';                 // SMTP username
        $mail->Password = $password;                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('camrenthtl3r@gmail.com', 'Mailer');
        $mail->addAddress($email, 'test');     // Add a recipient
        $mail->addReplyTo('camrenthtl3r@gmail.com', 'Information');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body = "Link: localhost/camrent/backend/routeUser.php?email=$email&activationcode=$activationcode";
        $mail->AltBody = "Link: localhost/camrent/backend/routeUser.php?email=$email&activationcode=$activationcode";

        $mail->send();
        //echo 'Message has been sent';
        makeUnverifiedEmalInactive($pdo,getActiveUnverifiedIdFromEmail($pdo,$email));

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}