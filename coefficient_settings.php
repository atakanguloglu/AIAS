<?php
// Connect to your database
// Database connection details
$servername = "localhost"; // Change this if your database is on a different server
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "aias"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$tableCheckQuery = "SHOW TABLES LIKE 'katsayı'";
$tableResult = $conn->query($tableCheckQuery);
if ($tableResult->num_rows == 0) {
    // Table does not exist, create it
    $createTableQuery = "CREATE TABLE katsayı (
    id INT AUTO_INCREMENT PRIMARY KEY,
    value DECIMAL(10, 2)
)";
    if ($conn->query($createTableQuery) === TRUE) {
        // Table created successfully, insert values
        $insertValuesQuery = "INSERT INTO katsayı (value) VALUES (1), (0.6), (0.4), (0.3)";
        if ($conn->query($insertValuesQuery) === TRUE) {
            echo "Values inserted into katsayı table successfully.";
        } else {
            echo "Error inserting values: " . $conn->error;
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Table katsayı already exists.";
}

// Fetch coefficient values from the database
$sql = "SELECT * FROM katsayı";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $coefficients = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No coefficients found.";
}

// Update coefficients when form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST['coefficients'] as $id => $value) {
        $value = floatval($value);
        $updateSql = "UPDATE katsayı SET value = $value WHERE id = $id";
        $conn->query($updateSql);
    }
    // Redirect to settings page to reflect changes
    header("Location: settings.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Coefficient Settings</title>
</head>

<body>
    <h1>Coefficient Settings</h1>
    <form method="post">
        <table>
            <tr>
                <th>ID</th>
                <th>Coefficient Value</th>
            </tr>
            <?php foreach ($coefficients as $coefficient): ?>
                <tr>
                    <td>
                        <?php echo $coefficient['id']; ?>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="coefficients[<?php echo $coefficient['id']; ?>]"
                            value="<?php echo $coefficient['value']; ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Save Changes</button>
    </form>
</body>

</html>