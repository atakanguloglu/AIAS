<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    require_once "db_connection.php";

    // Retrieve user details based on user_id stored in the session
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Display current user information
        echo "Welcome, " . $user['phone'] . "<a href='signout.php'>Sign Out</a>";  // Display whatever user information you want
    }
} else {
    // If user is not logged in, you can redirect to the signin page or perform other actions
    header("Location: signin.php");
    exit();
}
?>
<?php
// Database connection details
$servername = "localhost"; // Replace with your server name if different
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "aias"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT * FROM tesvik"; // Replace 'your_table' with your actual table name
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <title>Akademik Teşvik</title>
    <link rel="stylesheet" href="css/main.css">
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



        <?php
        if ($result->num_rows > 0) {
            // Output data in a table
            echo "<table id='example' class='table table-striped' style='width:100%'>
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
        </thead>";
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["surname"] . "</td>
                <td>" . $row["academic_activity_type"] . "</td>
                <td>" . $row["activity"] . "</td>
                <td>" . $row["incentive_point"] . "</td>
                <!-- Add more columns based on your table structure -->
              </tr>";
            }
            echo "<tfoot></tfoot>";
            echo "</table>";
        } else {
            echo "No data available";
        }

        // Close the database connection
        $conn->close();
        ?>




    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/panel.js"></script>
</body>

</html>