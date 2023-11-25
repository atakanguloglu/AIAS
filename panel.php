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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <nav class="navbar navbar-default container d-flex">
        <div>
            <div class="navbar-header">
                <img src="img/logo-kucuk.png" width="140">
            </div>
        </div>
        <div class="text-end">
            <a href="settings.php" class="btn btn-primary">Ayarlar</a>
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
                <th>Kişi</th>
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
                <td>" . $row["persons"] . "</td>
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
    <!-- ... (Your existing HTML code) ... -->

    <!-- Modal for updating/deleting -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update/Delete Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Form fields to update data -->
                    <form id="updateForm">
                        <!-- Input fields to update values -->
                        <input type="hidden" id="rowId">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" required>
                        <!-- Add more fields as per your table structure -->
                        <!-- ... -->

                        <!-- Buttons to update or delete -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="js/panel.js"></script>
    <script>


        $('#example tbody').on('click', 'tr', function () {
            // Get the data from the clicked row
            var rowData = $('#example').DataTable().row(this).data();
            console.log(rowData);
            if (rowData) {
                // Populate modal with row data
                $('#rowId').val(rowData[0]);
                $('#name').val(rowData[1]);
                // Populate other fields similarly
                // Show the modal using Bootstrap 5 modal method
                // // Show the modal
                $('.modal').modal({
                    "backdrop": "static",
                    "show": true
                });
            }
        });


        // Function to handle delete button click
        $('#deleteBtn').on('click', function () {
            var rowId = $('#rowId').val(); // Get row ID from the hidden field
            // Send AJAX request to delete the row
            $.ajax({
                url: 'delete_row.php', // Replace with your PHP script to handle deletion
                method: 'POST',
                data: { id: rowId },
                success: function (response) {
                    // Refresh the page or update the table after deletion
                    $('#updateModal').modal('hide');
                    // location.reload(); // Reload the page for simplicity, you can update the table via AJAX too
                }, error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        });

        // Function to handle form submission for updating data
        $('#updateForm').on('submit', function (event) {
            event.preventDefault();
            var formData = $(this).serialize(); // Get form data

            // Send AJAX request to update the row
            $.ajax({
                url: 'update_row.php', // Replace with your PHP script to handle update
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success (e.g., close modal, refresh table)
                    $('#updateModal').modal('hide'); // Hide the modal after update
                    // location.reload(); // Reload the page or update the table via AJAX
                },
                error: function (xhr, status, error) {
                    console.error(error);
                },
            });
        });
    </script>
</body>

</html>