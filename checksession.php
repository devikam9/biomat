<?php

session_start();

if(isset($_SESSION['username'])){

    $username = $_SESSION['username'];
    echo "Hello welcome $username <br>";


    // echo "Hello welcome $username <br> <br>";

} else {
    header("Location: authenticate3.php");
}

?>