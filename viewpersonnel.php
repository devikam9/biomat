<?php
require_once 'login.php'; // Database credentials

// Display logout button
echo "<a href='logout.php' class='logout-button'>Logout</a> <br> <br>";

// Fetch all medical personnel
$query = "SELECT * FROM personnel";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error fetching medical personnel: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Medical Personnel</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon"  href="favicon.ico">

</head>
<body>
    <h1>Medical Personnel List</h1>

    <table border="1">
        <tr>
            <th>Personnel ID</th>
            <th>SSN</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
            <th>Contact</th>
            <th>Donation Center ID</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['personnel_id']) . "</td>
                    <td>" . htmlspecialchars($row['SSN']) . "</td>
                    <td>" . htmlspecialchars($row['firstname']) . "</td>
                    <td>" . htmlspecialchars($row['lastname']) . "</td>
                    <td>" . htmlspecialchars($row['position']) . "</td>
                    <td>" . htmlspecialchars($row['contact']) . "</td>
                    <td>" . htmlspecialchars($row['donation_center']) . "</td>
                    <td>
                        <a href='updatepersonnel.php?SSN=" . urlencode($row['SSN']) . "'>Update</a> | 
                        <a href='deletepersonnel.php?SSN=" . urlencode($row['SSN']) . "' onclick=\"return confirm('Are you sure you want to delete this personnel?');\">Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <br>
    <a href="createdonationcenter.php" class="back-button">Back to Management</a>
</body>
</html>

<?php
// Close database connection
mysqli_close($connection);
?>
