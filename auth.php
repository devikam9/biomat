<html>
    <head></head>
    <body>
        <form method='post' action='authenticate2.php'>
            Username: <input type='text' name='username'><br>
            Password: <input type='password' name='password'><br>
            <input type='submit' value='Login'>
        </form>
    </body>
</html>

<?php

require_once 'login.php';
require_once 'sanitize.php';



// Create a new database connection
echo "Successful login <br>";
session_start();

$_SESSION['username'] = 'devika';


header("Location: ./appointment/scheduleappointment.php?userId=12");

       
        

// Close the database connection
$conn->close();

?>
