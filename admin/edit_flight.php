<?php
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Fetch the flight details based on the flight number
$flight_details = null;
if (isset($_GET['flight_number'])) {
    $flight_number = $_GET['flight_number'];
    $query = "SELECT * FROM flight WHERE flight_number = '$flight_number'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $flight_details = $result->fetch_assoc();
    } else {
        echo "<script>alert('Flight not found!');</script>";
    }
}

// Update flight details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_flight'])) {
    $flight_number = $_POST['flight_number'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE flight SET 
                                 departure_time = '$departure_time', 
                                 arrival_time = '$arrival_time', 
                                 status = '$status'
                                 WHERE flight_number = '$flight_number'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Flight updated successfully!'); window.location.href = 'admin.php';</script>";
    } else {
        echo "Error: " . $updateQuery . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Flight</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold text-center mb-6">Edit Flight Details</h2>

        <?php if ($flight_details): ?>
            <form action="edit_flight.php" method="POST" class="space-y-4 max-w-lg mx-auto">
                <input type="hidden" name="flight_number" value="<?= $flight_details['flight_number']; ?>">

                <div>
                    <label for="departure_time" class="block text-sm font-medium text-gray-700">Departure Time</label>
                    <input type="datetime-local" name="departure_time" id="departure_time" required
                        value="<?= date('Y-m-d\TH:i', strtotime($flight_details['departure_time'])); ?>"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label for="arrival_time" class="block text-sm font-medium text-gray-700">Arrival Time</label>
                    <input type="datetime-local" name="arrival_time" id="arrival_time" required
                        value="<?= date('Y-m-d\TH:i', strtotime($flight_details['arrival_time'])); ?>"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        <option value="Scheduled" <?= $flight_details['status'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                        <option value="Delayed" <?= $flight_details['status'] == 'Delayed' ? 'selected' : ''; ?>>Delayed</option>
                        <option value="Cancelled" <?= $flight_details['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>

                <button type="submit" name="update_flight"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                    Update Flight
                </button>

                <div class="mt-8 mb-8 inline-block mx-auto">
                    <a href="../admin.php"
                        class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">Back to Home</a>
                </div>
            </form>
        <?php else: ?>
            <p class="text-center text-gray-600">No flight details available to edit.</p>
        <?php endif; ?>
    </div>
</body>

</html>