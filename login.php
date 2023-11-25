<?php
session_start(); // Start a session

// Database connection parameters (replace these with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cooliesystem";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process user login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // SQL query to retrieve user data
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username; // Store user ID in session
            header("Location: welcome.php"); // Redirect to welcome page
            exit();
        } else {
            $login_error = "Invalid password";
        }
    } else {
        $login_error = "User not found";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coolie Waale</title>
    <link rel="stylesheet" type="text/css" href="userlogin.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">User Login</h1>
        <form id="login-form" method="post" action="booking.html">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="User ID" class="input-field" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" class="input-field" required>
            </div>
            <?php if (isset($login_error)) { ?>
                <p class="error-message"><?php echo $login_error; ?></p>
            <?php } ?>
            <button type="submit" class="login-button">Login</button>
        </form>

        <p class="register-link">Are you new? <a href="registration.html">Register</a></p>
    </div>
    <script>
        document.getElementById("register-link").addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default link behavior
            window.location.href = "registration.html"; // Redirect to the registration page
        });
    </script>
</body>
</html>
