<?php
    
    date_default_timezone_set('Asia/Kuala_Lumpur');

    $captcha = $_POST["recaptcha"];

    if(!$captcha){
        echo "Please verify yourself (Server Side)";
        exit;
    } else {
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LfESwoUAAAAAONOcuIaUFx6fDSNMq6rmATu4v0k&response=".$captcha."&remoteip=".$_SERVER["REMOTE_ADDR"];
        $response=file_get_contents($url);
        $resObj = json_decode($response);
        if(!($resObj->success))
        {
          echo 'You are a robot';
          exit;
        }
        $date = $_POST['date'];
        $time = $_POST['time'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $pax = $_POST['pax'];
        $ticket = $_POST['ticketID'];

        require 'connect.php';

        $stmt = "SELECT count(*) FROM bookings WHERE timeB = '$time' AND dateB = '$date' AND approval = 1";
        $sth = $conn->prepare($stmt);
        $sth->execute();
        $rows = $sth->fetchColumn();

        if($rows == 0) {
            try{

                $sql = "INSERT INTO bookings (timeB, dateB, name, email, contact, pax, ticket) VALUES ('$time', '$date', '$name', '$email', '$contact', $pax, '$ticket')";
                //echo $sql;
                $conn->exec($sql);

                //require 'CustomerMailer.php';
                require 'Email2.php';
                //require 'AdminMailer.php';

                //echo "Please wait for confirmation. Thank You.";
            }
            catch(PDOException $e)
            {
                echo "Error!!!";
            }

        } else {
            echo "Someone made appointment at this time earlier. Please book other time.";
        }
    }

	
?>