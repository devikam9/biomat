<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
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
        
        <h2>Signup</h2>
        <form action="singup3.php" method="post">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="Firstname" required>
            
            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="Lastname" required>
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="donor">Donor</option>
                <option value="personnel">Personnel</option>
            </select>
            <br>
            <br>
            <!-- <button type="button" class="register-button" onclick="window.location.href='singup3.php'"> Signup</button> -->
            <input type='submit' value='Add User'>
            
        </form>
        
        
    </div>
</body>
</html>

<?php

require_once 'login.php'; // Database credentials
require_once 'sanitize.php'; // Sanitization functions



$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);
if (isset($_POST['username'])) {
    

    $first_name = sanitize($conn, $_POST['Firstname']);
    $last_name = sanitize($conn, $_POST['Lastname']);
    $username = sanitize($conn, $_POST['username']);
    $password = sanitize($conn, $_POST['password']);
    $role = sanitize($conn, $_POST['role']);
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $uuid = generate_uuid_v4();

    
    // Prepare the SQL query
    $query = "INSERT INTO user (uuid,username, password, firstname, lastname, role) VALUES ('$uuid','$username', '$hashed_password','$first_name','$last_name' ,'$role')";
    $result = $conn->query($query);
    if(!$result) die($conn->error);

   
        echo "User $username successfully added <br>";
        header("Location: signin.php");
   
}

function generate_uuid_v4() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// Generate a UUID v4


$conn->close();
?>
