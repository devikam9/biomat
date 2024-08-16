<?php
require_once 'login.php'; // Database credentials

// Display logout button
echo "<a href='logout.php' class='logout-button'>Logout</a> <br> <br>";

// Check if UUID is provided in the query parameter
if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
    
    // Sanitize UUID to prevent SQL Injection
    $uuid = mysqli_real_escape_string($connection, $uuid);

    // Fetch donor details based on UUID
    $query = "SELECT * FROM donor WHERE uuid = '$uuid'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Error fetching donor: " . mysqli_error($connection));
    }

    // Fetch donor data
    $donor = mysqli_fetch_assoc($result);

    if (!$donor) {
        echo "No donor found with the provided UUID.";
    }
} else {
    echo "UUID parameter is missing.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Donor</title>
</head>
<body>
    <h1>Donor Details</h1>

    <?php if (isset($donor)): ?>
        <table border="1">
            <tr>
                <th>Donor ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($donor['donor_id']); ?></td>
                <td><?php echo htmlspecialchars($donor['name']); ?></td>
                <td><?php echo htmlspecialchars($donor['email']); ?></td>
                <td><?php echo htmlspecialchars($donor['phone']); ?></td>
                <td><?php echo htmlspecialchars($donor['address']); ?></td>
                <td>
                    <a href="updatedonor.php?uuid=<?php echo urlencode($donor['uuid']); ?>">Update</a> | 
                    <a href="deletedonor.php?uuid=<?php echo urlencode($donor['uuid']); ?>" onclick="return confirm('Are you sure you want to delete this donor?');">Delete</a>
                </td>
            </tr>
        </table>
    <?php endif; ?>

    <br>
    <a href="createdonationcenter.php" class="back-button">Back to Management</a>
</body>
</html>

<?php
// Close database connection
mysqli_close($connection);
?>
