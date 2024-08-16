<?php
require_once '../login.php'; // Database credentials

// Display logout button


// Fetch all medical personnel
$query = "SELECT * FROM personnel";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Error fetching medical personnel: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Medical Personnel</title>
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
    <div class="table-container">
        <h1>Medical Personnel List</h1>

        <table>
            <thead>
                <tr>
                    <th>Personnel ID</th>
                    <th>SSN</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Contact</th>
                    <th>Donation Center ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['personnel_id']) . "</td>
                            <td>" . htmlspecialchars($row['SSN']) . "</td>
                            <td>" . htmlspecialchars($row['firstname']) . "</td>
                            <td>" . htmlspecialchars($row['lastname']) . "</td>
                            <td>" . htmlspecialchars($row['position']) . "</td>
                            <td>" . htmlspecialchars($row['contact']) . "</td>
                            <td>" . htmlspecialchars($row['donation_center']) . "</td>
                            <td>
                                <a href='updatepersonnel.php?SSN=" . urlencode($row['SSN']) . "'>Update</a> | 
                                <a href='deletepersonnel.php?SSN=" . urlencode($row['SSN']) . "' onclick=\"return confirm('Are you sure you want to delete this personnel?');\">Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
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
    .table-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        max-width: 1200px;
        margin: 0 auto;
    }
    h1 {
        margin-bottom: 20px;
        color: #30669A;
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }
    th {
        background-color: #30669A;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .action-button {
        margin: 0 5px;
        padding: 5px 10px;
        background-color: white;
        color: #30669A;
        border: 1px solid #30669A;
        border-radius: 5px;
        cursor: pointer;
    }
    .action-button:hover {
        background-color: #ddd;
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
