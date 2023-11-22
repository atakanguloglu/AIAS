<?php
// Assuming $conn is the database connection
// Database connection details
$servername = "localhost"; // Change this if your database is on a different server
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "aias"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


$tableName = "activities";

// Check if the table exists
$checkTableQuery = "SHOW TABLES LIKE '$tableName'";
$tableExists = $conn->query($checkTableQuery);

if ($tableExists->num_rows === 0) {
    // Table does not exist, create it
    $createTableQuery = "CREATE TABLE $tableName (
        id INT AUTO_INCREMENT PRIMARY KEY,
        academic_activity_type VARCHAR(100) NOT NULL, 
        activity_id VARCHAR(50) NOT NULL,
        description TEXT NOT NULL
    )";

    if ($conn->query($createTableQuery) === TRUE) {
        echo "Table '$tableName' created successfully";
        $activities = [

            'Yayın' => [
                ['1.1.a', 'WoS Quartile Q1'],
                ['1.1.b', 'WoS Quartile Q2'],
                ['1.1.c', 'WoS Quartile Q3'],
                ['1.1.d', 'WoS Quartile Q4'],
                ['1.2.a', 'SCOPUS Quartile Q1'],
                ['1.2.b', 'SCOPUS Quartile Q2'],
                ['1.2.c', 'SCOPUS Quartile Q3'],
                ['1.2.d', 'SCOPUS Quartile Q4'],
                [
                    '1.3.a',
                    'WoS tarafından taranan ESCI, ESSCI vb. gibi dergilerde yayımlanmış araştırma makalesi',
                ],
                [
                    '1.4.a',
                    'WoS ve SCOPUS tarafından taranan konferans (sempozyum) kitaplarında yayımlanmış araştırma makalesi',
                ],
                [
                    '1.5.a',
                    'Diğer uluslararası hakemli dergilerde yayımlanmış araştırma makalesi',
                ],
                [
                    '1.6.a',
                    'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergilerde yayımlanmış araştırma makalesi',
                ],
                [
                    '1.7.a',
                    'Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitap',
                ],
                [
                    '1.8.a',
                    'Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitaplarda bölüm yazarlığı',
                ],
                [
                    '1.9.a',
                    'Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitap',
                ],
                [
                    '1.10.a',
                    'Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitaplarda bölüm',
                ],
            ],
            'Tasarım' => [
                [
                    '2.1.a',
                    'Endüstriyel, çevresel veya grafiksel tasarım; sahne, moda veya çalgı tasarımı',
                ],
            ],
            'Sergi' => [
                ['3.1.a', 'Özgün yurtdışı bireysel etkinlik'],
                ['3.2.a', 'Özgün yurtiçi bireysel etkinlik'],
                ['3.3.a', 'Özgün yurtdışı grup/karma/toplu etkinlik'],
                ['3.4.a', 'Özgün yurtiçi grup/karma/toplu etkinlik'],
            ],
            'Patent' => [
                ['4.1.a', 'Uluslararası patent'],
                ['4.2.a', 'Ulusal patent'],
                ['4.3.a', 'Uluslararası Faydalı Model'],
                ['4.4.a', 'Ulusal Faydalı Model'],
            ],
            'Atıf' => [
                [
                    '5.1.a',
                    'SCI, SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde yayımlanmış makalelerde atıf',
                ],
                [
                    '5.2.a',
                    'Alan endeksleri (varsa) kapsamındaki dergilerde yayımlanmış makalelerde atıf',
                ],
                [
                    '5.3.a',
                    'Diğer uluslararası hakemli dergilerde yayımlanmış makalelerde atı',
                ],
                [
                    '5.4.a',
                    'ULAKBİM tarafından taranan ulusal hakemli dergilerde yayımlanmış makalelerde atıf',
                ],
                [
                    '5.5.a',
                    'Tanınmış uluslararası yayınevleri tarafından yayımlanmış özgün bilimsel kitapta atıf',
                ],
                [
                    '5.6.a',
                    'Tanınmış ulusal yayınevleri tarafından yayımlanmış özgün bilimsel kitapta atıf',
                ],
                [
                    '5.7.a',
                    'Güzel sanatlardaki eserlerin uluslararası kaynak veya yayın organlarında yer alması veya gösterime ya da dinletime girmesi',
                ],
                [
                    '5.8.a',
                    'Güzel sanatlardaki eserlerin ulusal kaynak veya yayın organlarında yer alması veya gösterime ya da dinletime girmesi',
                ],
            ],

        ];

        foreach ($activities as $academic_activity_type => $activityList) {
            foreach ($activityList as $activity) {
                $activityId = $activity[0];
                $description = $activity[1];

                $insertQuery = "INSERT INTO activities (academic_activity_type, activity_id, description) VALUES ('$academic_activity_type','$activityId', '$description')";
                $conn->query($insertQuery);
            }
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Table '$tableName' already exists";
}




// Handle form submission for updating or adding activities
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update_activity"])) {
        // Process the submitted form for updating activities

        foreach ($_POST["activity_id"] as $id => $activity_id) {
            $id = intval($id);
            $description = $_POST["description"][$id];
            $academic_activity_type = $_POST["academic_activity_type"][$id];
            // Update the activity in the database
            $updateQuery = "UPDATE activities SET activity_id = '$activity_id', description = '$description', academic_activity_type = '$academic_activity_type' WHERE id = $id";
            $conn->query($updateQuery);
        }

        // Redirect to the settings page or perform other actions
        header("Location: settings.php");
        exit();
    } elseif (isset($_POST["add_activity"])) {
        // Process the submitted form for adding a new activity

        $newActivityId = $_POST["new_activity_id"];
        $newDescription = $_POST["new_description"];
        $newAcademicActivityType = $_POST["new_academic_activity_type"];
        // Insert the new activity into the database
        $insertQuery = "INSERT INTO activities (academic_activity_type, activity_id, description) VALUES ('$newAcademicActivityType','$newActivityId', '$newDescription')";
        $conn->query($insertQuery);

        // Redirect to the settings page or perform other actions
        header("Location: settings.php");
        exit();
    }
}

