
<?php
require_once '../login.php'; // Ensure this file contains your database connection setup and session start

// Check if user is logged in
// session_start();
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header('Location: ../login.php');
//     exit;
// }

// Ensure 'id' and 'uuid' are set in the query string
if (!isset($_GET['id']) || !isset($_GET['uuid'])) {
    die("Error: Invalid request");
}

$id = $_GET['id'];
$uuid = $_GET['uuid'];

// Validate appointment_id (ensure it's an integer)
if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die("Error: Invalid appointment ID");
}

// Prepare and execute the SQL statement to delete the appointment
$query = "DELETE FROM appointment WHERE appointment_id = ?";
$stmt = $connection->prepare($query);

if ($stmt === false) {
    die("Error: " . $connection->error);
}

$stmt->bind_param('i', $id); // Bind 'i' for integer type

if ($stmt->execute()) {
    // Redirect to the view appointments page with a success message
    header("Location: viewappointment.php?uuid=$uuid");
    exit();
} else {
    die("Error: " . $stmt->error);
}

// Close the statement
$stmt->close();

// Close the connection
$connection->close();
?>


 