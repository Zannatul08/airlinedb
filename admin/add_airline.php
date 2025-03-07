<?php include '../db_connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Airline</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center bg-gradient-to-br from-blue-600 to-teal-400 min-h-screen p-6">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h3 class="text-2xl font-semibold text-center text-gray-800 mb-6">Add New Airline</h3>
        <form method="POST" action="add_airline.php" class="space-y-4">
            <div>
                <label for="airline_name" class="block text-gray-700 font-medium mb-2">Airline Name</label>
                <input type="text" id="airline_name" name="airline_name" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="country" class="block text-gray-700 font-medium mb-2">Country</label>
                <input type="text" id="country" name="country" class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button type="submit" name="submit_add_airline" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700 transition">Add Airline</button>
        </form>
    </div>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['submit_add_airline'])) {
    $airline_name = $_POST['airline_name'];
    $country = $_POST['country'];

    $query = "INSERT INTO airline (airline_name, country) VALUES ('$airline_name', '$country')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Airline added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding airline: " . mysqli_error($conn) . "');</script>";
    }
}
?>
