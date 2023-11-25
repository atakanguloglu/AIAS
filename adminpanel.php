<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to the signin page
    header("Location: signin.php");
    exit();
}

require_once "db_connection.php";

// Retrieve user details based on user_id stored in the session
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$userId'";
$result = $conn->query($sql);

$userInfo = "";
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    // Display current user information
    $userInfo = "Hoş geldiniz, " . $user['phone'];
}

// Fetch data from the database
$sql = "SELECT * FROM tesvik"; // Replace 'tesvik' with your actual table name
$result = $conn->query($sql);

$dataTable = "";
if ($result->num_rows > 0) {
    // Output data in a table
    $dataTable .= "<table id='example' class='table table-striped' style='width:100%'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Akademik Faaliyet Türü</th>
                <th>Faaliyet</th>
                <th>Teşvik Puanı</th>
                <!-- Add more columns based on your table structure -->
            </tr>
        </thead>
        <tbody>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $dataTable .= "<tr>
            <td>" . $row["id"] . "</td>
            <td>" . $row["name"] . "</td>
            <td>" . $row["surname"] . "</td>
            <td>" . $row["academic_activity_type"] . "</td>
            <td>" . $row["activity"] . "</td>
            <td>" . $row["incentive_point"] . "</td>
            <!-- Add more columns based on your table structure -->
        </tr>";
    }

    $dataTable .= "</tbody></table>";
} else {
    $dataTable = "No data available";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik Teşvik</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/main.css">

    <style>
        body {
            margin: 20px;
        }

        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .navbar {
            margin-bottom: 20px;
        }

        .responseDiv {
            margin-bottom: 20px;
        }

        .text-end {
            margin-bottom: 20px;
            text-align: right;
        }

        table {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <img src="img/logo-kucuk.png" width="140">
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="responseDiv">
                    <?php echo $userInfo; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-end">
                    <a href="settings.php" class="btn btn-primary">Ayarlar</a>
                </div>
            </div>
        </div>

        <div class="logout-btn">
            <a href="signout.php" class="btn btn-danger">Çıkış Yap</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php echo $dataTable; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/panel.js"></script>
</body>

</html>