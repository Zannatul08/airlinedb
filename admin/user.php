<?php
include '../db_connection.php';
$conn = Database::getInstance()->getConnection();


// Initialize variables
$search = isset($_GET['search']) ? trim($_GET['search']) : null;

// SQL query based on search
if ($search) {
    // If there's a search term, filter results by flight_number or status
    $sql = "SELECT flight_id, flight_number, departure_time, arrival_time, status 
            FROM flight 
            WHERE flight_number LIKE '%$search%' OR status LIKE '%$search%'";
} else {
    // If no search term, fetch all flights
    $sql = "SELECT flight_id, flight_number, departure_time, arrival_time, status FROM flight";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 font-sans">
    <div class="max-w-5xl mx-auto p-4">
        <h1 class="text-3xl font-bold text-center text-green-600 mb-8">Available Flights</h1>

        <div class="mb-6">
            <form action="user.php" method="GET" class="flex justify-center items-center space-x-4">
                <input type="text" name="search" placeholder="Search by flight number or status"
                    value="<?= htmlspecialchars($search) ?>"
                    class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" />
                <button type="submit"
                    class="h-full px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Search</button>
                <div class="space-x-3 my-3">
                    <a href="../admin/index.html"
                        class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">Back to Home</a>
                    <a href="http://localhost/airlinedb/admin/admin_login.php"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Switch to Admin</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead>
                    <tr class="bg-green-100 text-left text-gray-600 uppercase text-sm">
                        <th class="py-3 px-4 border-b">Flight ID</th>
                        <th class="py-3 px-4 border-b">Flight Number</th>
                        <th class="py-3 px-4 border-b">Departure Time</th>
                        <th class="py-3 px-4 border-b">Arrival Time</th>
                        <th class="py-3 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b hover:bg-gray-50'>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["flight_id"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["flight_number"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["departure_time"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["arrival_time"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["status"]) . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='py-4 text-center text-gray-500'>No flights found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
if ($conn) {
    $conn->close();
}

?>
