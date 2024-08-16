<?php
// Database connection parameters
require_once 'login.php';


echo "hi 2 ";
// Check if UUID is provided in query parameters
if (isset($_GET['uuid'])) {
    $uuid = $_GET['uuid'];
    echo $uuid;
} else{
    echo "uuid is missing";
}

echo "hi in uuid";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo "enred";
// Sanitize and validate inputs
    $ssn = $_POST['ssn'];
    $gender = $_POST['gender'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $blood_type = $_POST['blood_type'];
    $email = $_POST['email'];
    $emergency_contact = $_POST['emergency_contact'];


    echo "hi in 3";
    // Prepare and bind SQL statement
    $query = "INSERT INTO donor (donor_ssn, gender, street, city, state, zip, bloodtype, email, emergencycontact, uuid) VALUES ('$ssn', '$gender', '$street','$city', '$state', '$zip', '$blood_type', '$email', '$emergency_contact','$uuid')";

    echo $query;

    if (queryMysql($query)) {
            
        echo "succesful";
        header("Location: view_donor.php?uuid=$uuid");
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Management</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="favicon.ico">
</head>
<body>
    <header>
        <div class="header-buttons">
            <button class="nav-button" onclick="location.href='homepage.php'">Home Page</button>
        </div>
    </header>

    <hr class="separator">

    <main>
        <div class="form-container">
            <form action="addDonorDetails.php?uuid=<?php echo urlencode($uuid); ?>" method="post">
                <h2>Enter Donor Details</h2>


                
                <label for="ssn">SSN:</label>
                <input type="text" id="ssn" name="ssn" required>
                 
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" required>
                
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" required>
                
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
                
                <label for="state">State:</label>
                <input type="text" id="state" name="state" required>
                
                <label for="zip">Zip:</label>
                <input type="text" id="zip" name="zip" required>
                
                <label for="blood-type">Blood Type:</label>
                <input type="text" id="blood-type" name="blood_type" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="emergency-contact">Emergency Contact:</label>
                <input type="text" id="emergency-contact" name="emergency_contact" required>
                
                <input type="submit" value="Submit">
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
            background-color: #30669A; /* Blue background color */
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

        input[type="text"], input[type="email"] {
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
            background-color: #30669A; /* Blue background color */
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


