<?php

    require 'PHPMailer/PHPMailerAutoload.php';

    $currentID = getID($time, $date, $email);

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

    $cMail->Subject = "DID Slot Booking Request";
    $cMail->Body    = messageEmail("Customer", $currentID, $date, $time, $name, $email, $contact, $pax, $ticket);

    if(!$cMail->send()) {
        echo 'Message could not be sent. Please contact DID manually.';
        echo 'Mailer Error: ' . $cMail->ErrorInfo;
    } else {
        echo 'Message has been sent to your email.\n';
        $cMail->ClearAllRecipients();

        $cMail->addAddress('calvinlow18@outlook.com', 'Admin');

        $cMail->Body    = messageEmail("Admin", $currentID, $date, $time, $name, $email, $contact, $pax, $ticket);

        if(!$cMail->send()) {
            echo 'Message Failed to send to admin. Please notify them manually.';
        } else {
            echo 'Admin has been notified.';
        }
    }

    function messageEmail($receiver, $mId, $mDate, $mTime, $mName, $mEmail, $mContact, $mPax, $mTicket) {
        
        $message = '<html><body>';
        $message .= '<img src="http://beta.dogoodvolunteer.com/uploads/organization_img/Dialogue-Logo.jpg" alt="Dialogue In The Dark" />';
        $message .= '<table border="1" bordercolor="#666" style="border-collapse : collapse" cellpadding="10">';
        $message .= "<tr><td style='background: #eee;'><strong>Name:</strong> </td><td>" . $mName . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Email:</strong> </td><td>" . $mEmail . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Contact Number:</strong> </td><td>" . $mContact . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Pax:</strong> </td><td>" . $mPax . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Ticket ID:</strong> </td><td>" . $mTicket . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Date:</strong> </td><td>" . $mDate . "</td></tr>";
        $message .= "<tr><td style='background: #eee;'><strong>Time:</strong> </td><td>" . $mTime . "</td></tr>";

        if($receiver == "Admin") {
            $message .= "<tr><td style='background: #eee;'><strong>Approve:</strong> </td><td><a href='localhost/Approve.php?uniq_id=".$mId."'><button>Approve</button></a></td></tr>";
            $message .= "<tr><td style='background: #eee;'><strong>Disapprove:</strong> </td><td><a href='localhost/Disapprove.php?uniq_id=".$mId."'><button>Disapprove</button></a></td></tr>";
        }

        $message .= "</table>";
        $message .= "</body></html>";
        return $message;
    }


    function getID($iTime, $iDate, $iEmail) {
        require 'connect.php';
        $stmt = "SELECT uniq_id FROM bookings WHERE timeB = '$iTime' AND dateB = '$iDate' AND email = '$iEmail' AND approval = 0";
        $sth = $conn->prepare($stmt);
        $sth->execute();
        $cId = $sth->fetchColumn();
        return $cId;
    }

?>