
<?php
require_once 'login.php'; // Ensure this file contains your database connection setup and session start

// Check if user is logged in
// session_start();
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location: ../login.php');
//     exit;
// }

// Ensure 'id' and 'uuid' are set in the query string
if (!isset($_GET['id'])) {
    die("Error: Invalid request");
}

$id = $_GET['id'];


// Validate appointment_id (ensure it's an integer)
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die("Error: Invalid appointment ID");
}

// Prepare and execute the SQL statement to delete the appointment
$query = "DELETE FROM donor WHERE donor_id = ?";
$stmt = $connection->prepare($query);

if ($stmt === false) {
    die("Error: " . $connection->error);
}

$stmt->bind_param('i', $id); // Bind 'i' for integer type

if ($stmt->execute()) {
    // Redirect to the view appointments page with a success message
    header("Location: admin_home.php");
    exit();
} else {
    die("Error: " . $stmt->error);
}

// Close the statement
$stmt->close();

// Close the connection
$connection->close();
?>


 