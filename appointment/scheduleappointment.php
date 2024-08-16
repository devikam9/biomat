<?php
require_once '../login.php';

echo "<a href='../logout.php' class='logout-button'>Logout</a> <br> <br>";

if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
    
    // Sanitize UUID to prevent SQL Injection
    $uuid = mysqli_real_escape_string($connection, $uuid);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $donation_center = $_POST['donation_center'];
    $donor_ssn = $_POST['donor_ssn'];
    $donation_id = $_POST['donation_id'];

    $today = date('Y-m-d');

    if ($date < $today) {
        $error_message = "You cannot book an appointment for a past date.";
    } else {
        $time_parts = explode(':', $time);
        $hours = (int)$time_parts[0];
        $minutes = (int)$time_parts[1];

        if ($hours < 9 || $hours > 16 || ($hours == 16 && $minutes > 0)) {
            $error_message = "Appointments can only be scheduled between 9:00 AM and 4:00 PM.";
        } elseif ($minutes % 30 !== 0) {
            $error_message = "Appointments can only be scheduled at 30-minute intervals.";
        } else {
            // Check if the selected time slot is already booked
            $query_check = "SELECT * FROM appointment WHERE date=? AND time=? AND donation_center=?";
            $stmt = $connection->prepare($query_check);
            $stmt->bind_param('sss', $date, $time, $donation_center);
            $stmt->execute();
            $result_check = $stmt->get_result();

            if ($result_check->num_rows > 0) {
                $error_message = "The selected slot is already booked. Please choose another time.";
                
                // Fetch available times
                $available_times = [];
                for ($hour = 9; $hour <= 16; $hour++) {
                    for ($minute = 0; $minute < 60; $minute += 30) {
                        $formatted_hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
                        $formatted_minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
                        $formatted_time = "$formatted_hour:$formatted_minute";
                        $query_check = "SELECT * FROM appointment WHERE date=? AND time=? AND donation_center=?";
                        $stmt = $connection->prepare($query_check);
                        $stmt->bind_param('sss', $date, $formatted_time, $donation_center);
                        $stmt->execute();
                        $result_check = $stmt->get_result();
                        if ($result_check->num_rows == 0) {
                            $available_times[] = $formatted_time;
                        }
                    }
                }
            } else {
                // Insert new appointment
                $query = "INSERT INTO appointment (date, time, donation_center, uuid, donation_id) 
                          VALUES ('$date', '$time', '$donation_center', '$uuid', '$donation_id')";
                // $stmt = $connection->prepare($query);
                // $stmt->bind_param('sssss', $date, $time, $donation_center, $donor_ssn, $donation_id);

                if (queryMysql($query)) {
                    echo "Appointment scheduled for " . htmlspecialchars($date) . " at " . htmlspecialchars($time);
                    header("Location: scheduleappointment.php?uuid=$uuid");
                    exit();
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($connection);
                }
            }
        }
    }
} // <- Added closing brace here for the POST request handling

// Fetch donation centers
$query_centers = "SELECT donation_center, city FROM donation_center";
$result_centers = $connection->query($query_centers);

if ($result_centers === false) {
    die("Error: " . $connection->error);
}

$donation_centers = [];
while ($row = $result_centers->fetch_assoc()) {
    $donation_centers[$row['city']] = $row['donation_center'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
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
        input[type="text"], input[type="email"], input[type="number"], input[type="date"], select {
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
        h3 a {
            color: #30669A;
            text-decoration: none;
            margin: 0 10px;
        }
        h3 a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-buttons">
            <button class="nav-button" onclick="location.href='./viewappointment.php?uuid=<?php echo urlencode($uuid); ?>'">View Appointments</button>
            <button class="nav-button" onclick="location.href='./viewappointment.php?uuid=<?php echo urlencode($uuid); ?>'">Cancel Appointment</button>
            
        </div>
    </header>

    <hr class="separator">

    <main>
        <div class="form-container">
            <h2>Schedule Appointment</h2>

            <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <form method='post' action=''>

                Date: <input type='date' name='date' min='<?php echo date('Y-m-d'); ?>' required><br>

                Time:
                <select name='time' required>
                    <?php
                    if (isset($available_times)) {
                        foreach ($available_times as $time_option) {
                            $formatted_hour = substr($time_option, 0, 2);
                            $formatted_minute = substr($time_option, 3, 2);
                            $period = ($formatted_hour < 12) ? "AM" : "PM";
                            $formatted_hour = ($formatted_hour % 12) ?: 12; // Convert to 12-hour format
                            echo "<option value='$time_option'>$formatted_hour:$formatted_minute $period</option>";
                        }
                    } else {
                        for ($hour = 9; $hour <= 16; $hour++) {
                            for ($minute = 0; $minute < 60; $minute += 30) {
                                $formatted_hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                $formatted_minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                $formatted_time = "$formatted_hour:$formatted_minute";
                                $period = ($hour < 12) ? "AM" : "PM";
                                $display_hour = ($hour % 12) ?: 12; // Convert to 12-hour format
                                echo "<option value='$formatted_time'>$display_hour:$formatted_minute $period</option>";
                            }
                        }
                    }
                    ?>
                </select><br>

                Donation Center:
                <select name='donation_center' required>
                    <?php foreach ($donation_centers as $city => $id): ?>
                <option value='<?php echo $id; ?>'><?php echo htmlspecialchars($city); ?></option>
            <?php endforeach; ?>
                </select><br>

                
                Donation ID: <input type='text' name='donation_id' required><br>

                <input type='submit' value='Schedule Appointment'>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Your Company | <a href="#">Privacy Policy</a></p>
    </footer>
</body>
</html>
