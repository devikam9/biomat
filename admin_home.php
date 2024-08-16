<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
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
    <div class="table-container">
        <h2>Donor Information</h2>
        <table>
            <thead>
                <tr>
                    <th>Donor ID</th>
                    <th>SSN</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Gender</th>
                    <th>Blood Type</th>
                    <th>Email</th>
                    <th>Emergency Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                require_once 'login.php';

                
                // SQL query to fetch donor details along with user first name and last name
                $sql = "SELECT 
                            donor.donor_id,
                            donor.donor_ssn,
                            donor.street,
                            donor.city,
                            donor.state,
                            donor.zip,
                            donor.gender,
                            donor.bloodtype,
                            donor.email,
                            donor.emergencycontact,
                            user.firstname,
                            user.lastname
                        FROM 
                            donor
                        JOIN 
                            user
                        ON 
                            donor.uuid = user.uuid";

                            
                            

                $result = mysqli_query($connection, $sql);

                if (!$result) {
                    die("Error fetching donation centers: " . mysqli_error($connection));
                }

                // $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['donor_id']) . "</td>
                                <td>" . htmlspecialchars($row['donor_ssn']) . "</td>
                                <td>" . htmlspecialchars($row['firstname']) . "</td>
                                <td>" . htmlspecialchars($row['lastname']) . "</td>
                                <td>" . htmlspecialchars($row['street']) . "</td>
                                <td>" . htmlspecialchars($row['city']) . "</td>
                                <td>" . htmlspecialchars($row['state']) . "</td>
                                <td>" . htmlspecialchars($row['zip']) . "</td>
                                <td>" . htmlspecialchars($row['gender']) . "</td>
                                <td>" . htmlspecialchars($row['bloodtype']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['emergencycontact']) . "</td>
                                <td>
                                    
                                    <button class='action-button' onclick=\"location.href='deleteuser.php?id=" . htmlspecialchars($row['donor_id']) . "'\">Delete</button>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No records found</td></tr>";
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
    h2 {
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
