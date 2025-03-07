<?php
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Fetch all airports to populate the dropdowns
$query = "SELECT airport_id, airport_name FROM airport";
$result = $conn->query($query);
$airports = [];
while ($row = $result->fetch_assoc()) {
    $airports[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form submission handling
    $origin_airport_id = $_POST['origin_airport_id'];
    $destination_airport_id = $_POST['destination_airport_id'];
    $distance = $_POST['distance'];

    $insertQuery = "INSERT INTO route (origin_airport_id, destination_airport_id, distance) 
                                 VALUES ('$origin_airport_id', '$destination_airport_id', '$distance')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Route added successfully!');</script>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Route</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Add New Route</h2>
        <form action="add_route.php" method="POST" class="space-y-4">
            <!-- Origin Airport -->
            <div>
                <label for="origin_airport_id" class="block text-sm font-medium text-gray-700">Origin Airport</label>
                <select name="origin_airport_id" id="origin_airport_id" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select Origin Airport</option>
                    <?php foreach ($airports as $airport): ?>
                        <option value="<?= $airport['airport_id']; ?>"><?= $airport['airport_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Destination Airport -->
            <div>
                <label for="destination_airport_id" class="block text-sm font-medium text-gray-700">Destination Airport</label>
                <select name="destination_airport_id" id="destination_airport_id" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select Destination Airport</option>
                    <?php foreach ($airports as $airport): ?>
                        <option value="<?= $airport['airport_id']; ?>"><?= $airport['airport_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Distance -->
            <div>
                <label for="distance" class="block text-sm font-medium text-gray-700">Distance (km)</label>
                <input type="number" name="distance" id="distance" required 
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                Add Route
            </button>
        </form>
    </div>
</body>
</html>
