<?php    

    date_default_timezone_set('Asia/Kuala_Lumpur');

	$date = $_POST['date'];

    $datetime =  date_create_from_format("j F, Y", $date);

    $dateForSQL = $datetime->format('Y-m-d');

    $stmt = "SELECT TIME_FORMAT(timeB, '%k') AS hour, TIME_FORMAT(timeB, '%i') AS mins FROM bookings WHERE DATE_FORMAT(dateB,'%Y-%m-%d')='$dateForSQL' AND approval<>2;";

    require 'connect.php';

    $sth = $conn->prepare($stmt);
    $sth->execute();
    $bookedslot = $sth->fetchAll();
    
    $jsonBookedSlot = json_encode($bookedslot);

    echo $jsonBookedSlot;
?>