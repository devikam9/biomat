<?php
require_once 'login.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $donation_center_id = $_POST['donation_center'];
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
            $stmt->bind_param('sss', $date, $time, $donation_center_id);
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
                        $stmt->bind_param('sss', $date, $formatted_time, $donation_center_id);
                        $stmt->execute();
                        $result_check = $stmt->get_result();
                        if ($result_check->num_rows == 0) {
                            $available_times[] = $formatted_time;
                        }
                    }
                }
            } else {
                // Insert new appointment
                $query = "INSERT INTO appointment (date, time, donation_center, donor_ssn, donation_id) 
                          VALUES (?, ?, ?, ?, ?)";
                $stmt = $connection->prepare($query);
                $stmt->bind_param('sssss', $date, $time, $donation_center_id, $donor_ssn, $donation_id);

                if ($stmt->execute()) {

                    echo "Appointment scheduled for " . $date . " at " . $time;

                    // header("Location: viewappointment.php");
                    exit();
                } else {
                    $error_message = "Error: " . $connection->error;
                }
            }
        }
    }
}

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
</head>
<body>
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
                        $display_hour = ($hour % 12) ?: 12;
                        echo "<option value='$formatted_time'>$display_hour:$formatted_minute $period</option>";
                    }
                }
            }
            ?>
        </select><br>

        Donation Center City:
        <select name='donation_center' required>
            <?php foreach ($donation_centers as $city => $id): ?>
                <option value='<?php echo $id; ?>'><?php echo htmlspecialchars($city); ?></option>
            <?php endforeach; ?>
        </select><br>

        Donor SSN: <input type='number' name='donor_ssn' required><br>
        Donation ID: <input type='number' name='donation_id' required><br>
        <input type='submit' value='Schedule Appointment'>
    </form>

    <h3>
    <a href="viewappointment.php"> view appointment </a> |
    <a href="updateappointment.php"> update appointment </a>|
    <a href="cancelappointment.php"> cancel appointment </a>
    </h3>
</body>
</html>
