<?php

    require 'PHPMailer/PHPMailerAutoload.php';

    $cMail = new PHPMailer;

    $cMail->isSMTP();                                      // Set mailer to use SMTP
    $cMail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $cMail->SMTPAuth = true;                               // Enable SMTP authentication
    $cMail->Username = 'calvinlow9618@gmail.com';                 // SMTP username
    $cMail->Password = 'lkw960618';                           // SMTP password
    $cMail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $cMail->Port = 587;                                    // TCP port to connect to

    $cMail->setFrom('calvinlow9618@gmail.com', 'Admin');
    $cMail->addAddress($email, $name);     // Add a recipient

    $cMail->isHTML(true);                                  // Set email format to HTML

    $cMail->Subject = $name." ".$date." ".$time;
    $cMail->Body    = 'You have receive this email indicates the reqest has been successfully sent to admin. Please wait for reply. Thank you.';

    if(!$cMail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $cMail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }

    $cMail->ClearAllRecipients();

    $cMail->addAddress('calvinlow9618@gmail.com', 'Admin');

    $cMail->Body    = 'Admin Mail';

    if(!$cMail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $cMail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }


?>