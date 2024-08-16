<?php
require_once '../login.php'; // Database credentials

// Display logout button
echo "<a href='logout.php' class='logout-button'>Logout</a> <br> <br>";

// Initialize message variable
$message = "";

// Check if SSN is provided in the query string
if (isset($_GET['SSN'])) {
    $SSN = $_GET['SSN'];
    
    // Prepare the SQL query for deletion
    $query = "DELETE FROM personnel WHERE SSN = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('s', $SSN);

    // Execute the query
    if ($stmt->execute()) {
    $message = "Personnel with SSN $SSN has been successfully deleted.";

    header("Location: viewpersonnel.php");
    exit();
    } else {
        $message = "Error deleting personnel: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Medical Personnel</title>
</head>
<body>
    <h2>Delete Medical Personnel</h2>
    <form method="post" action="">
        <input type="text" name="SSN" placeholder="SSN" required>
        <input type="submit" name="delete" value="Delete Personnel">
    </form>
    <br>
    <?php
    // Display message
    if (!empty($message)) {
        echo "<p>$message</p>";
    }
    ?>
    <br>
    <a href="viewpersonnel.php">View Medical Personnel</a>
</body>
</html>
