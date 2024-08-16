<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }
        .login-container img {
            max-width: 120px;
            margin-bottom: 20px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container form label {
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
            text-align: left;
        }
        .login-container form input {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        .login-container form button {
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .login-container form button:hover {
            background-color: #0056b3;
        }
        .login-container .register-button {
            background-color: #28a745;
            margin-top: 10px; /* Add spacing between the buttons */
        }
        .login-container .register-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="images/biomat_logo.png" alt="Biomat USA Logo">
        <h2>Login</h2>
        <form action="signin.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type='submit' value='Login'>
            
            <button type="button" class="register-button" onclick="window.location.href='signup.php'">Register as a new donor</button>
        </form>
    </div>
</body>
</html>


<?php

require_once 'login.php';
require_once 'sanitize.php';

// Create a new database connection
$conn = new mysqli($hn, $un, $pw, $db);

// Check for connection errors
if ($conn->connect_error) die($conn->connect_error);

if (isset($_POST['username']) && isset($_POST['password'])) {

    // Sanitize input values
    $tmp_username = sanitize($conn, $_POST['username']);
    $tmp_password = sanitize($conn, $_POST['password']);
    
    // Prepare the SQL query
    $query = "SELECT password, role, uuid FROM user WHERE username = '$tmp_username'";
    
    // Execute the query
    $result = $conn->query($query); 

    // Check for query execution errors
    if (!$result) die($conn->error);
    
    // Get the number of rows returned
    $rows = $result->num_rows;
    
    // Initialize variable to hold the password and role from the database
    $passwordFromDB = "";
    $roleFromDB = "";

    // Fetch the result
    if ($rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if (is_array($row)) {
            $passwordFromDB = $row['password'];
            $roleFromDB = $row['role'];
            $uuidFromDB = $row['uuid'];
            
            // Compare passwords
            if (password_verify($tmp_password, $passwordFromDB)) {
                if ($roleFromDB === 'admin') {
                    header("Location: admin_home.php");
                } else if ($roleFromDB === 'donor') {
                    // Check if the donor exists in the donor table
                    $donor_query = "SELECT * FROM donor WHERE uuid = '$uuidFromDB'";
                    $donor_result = $conn->query($donor_query);
                    
                    if (!$donor_result) die($conn->error);
                    
                    if ($donor_result->num_rows > 0) {
                        header("Location: view_donor.php?uuid=$uuidFromDB");
                    } else {
                        header("Location: addDonordetails.php?uuid=$uuidFromDB");
                    }
                } else if ($roleFromDB === 'personnel') {
                    header("Location: ./personnel/addpersonnel.php");
                } else {
                    echo "Invalid role<br>";
                }
                
            } else {
                echo "Login error<br>";
            }
        } else {
            echo "Failed to retrieve user data.";
        }
    } else {
        echo "No user found<br>";
    }
    
    // Free result set
    $result->free();
}

// Close the database connection
$conn->close();

?>
