<?php
    $id = $_GET['uniq_id'];

    require 'connect.php';

    $stmt = "SELECT * FROM bookings WHERE uniq_id = '$id'";
    $sth = $conn->prepare($stmt);
    $sth->execute();
    $data = $sth->fetch(PDO::FETCH_ASSOC);

    if($sth) {
        $stmt = "UPDATE bookings SET approval=1 WHERE id = '$uniq_id'";
        $sth = $conn->prepare($stmt);
        $sth->execute();
        if($sth) {
            echo "<script>alert('Appointment Approved Successfully')</script>";
            sendDisapproveEmail($data);
        } else {
            echo "<script>alert('Fail To Approve Appointment')</script>";
        }
    } else {
        echo "<script>alert('Fail To Fetch Appointment')</script>";
    }

    function sendDisapproveEmail($data) {
        require 'PHPMailer/PHPMailerAutoload.php';

        $cMail = new PHPMailer;

        $cMail->isSMTP();
        $cMail->Host = 'smtp.gmail.com';
        $cMail->SMTPAuth = true;
        $cMail->Username = 'calvinlow9618@gmail.com';
        $cMail->Password = 'lkw960618';
        $cMail->SMTPSecure = 'tls';
        $cMail->Port = 587;

        $cMail->setFrom('calvinlow9618@gmail.com', 'Admin');
        $cMail->addAddress($data['email'], $data['name']);

        $cMail->isHTML(true);

        $cMail->Subject = "Approve Slot Booked";
        $cMail->Body    = message($data);

        if(!$cMail->send()) {
            echo 'Message failed to send.';
            echo 'Mailer Error: ' . $cMail->ErrorInfo;
        } else {
            echo 'Approve Message has been sent';
        }
    }

    function message($data) {
        $message = '<html><body>';
        $message .= '<img src="http://beta.dogoodvolunteer.com/uploads/organization_img/Dialogue-Logo.jpg" alt="Dialogue In The Dark" />';
        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . $data['name'] . "</td></tr>";
        $message .= "<tr><td><strong>Email:</strong> </td><td>" . $data['email'] . "</td></tr>";
        $message .= "<tr><td><strong>Contact Number:</strong> </td><td>" . $data['contact'] . "</td></tr>";
        $message .= "<tr><td><strong>Pax:</strong> </td><td>" . $data['pax'] . "</td></tr>";
        $message .= "<tr><td><strongTicket ID:</strong> </td><td>" . $data['ticket'] . "</td></tr>";
        $message .= "</table>";
        $message .= "<br>";
        $message .= "<strong>Slot Booked Above is Approved. Thank You.</strong>";
        $message .= "</body></html>";
    }
    
?>