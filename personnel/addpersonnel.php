<?php
require_once '../login.php'; // Database credentials

// Display logout button


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    // Collect form data
    $SSN = $_POST['SSN'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $contact = $_POST['contact'];
    $donation_center = $_POST['donation_center'];

    // Prepare the SQL query for insertion
    $query = "INSERT INTO personnel (SSN, firstname, lastname, position, contact, donation_center) 
              VALUES ('$SSN', '$firstname', '$lastname', '$position', '$contact', '$donation_center')";

    if (queryMysql($query)) {
        echo " Medical personnel added successfully.";
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
    <title>Add Medical Personnel</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <div class="header-buttons">
        <button class="nav-button" onclick="location.href='signin.php'">Logout</button>
        <button class="nav-button" onclick="location.href='../donationcenter/createdonationcenter.php'">Manage Donation Centers</button>
    </div>
</header>

<hr class="separator">

<main>
    <div class="form-container">
        <h2>Add Medical Personnel</h2>
        <form method="post" action="">
            <input type="text" name="SSN" placeholder="SSN" required>
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="text" name="position" placeholder="Position">
            <input type="text" name="contact" placeholder="Contact Number">
            <input type="number" name="donation_center" placeholder="Donation Center" required>
            <input type="submit" name="create" value="Add Personnel">
        </form>
        <br>
        <a href="viewpersonnel.php">View Medical Personnel</a>
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
    h2 {
        margin-bottom: 20px;
        color: #30669A;
        text-align: center;
    }
    form {
        display: flex;
        flex-direction: column;
    }
    input[type="text"], input[type="number"], input[type="submit"] {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    input[type="submit"] {
        background-color: #30669A;
        color: white;
        border: none;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #245680;
    }
    a {
        color: #30669A;
        text-align: center;
        display: block;
        margin-top: 10px;
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

<?php
// Close database connection
mysqli_close($connection);
?>
