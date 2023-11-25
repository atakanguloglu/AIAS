<?php
// Check if the form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required form fields are present and valid
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

        // Get form data
        $id = $_POST['id'];
        $name = $_POST['name']; // Replace 'name' with the actual field name
        // Add more fields as necessary
        // Prepare and execute SQL to update row with the specified ID
        $sql = "UPDATE tesvik SET name = '$name' WHERE id = $id"; // Replace 'tesvik' and 'name' with your actual table and field names
        if ($conn->query($sql) === TRUE) {
            echo "Row updated successfully";
        } else {
            echo "Error updating row: " . $conn->error;
        }

        // Close database connection
        $conn->close();
    } else {
        echo "Invalid form data received";
    }
} else {
    echo "Invalid request method";
}
?>