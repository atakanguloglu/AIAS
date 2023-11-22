<?php
// Assuming your database connection is established
// Database connection details
$servername = "localhost"; // Change this if your database is on a different server
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "aias"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if it's a GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch data from the database
    $sql = "SELECT * FROM aias"; // Replace 'your_table' with your actual table name
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data in a table
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <!-- Add more columns based on your table structure -->
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["surname"] . "</td>
                    <!-- Add more columns based on your table structure -->
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No data available";
    }
}
?>