// Fetch activities from the database
$selectQuery = "SELECT * FROM activities";
$result = $conn->query($selectQuery);

$activities = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Page</title>
</head>

<body>


    <h2>Akademik Faaliyetler</h2>
    <form action="" method="post">
        <table>
            <thead>
                <tr>
                    <th>Akademik Faaliyet Türü</th>
                    <th>Faaliyet Id</th>
                    <th>Faaliyet</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $activity): ?>
                    <tr>
                        <td>
                            <input type="text" name="academic_activity_type[<?php echo $activity['id']; ?>]"
                                value="<?php echo $activity['academic_activity_type']; ?>" required>
                        </td>
                        <td>
                            <input type="text" name="activity_id[<?php echo $activity['id']; ?>]"
                                value="<?php echo $activity['activity_id']; ?>" required>

                        </td>
                        <td>
                            <textarea name="description[<?php echo $activity['id']; ?>]"
                                required><?php echo $activity['description']; ?></textarea>
                        </td>
                        <td>
                            <button type="submit" name="update_activity[<?php echo $activity['id']; ?>]">
                                Update
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </form>
    <form action="" method="post">

        <h2>Add New Activity</h2>
        <div>
            <label for="new_academic_activity_type">Yeni Akademik Faaliyet Türü:</label>
            <input type="text" name="new_academic_activity_type" required>
            <label for="new_activity_id">Yeni Faaliyet Id:</label>
            <input type="text" name="new_activity_id" required>

            <label for="new_description">Yeni Faaliyet:</label>
            <textarea name="new_description" required></textarea>
        </div>
        <button type="submit" name="add_activity">Faaliyet Ekle</button>
    </form>


</body>

</html>