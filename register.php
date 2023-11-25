<?php
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

// Process user registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
// Collect form data
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$username = isset($_POST["username"]) ? $_POST["username"] : ""; // Check if set
$password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash the password
$gender = $_POST["gender"];
$phone_number = $_POST["phone_number"];
$age = $_POST["age"];
$email = $_POST["email"];


    // SQL query to insert user data into the database
    $sql = "INSERT INTO users (first_name, last_name, username, password, gender, phone_number, age, email)
            VALUES ('$first_name', '$last_name', '$username', '$password', '$gender', '$phone_number', $age, '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

