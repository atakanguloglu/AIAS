<?php

// K katsayısını hesaplayan fonksiyon
function calculateKValue($title) {
    switch ($title) {
        case "Prof. Dr.":
            return 1;
        case "Doç. Dr.":
            return 0.8;
        case "Dr. Öğr. Üyesi.":
            return 0.6;
        case "Öğr. Gör.":
            return 0.4;
        case "Arş. Gör.":
            return 0.2;
        default:
            return 0;
    }
}

// Puanı hesaplayan fonksiyon
function calculateScore($activity, $coefficient, $incentive_point) {
    switch ($activity) {
        case "Yayın":
            $score = calculatePublicationScoreByPersons($coefficient, $incentive_point);
            break;
        case "Tasarım":
        case "Sergi":
            $score = calculateDesignOrExhibitionScore($activity, $coefficient);
            break;
        case "Patent":
            // Patent puanı hesaplayan fonksiyon buraya eklenecek
            break;
        case "Atıf":
            // Atıf puanı hesaplayan fonksiyon buraya eklenecek
            break;
        default:
            $score = 0;
            break;
    }
    return $score;
}

// Yayın puanını kişi sayısına göre hesaplayan fonksiyon
function calculatePublicationScoreByPersons($coefficient, $persons) {
    switch ($incentive_point) {
        case 1:
            $score = $coefficient * 1;
            break;
        case 2:
            $score = $coefficient * 0.6;
            break;
        case 3:
            $score = $coefficient * 0.4;
            break;
        case 4:
            $score = $coefficient * 0.3;
            break;
        default:
            $score = $coefficient / $persons;
            break;
    }
    return $score;
}

// Tasarım ve Sergi puanını hesaplayan fonksiyon
function calculateDesignOrExhibitionScore($activity, $coefficient) {
    switch ($activity) {
        case "Tasarım":
            return $coefficient * 20;
        case "Sergi":
            return $coefficient * 40;
        default:
            return 0;
    }
}

function calculatePatentScore($academic_activity_type, $coefficient) {
    switch ($academic_activity_type) {
        case "Uluslararası Patent":
            return $coefficient * 120;
        case "Ulusal Patent":
            return $coefficient * 100;
        case "Uluslararası Faydalı Model":
            return $coefficient * 80;
        case "Ulusal Faydalı Model":
            return $coefficient * 60;
        default:
            return 0;
    }
}


function calculateCitationScore($academic_activity_type, $coefficient) {
    switch ($academic_activity_type) {
        case "SCI":
        case "SCI-Expanded":
        case "SSCI":
        case "AHCI":
            return $coefficient * 1;
        case "Alan Endeksleri":
            return $coefficient * (3/4);
        case "Diğer Uluslararası Dergiler":
            return $coefficient * (1/2);
        case "ULAKBİM":
            return $coefficient * (1/4);
        // Diğer durumlar için gerekli işlemler burada eklenecek
        default:
            return 0;
    }
}


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

// Check if the table exists
$table_name = "tesvik"; // Replace with your table name
$table_check_query = "SHOW TABLES LIKE '$table_name'";
$table_result = $conn->query($table_check_query);

if ($table_result->num_rows == 0) {
    // Table does not exist, create it
    $sql = "CREATE TABLE $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        surname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        title VARCHAR(50),
        faculty VARCHAR(50),
        department VARCHAR(50),
        basic_field VARCHAR(50),
        scientific_field VARCHAR(50),
        academic_activity_type VARCHAR(50),
        activity VARCHAR(100),
        work_name VARCHAR(100),
        persons DECIMAL(10,2),
        coefficient DECIMAL(10,2),
        incentive_point DECIMAL(10,2),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    // Execute the query to create table
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

    
    // Insert data from POST request into the table
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $title = $_POST["title"];
        $faculty = $_POST["faculty"];
        $department = $_POST["department"];
        $basic_field = $_POST["basic_field"];
        $scientific_field = $_POST["scientific_field"];
        $academic_activity_type = $_POST["academic_activity_type"];
        $activity = $_POST["activity"];
        $work_name = $_POST["work_name"];
        $persons = $_POST["persons"];
        // $coefficient = $_POST["coefficient"];
        // $incentive_point = $_POST["incentive_point"];

        // K katsayısını hesaplayın
        $coefficient = calculateKValue($title);

        // Puanı hesaplayın
        $incentive_point = calculateScore($activity, $coefficient, $persons);

        // SQL query to insert data into the table
        $insert_query = "INSERT INTO $table_name (name, surname, email, title, faculty, department, basic_field, scientific_field, academic_activity_type, activity, work_name, persons, coefficient, incentive_point ) VALUES ('$name', '$surname', '$email', '$title', '$faculty', '$department', '$basic_field', '$scientific_field', '$academic_activity_type', '$activity', '$work_name', '$persons', '$coefficient', '$incentive_point')";

        if ($conn->query($insert_query) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    }


// Close the connection
$conn->close();
?>
