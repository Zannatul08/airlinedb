<?php
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Airport</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex items-center justify-center bg-gradient-to-br from-green-500 to-teal-400 min-h-screen p-6">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h3 class="text-2xl font-semibold text-center text-gray-800 mb-6">Add New Airport</h3>
        <form method="POST" action="add_airport.php" class="space-y-4">
            <div>
                <label for="airport_name" class="block text-gray-700 font-medium mb-2">Airport Name</label>
                <input type="text" id="airport_name" name="airport_name" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
                <input type="text" id="city" name="city" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="airport_country" class="block text-gray-700 font-medium mb-2">Country</label>
                <input type="text" id="airport_country" name="airport_country" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="iata_code" class="block text-gray-700 font-medium mb-2">IATA Code</label>
                <input type="text" id="iata_code" name="iata_code" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500" maxlength="3" required>
            </div>
            <button type="submit" name="submit_add_airport" class="w-full bg-green-600 text-white p-3 rounded hover:bg-green-700 transition">Add Airport</button>
        </form>
        <div class="mt-8 mb-8 inline-block mx-auto">
            <a href="../admin/admin.php"
                class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">Back to Home</a>
        </div>
    </div>
</body>

</html>

<?php
// Handle form submission
if (isset($_POST['submit_add_airport'])) {
    $airport_name = $_POST['airport_name'];
    $city = $_POST['city'];
    $airport_country = $_POST['airport_country'];
    $iata_code = $_POST['iata_code'];

    $query = "INSERT INTO airport (airport_name, city, country, iata_code) VALUES ('$airport_name', '$city', '$airport_country', '$iata_code')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Airport added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding airport: " . mysqli_error($conn) . "');</script>";
    }
}
?>