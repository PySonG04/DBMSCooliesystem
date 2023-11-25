<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

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

// Get data from the POST request
$user_id = $_SESSION["user_id"];
$pnr = $_POST["pnr"];
$luggage_count = $_POST["luggage_count"];
$from_location = $_POST["from_location"];
$to_location = $_POST["to_location"];

// Check for an available coolie
$coolieQuery = "SELECT coolie_id, first_name, last_name FROM coolies WHERE available = true LIMIT 1";
$coolieResult = $conn->query($coolieQuery);

if ($coolieResult->num_rows > 0) {
    // Coolie is available, make the booking

    // Fetch coolie details
    $coolieData = $coolieResult->fetch_assoc();
    $coolie_id = $coolieData["coolie_id"];
    $coolie_name = $coolieData["first_name"] . " " . $coolieData["last_name"];

    // Calculate the amount (replace this with your actual pricing logic)
    $amount = 50 * $luggage_count;

    // Update coolie status to booked
    $updateCoolieQuery = "UPDATE coolies SET available = false WHERE coolie_id = $coolie_id";
    $conn->query($updateCoolieQuery);

    // Insert booking data into the database
    $insertBookingQuery = "INSERT INTO bookings (user_id, coolie_id, pnr, luggage_count, from_location, to_location, amount)
                           VALUES ('$user_id', '$coolie_id', '$pnr', '$luggage_count', '$from_location', '$to_location', '$amount')";

    if ($conn->query($insertBookingQuery) === TRUE) {
        // Booking successful, return details to the client
        $bookingDetails = [
            "coolie_id" => $coolie_id,
            "coolie_name" => $coolie_name,
            "amount" => $amount
        ];

        echo json_encode($bookingDetails);
    } else {
        // Handle database error
        $error = "Error making the booking: " . $conn->error;
        echo json_encode(["error" => $error]);
    }
} else {
    echo json_encode(["error" => "No available coolies at the moment. Please try again later."]);
}

// Close the database connection
$conn->close();
?>
