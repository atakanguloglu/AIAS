<?php
require_once "db_connection.php";

// Handle signin form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Retrieve user data based on the provided phone number
    $sql = "SELECT * FROM users WHERE phone = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session/token for the user
            session_start();
            $_SESSION['user_id'] = $user['id'];
            // Redirect to authenticated user's page
            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            // Invalid credentials, display error message
            $errorMessage = "Invalid phone number or password.";
        }
    } else {
        // User not found, display error message
        $errorMessage = "User not found.";
    }
}
?>
<!-- Signin form in HTML -->
<form action="signin.php" method="post">
    <input type="text" name="phone" placeholder="Phone number" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="signin" value="Sign In">
    <?php if (isset($errorMessage)) : ?>
    <div class="error-message">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>
</form>
