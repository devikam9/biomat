<?php
require_once '../login.php'; // Database credentials

// Display logout button
echo "<a href='logout.php' class='logout-button'>Logout</a> <br> <br>";

// Fetch cities for the dropdown
$query = "SELECT city FROM donation_center GROUP BY city";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error fetching cities: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Donation Center</title>
</head>
<body>
    <h2>Delete Donation Center</h2>

    <form method="post" action="">
        <label for="city">Select City to Delete Donation Center:</label>
        <select name="city" id="city" required>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . htmlspecialchars($row['city']) . "'>" . htmlspecialchars($row['city']) . "</option>";
            }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Delete Donation Center">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect form data
        $city = $_POST['city'];

        // Prepare the SQL query
        $query = "DELETE FROM donation_center WHERE city = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('s', $city); // 's' for string

        // Execute the query
        if ($stmt->execute()) {
            echo "Donation centers in city '$city' have been successfully deleted.";
        } else {
            echo "Error deleting donation center: " . mysqli_error($connection);
        }

        // Close statement
        $stmt->close();
    }

    // Close database connection
    mysqli_close($connection);
    ?>
</body>
</html>
