<?php
require_once '../login.php'; // Ensure this file contains your database connection setup
echo "<a href='../logout.php' class='logout-button'>Logout</a> <br> <br>";
// Check if the userid parameter is provided
if (!isset($_GET['uuid']) || empty($_GET['uuid'])) {
    die("Error: User ID is not provided.");
}

$userid = $_GET['uuid'];

// Sanitize the input to prevent SQL Injection
$userid = htmlspecialchars($userid, ENT_QUOTES, 'UTF-8');

// Prepare and execute the query to fetch appointments for the given userid
$query = "SELECT * FROM appointment WHERE uuid = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param('s', $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

if ($result === false) {
    die("Error: " . $connection->error);
}
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="favicon.ico">

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
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #30669A;
            padding: 10px;
            text-align: center;
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
</head>
<body>
    <h2>Your Appointments</h2>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Appointment ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Donation Center</th>
                <th>Donation ID</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['appointment_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['time']); ?></td>
                    <td><?php echo htmlspecialchars($row['donation_center']); ?></td>
                    <td><?php echo htmlspecialchars($row['donation_id']); ?></td>
                    <td>

                        <a href="cancelappointment.php?uuid=<?php echo urlencode($_GET['uuid']); ?>&id=<?php echo urlencode($row['appointment_id']); ?>"
                           onclick="return confirm('Are you sure you want to delete this appointment?');">Cancel Appointment</a>
                    
                        
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>You have no scheduled appointments.</p>
    <?php endif; ?>

    <h3>
        <a href="scheduleappointment.php">Schedule New Appointment</a> |
        <a href="../homepage.php">Home</a>
    </h3>
    <footer>
        <p>&copy; 2024 Your Company | <a href="#">Privacy Policy</a></p>
    </footer>
</body>
</html>
