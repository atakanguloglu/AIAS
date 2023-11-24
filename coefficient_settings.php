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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div>
        <h1>Coefficient Settings</h1>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Coefficient Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($coefficients as $coefficient): ?>
                        <tr>
                            <td><?php echo $coefficient['id']; ?></td>
                            <td>
                                <input type="number" step="0.01" name="coefficients[<?php echo $coefficient['id']; ?>]"
                                    value="<?php echo $coefficient['value']; ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>

</html>