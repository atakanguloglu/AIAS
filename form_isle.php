<?php

// K katsayısını hesaplayan fonksiyon
function calculateKValue($academicTitle) {
    switch ($academicTitle) {
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
function calculateScore($activityType, $k, $persons) {
    switch ($activityType) {
        case "Yayın":
            $score = calculatePublicationScoreByPersons($k, $persons);
            break;
        case "Tasarım":
        case "Sergi":
            $score = calculateDesignOrExhibitionScore($activityType, $k);
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
function calculatePublicationScoreByPersons($k, $persons) {
    switch ($persons) {
        case 1:
            $score = $k * 1;
            break;
        case 2:
            $score = $k * 0.6;
            break;
        case 3:
            $score = $k * 0.4;
            break;
        case 4:
            $score = $k * 0.3;
            break;
        default:
            $score = $k / $persons;
            break;
    }
    return $score;
}

// Tasarım ve Sergi puanını hesaplayan fonksiyon
function calculateDesignOrExhibitionScore($activityType, $k) {
    switch ($activityType) {
        case "Tasarım":
            return $k * 20;
        case "Sergi":
            return $k * 40;
        default:
            return 0;
    }
}

function calculatePatentScore($patentType, $k) {
    switch ($patentType) {
        case "Uluslararası Patent":
            return $k * 120;
        case "Ulusal Patent":
            return $k * 100;
        case "Uluslararası Faydalı Model":
            return $k * 80;
        case "Ulusal Faydalı Model":
            return $k * 60;
        default:
            return 0;
    }
}


function calculateCitationScore($citationType, $k) {
    switch ($citationType) {
        case "SCI":
        case "SCI-Expanded":
        case "SSCI":
        case "AHCI":
            return $k * 1;
        case "Alan Endeksleri":
            return $k * (3/4);
        case "Diğer Uluslararası Dergiler":
            return $k * (1/2);
        case "ULAKBİM":
            return $k * (1/4);
        // Diğer durumlar için gerekli işlemler burada eklenecek
        default:
            return 0;
    }
}


// Form verilerini işleyin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Bağlantı kurun
    $conn = new mysqli('localhost', 'root', '', 'akademik_tesvik');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Form verilerini alın
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $academicTitle = $_POST['academicTitle'];
    $faculty = $_POST['faculty'];
    $department = $_POST['department'];
    $basicArea = $_POST['basicArea'];
    $scientificArea = $_POST['scientificArea'];
    $academicActivityType = $_POST['academicActivityType'];
    $activityType = $_POST['activityType'];
    $workName = $_POST['workName'];
    $persons = $_POST['persons']; // Eksik olduğu için ekledim, formda bir yerde veri alındığını varsaydım.

    // K katsayısını hesaplayın
    $k = calculateKValue($academicTitle);

    // Puanı hesaplayın
    $score = calculateScore($activityType, $k, $persons);

    // Veritabanına verileri ekle
    $sql = "INSERT INTO academic_activities (name, surname, academic_title, faculty, department, basic_area, scientific_area, academic_activity_type, activity_type, work_name, k_value, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssdd", $name, $surname, $academicTitle, $faculty, $department, $basicArea, $scientificArea, $academicActivityType, $activityType, $workName, $k, $score);
    $stmt->execute();

    // Başarı mesajı göster
    echo "Akademik teşvik başvurunuz başarıyla gönderildi.";

    $stmt->close();
    $conn->close();
} else {
    echo "Geçersiz istek.";
}
?>
