<?php
// Check if the ID parameter exists and is valid
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
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

    // Prepare and execute SQL to delete row with the specified ID
    $id = $_POST['id'];
    $sql = "DELETE FROM tesvik WHERE id = $id"; // Replace 'tesvik' with your actual table name
    if ($conn->query($sql) === TRUE) {
        echo "Row deleted successfully";
    } else {
        echo "Error deleting row: " . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    echo "Invalid ID parameter";
}
?>