<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cooliesystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $pnr = $_POST["pnr"];
    $from_location = $_POST["from_location"];
    $to_location = $_POST["to_location"];
    $num_luggages = $_POST["num_luggages"];
    $username = $_POST["username"];

    // Calculate the amount as 20 times the number of luggages
    $amount = 20 * $num_luggages;

    // Determine user_id based on the provided username
    $user_id = getUserIdByUsername($conn, $username);

    if ($user_id !== null) {
        // Determine coolie_id (for example, it could be obtained based on availability)
        $coolie_id = getAvailableCoolieId($conn); // Replace with your actual logic to get an available coolie_id

        // Insert booking details into the bookings table
        $sql_booking = "INSERT INTO bookings (user_id, coolie_id, pnr, luggage_count, from_location, to_location, amount, booking_time) 
                        VALUES ('$user_id', '$coolie_id', '$pnr', '$num_luggages', '$from_location', '$to_location', '$amount', NOW())";

        if ($conn->query($sql_booking) === TRUE) {
            // Retrieve coolie details for display
            $sql_coolie_details = "SELECT * FROM coolies WHERE coolie_id = '$coolie_id' AND available = 1";
            $result_coolie_details = $conn->query($sql_coolie_details);

            if ($result_coolie_details->num_rows > 0) {
                $row = $result_coolie_details->fetch_assoc();
                include 'booking_success.php';
            } else {
                echo "Coolie details not found or not available.";
            }

            // Update coolie availability
            $sql_update_coolie = "UPDATE coolies SET available = 0 WHERE coolie_id = '$coolie_id'";
            $conn->query($sql_update_coolie);
        } else {
            echo "Error: " . $sql_booking . "<br>" . $conn->error;
        }
    } else {
        echo "User not found with the provided username.";
    }
}

$conn->close();

// Function to get an available coolie_id (replace with your actual logic)
function getAvailableCoolieId($conn) {
    $sql_available_coolie = "SELECT coolie_id FROM coolies WHERE available = 1 LIMIT 1";
    $result_available_coolie = $conn->query($sql_available_coolie);

    if ($result_available_coolie->num_rows > 0) {
        $row = $result_available_coolie->fetch_assoc();
        return $row["coolie_id"];
    } else {
        // Handle the case when no available coolie is found
        return null;
    }
}

// Function to get user_id based on the provided username
function getUserIdByUsername($conn, $username) {
    $sql_user_id = "SELECT user_id FROM users WHERE username = '$username'";
    $result_user_id = $conn->query($sql_user_id);

    if ($result_user_id->num_rows > 0) {
        $row = $result_user_id->fetch_assoc();
        return $row["user_id"];
    } else {
        // Handle the case when no user is found with the provided username
        return null;
    }
}
?>

