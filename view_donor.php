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
        $donor = []; // Initialize empty donor data to avoid errors
    }

$query2 = "SELECT firstname, lastname FROM user WHERE uuid = '$uuid'";
    $result2 = mysqli_query($connection, $query2);

    if (!$result2) {
        die("Error fetching user: " . mysqli_error($connection));
    }

    // Fetch user data
    $user = mysqli_fetch_assoc($result2);

    if (!$user) {
        echo "No user found with the provided UUID.";
        $user = []; // Initialize empty user data to avoid errors
    }
} else {
    echo "UUID parameter is missing.";
    $donor = [];
    $user = []; // Initialize empty user data to avoid errors
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Donor Information</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="favicon.ico">
</head>
<body>
<header>
    <div class="header-buttons">
        <button class="nav-button" onclick="location.href='./appointment/viewappointment.php?uuid=<?php echo urlencode($uuid); ?>'">View Appointments</button>
        <button class="nav-button" onclick="location.href='./appointment/scheduleappointment.php?uuid=<?php echo urlencode($uuid); ?>'">Schedule Appointment</button>
        <!-- <button class="nav-button" onclick="location.href='delete.html'">Delete</button> -->
    </div>
</header>

<hr class="separator">

<main>
    <div class="form-container">
        <form action="view_donor.php" method="get">
            <h2>View Donor Information</h2>
            <label for="ssn">SSN:</label>
            <input type="text" id="ssn" name="ssn" value="<?php echo isset($donor['donor_ssn']) ? htmlspecialchars($donor['donor_ssn']) : ''; ?>" readonly>


            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="firstname" value="<?php echo isset($user['firstname']) ? htmlspecialchars($user['firstname']) : ''; ?>" readonly>
            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="lastname" value="<?php echo isset($user['lastname']) ? htmlspecialchars($user['lastname']) : ''; ?>" readonly>


            <label for="street">Street:</label>
            <input type="text" id="street" name="street" value="<?php echo isset($donor['street']) ? htmlspecialchars($donor['street']) : ''; ?>" readonly>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo isset($donor['city']) ? htmlspecialchars($donor['city']) : ''; ?>" readonly>
            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php echo isset($donor['state']) ? htmlspecialchars($donor['state']) : ''; ?>" readonly>

            <label for="zip">Zip:</label>
            <input type="text" id="zip" name="zip" value="<?php echo isset($donor['zip']) ? htmlspecialchars($donor['zip']) : ''; ?>" readonly>
            <label for="blood-type">Blood Type:</label>
            <select id="bloodType1" name="bloodType1" disabled>
                <option value="A+" <?php echo isset($donor['bloodtype']) && $donor['bloodtype'] == 'A+' ? 'selected' : ''; ?>>A+</option>
                <option value="A-" <?php echo isset($donor['bloodtype']) && $donor['bloodtype'] == 'A-' ? 'selected' : ''; ?>>A-</option>
                <option value="B+" <?php echo isset($donor['bloodtype']) && $donor['bloodtype'] == 'B+' ? 'selected' : ''; ?>>B+</option>
                <option value="B-" <?php echo isset($donor['bloodtype']) && $donor['bloodtype'] == 'B-' ? 'selected' : ''; ?>>B-</option>
                <option value="AB+" <?php echo isset($donor['bloodtype']) && $donor['bloodtype'] == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                <option value="AB-" <?php echo isset($donor['bloodtype']) && $donor['bloodtype'] == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                <option value="O+" <?php echo isset($donor['bloodtype']) && $donor['bloodtype'] == 'O+' ? 'selected' : ''; ?>>O+</option>
                <option value="O-" <?php echo isset($donor['bloodtype']) && $donor['bloodtype'] == 'O-' ? 'selected' : ''; ?>>O-</option>
            </select>


            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($donor['email']) ? htmlspecialchars($donor['email']) : ''; ?>" readonly>


            <label for="emergency-contact">Emergency Contact:</label>
            <input type="text" id="emergencycontact" name="emergencycontact" value="<?php echo isset($donor['emergencycontact']) ? htmlspecialchars($donor['emergencycontact']) : ''; ?>" readonly>
            
        </form>
    </div>
</main>

<footer>
    <div class="footer-content">
        <p>For more information contact us at: <a href="mailto:contact@example.com">contact@example.com</a> or (123) 456-7890</p>
        <p>© 2023 Biomat USA. All rights reserved.</p>
    </div>
</footer>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    header {
        background-color: #30669A;
        padding: 10px;
        text-align: center;
    }
    .header-buttons {
        display: flex;
        justify-content: center;
    }
    .nav-button {
        margin: 0 10px;
        padding: 10px 20px;
        background-color: white;
        color: #30669A;
        border: 1px solid #30669A;
        border-radius: 5px;
        cursor: pointer;
    }
    .nav-button:hover {
        background-color: #ddd;
    }
    .separator {
        border: none;
        height: 20px;
        background-color: white;
    }
    main {
        flex: 1;
        padding: 20px;
        background-color: #f4f4f4;
    }
    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
    }
    form h2 {
        margin-bottom: 20px;
        color: #30669A;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }
    input[type="text"], input[type="email"], select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    input[type="submit"] {
        background-color: #30669A;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #245378;
    }
    footer {
        background-color: #30669A;
        color: white;
        text-align: center;
        padding: 10px;
    }
    footer a {
        color: white;
        text-decoration: none;
    }
    footer a:hover {
        text-decoration: underline;
    }
</style>
</body>
</html>
