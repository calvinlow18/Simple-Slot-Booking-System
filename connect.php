<?php

    $servername = "localhost";
    $username = "CalendarDBU5bii";
    $password = "7(-Ch$+v7*xI";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=CalendarDB", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

?>