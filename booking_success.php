<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful - Coolie Details</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <div class="booking-success">
        <h2>Booking successful!</h2>
        <h3>Coolie Details:</h3>
        <div class="coolie-details">
            <p>Coolie ID: <?php echo $row["coolie_id"]; ?></p>
            <p>Name: <?php echo $row["first_name"] . " " . $row["last_name"]; ?></p>
            <p>Gender: <?php echo $row["gender"]; ?></p>
            <p>Age: <?php echo $row["age"]; ?></p>
            <p>Phone Number: <?php echo $row["phone_number"]; ?></p>
            <p>Location: <?php echo $row["location"]; ?></p>
            <!-- Add more details as needed -->
        </div>

        <form action="finish_job.php" method="get">
            <input type="hidden" name="coolie_id" value="<?php echo $coolie_id; ?>">
            <button class="finish-job-btn" type="submit">Finish Job</button>
        </form>
    </div>
</body>
</html>
