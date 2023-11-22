<?php
require_once "db_connection.php";

// Handle signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $phone = $_POST['phone'];
    $password = $_POST['password']; // You'll need to hash this securely before storing it

    // Perform validations and sanitize data

    // Hash the password (use a secure hashing algorithm like bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if a user with the same phone number exists
    $phoneCheckQuery = "SELECT * FROM users WHERE phone = '$phone'";
    $phoneCheckResult = $conn->query($phoneCheckQuery);

    if ($phoneCheckResult->num_rows > 0) {
        // User with the same phone number already exists, display an error or handle as needed
        $errorMessage = "User with this phone number already exists. Please sign in.";
    } else {
        // Proceed with signup
        // Insert user data into the database
        $sql = "INSERT INTO users (phone, password) VALUES ('$phone', '$hashedPassword')";
        if ($conn->query($sql) === TRUE) {
            // Signup success, redirect to index.php
            header("Location: signin.php");
            exit();
        } else {
            // Handle signup failure
            $errorMessage = "Signup failed. Please try again later.";
        }
    }
}
?>
<!-- Signup form in HTML -->
<form action="signup.php" method="post">
    <input type="text" name="phone" placeholder="Phone number" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="signup" value="Sign Up">
    <?php if (isset($errorMessage)): ?>
        <div class="error-message">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>
</form>