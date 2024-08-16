<?php
function sanitize($conn, $string) {
    $string = stripslashes($string);
    $string = $conn->real_escape_string($string);
    return htmlentities($string);
}
?>