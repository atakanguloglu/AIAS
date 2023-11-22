<?php
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
// Check if the users table exists, if not, create it
$table_name = "users";
$table_check_query = "SHOW TABLES LIKE '$table_name'";
$table_result = $conn->query($table_check_query);

if ($table_result->num_rows == 0) {
    // Table does not exist, create it
    $create_table_query = "CREATE TABLE $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        phone VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL
        -- Add more columns as needed
    )";

    if ($conn->query($create_table_query) === TRUE) {
        // Table created successfully
    } else {
        // Error creating table
        echo "Error creating table: " . $conn->error;
    }
}
?>
