<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Center Management</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="favicon.ico">
</head>
<body>
<header>
    <div class="header-buttons">
        <button class="nav-button" onclick="location.href='signin.php'">Logout</button>
        <button class="nav-button" onclick="location.href='./donationcenter/createdonationcenter.php'">Manage Donation Centers</button>
    </div>
</header>

<hr class="separator">

<main>
    <div class="form-container">
        <h1>Manage Donation Centers</h1>

        <h2>Create Donation Center</h2>
        <form method="post">
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="street" placeholder="Street">
            <input type="text" name="state" placeholder="State">
            <input type="text" name="contact_details" placeholder="Contact Number">
            <input type="text" name="zip_code" placeholder="Zipcode">
            <input type="text" name="email_address" placeholder="Email">
            <input type="submit" name="create" value="Create">
        </form>

        <h2>Update Donation Center</h2>
        <form method="post">
            <input type="hidden" name="action" value="update">
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="street" placeholder="Street">
            <input type="text" name="state" placeholder="State">
            <input type="text" name="contact_details" placeholder="Contact Number">
            <input type="text" name="zip_code" placeholder="Zipcode">
            <input type="text" name="email_address" placeholder="Email">
            <input type="submit" value="Update">
        </form>

        <h2>View Donation Centers</h2>
        <form method="get" action="viewdonationcenter.php">
            <input type="submit" value="View All Donation Centers">
        </form>

        <h2>Delete Donation Centers</h2>
        <form method="get" action="deletedonationcenter.php">
            <input type="submit" value="Delete Donation Centers">
        </form>

        <h1>Manage Medical Personnel</h1>

        <h2>Add Medical Personnel</h2>
        <form method="get" action="../personnel/addpersonnel.php">
            <input type="submit" value="Add a Medical Personnel">
        </form>
        <h2>View Medical Personnel</h2>
        <form method="get" action="../personnel/viewpersonnel.php">
            <input type="submit" value="View Personnel List">
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
        max-width: 800px;
        margin: 0 auto;
    }
    h1, h2 {
        margin-bottom: 20px;
        color: #30669A;
        text-align: center;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }
    input[type="text"], input[type="submit"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    input[type="submit"] {
        background-color: #30669A;
        color: white;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #28537A;
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
