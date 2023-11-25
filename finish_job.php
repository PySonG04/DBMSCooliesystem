<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cooliesystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Assuming you pass the coolie_id as a parameter in the URL
    $coolie_id = $_GET["coolie_id"];

    // Update coolie availability to make it available again
    $sql_update_coolie = "UPDATE coolies SET available = 1 WHERE coolie_id = '$coolie_id'";
    
    if ($conn->query($sql_update_coolie) === TRUE) {
        echo "";
    } else {
        echo "Error updating coolie status: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Finished - Thank You!</title>
    <link rel="stylesheet" href="finish.css"> <!-- You can create a separate CSS file for finish_job.php if needed -->
</head>
<body>
    <div class="job-finished">
        <h2>Job Finished - Thank You!</h2>
        <p>Thank you for using our service. Your booking has been successfully completed.</p>
        <p>We appreciate your business!</p>

        <!-- Add a logout button -->
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
