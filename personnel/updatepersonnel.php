<?php
require_once '../login.php'; // Database credentials

// Get SSN from query string
$ssn = isset($_GET['SSN']) ? mysqli_real_escape_string($connection, $_GET['SSN']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $position = mysqli_real_escape_string($connection, $_POST['position']);
    $contact = mysqli_real_escape_string($connection, $_POST['contact']);
    $donation_center = mysqli_real_escape_string($connection, $_POST['donation_center']);

    $update_query = "UPDATE personnel SET 
                        firstname='$firstname',
                        lastname='$lastname',
                        position='$position',
                        contact='$contact',
                        donation_center='$donation_center'
                     WHERE SSN='$ssn'";

    if (mysqli_query($connection, $update_query)) {
        // Redirect to practice.php after update
        header("Location: viewpersonnel.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

// Fetch existing data for the given SSN
$query = "SELECT * FROM personnel WHERE SSN='$ssn'";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error fetching personnel: " . mysqli_error($connection));
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medical Personnel</title>
</head>
<body>
    <h1>Update Medical Personnel</h1>

    <form method="post">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($row['firstname']); ?>" required><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($row['lastname']); ?>" required><br>

        <label for="position">Position:</label>
        <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($row['position']); ?>" required><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($row['contact']); ?>" required><br>

        <label for="donation_center">Donation Center ID:</label>
        <input type="text" id="donation_center" name="donation_center" value="<?php echo htmlspecialchars($row['donation_center']); ?>" required><br>

        <input type="submit" value="Update">
    </form>

    <br>
    <a href="practice.php" class="back-button">Back to Management</a>
</body>
</html>

<?php
// Close database connection
mysqli_close($connection);
?>
