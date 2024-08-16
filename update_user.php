<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Donor Information</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="favicon.ico">
</head>
<body>
<header>
    <div class="header-buttons">
        <button class="nav-button" onclick="location.href='admin_home.php'">Home</button>
    </div>
</header>

<hr class="separator">

<main>
    <div class="form-container">
        <form action="admin_home.php" method="post">
            <h2>Update Donor Information</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="Rohith Sharma" required>
            <label for="ssn">SSN:</label>
            <input type="text" id="ssn" name="ssn" value="123-45-6789" required>
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first_name" value="Rohith" required>
            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last_name" value="Sharma" required>
            <label for="street">Street:</label>
            <input type="text" id="street" name="street" value="123 Elm St" required>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="Springfield" required>
            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="IL" required>
            <label for="zip">Zip:</label>
            <input type="text" id="zip" name="zip" value="62704" required>
            <label for="blood-type">Blood Type:</label>
            <select id="blood-type" name="blood_type" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="rohithsharma@gmail.com" required>
            <label for="emergency-contact">Emergency Contact:</label>
            <input type="text" id="emergency-contact" name="emergency_contact" value="Virat Kohli" required>
            <input type="submit" value="Update">
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
