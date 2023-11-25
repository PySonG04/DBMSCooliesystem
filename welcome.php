<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_id = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Coolie Waale</title>
    <link rel="stylesheet" type="text/css" href="userlogin.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">Welcome, <?php echo $user_id; ?>!</h1>
        <p>You are now logged in.</p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
