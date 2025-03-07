<?php
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Fetch all flights and assigned crew members
$query = "
    SELECT 
        f.flight_number, 
        f.departure_time, 
        f.arrival_time, 
        f.status,
        GROUP_CONCAT(CASE WHEN c.role = 'Pilot' THEN c.name END) AS pilot,
        GROUP_CONCAT(CASE WHEN c.role = 'Co-Pilot' THEN c.name END) AS co_pilot,
        GROUP_CONCAT(CASE WHEN c.role = 'Flight Attendant' THEN c.name END) AS flight_attendants
    FROM flight f
    LEFT JOIN crew_assignment ca ON f.flight_id = ca.flight_id
    LEFT JOIN crew c ON ca.crew_id = c.crew_id
    GROUP BY f.flight_number, f.departure_time, f.arrival_time, f.status
";

$result = $conn->query($query);
$flights = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flights</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold text-center mb-6">Manage Flights</h2>
        <table class="min-w-full table-auto bg-white shadow-lg rounded-lg">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="px-4 py-2 border">Flight Number</th>
                    <th class="px-4 py-2 border">Departure Time</th>
                    <th class="px-4 py-2 border">Arrival Time</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Pilot</th>
                    <th class="px-4 py-2 border">Co-Pilot</th>
                    <th class="px-4 py-2 border">Flight Attendants</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flights as $flight): ?>
                    <tr>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($flight['flight_number']); ?></td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($flight['departure_time']); ?></td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($flight['arrival_time']); ?></td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($flight['status']); ?></td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($flight['pilot'] ?: 'N/A'); ?></td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($flight['co_pilot'] ?: 'N/A'); ?></td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($flight['flight_attendants'] ?: 'N/A'); ?></td>
                        <td class="px-4 py-2 border">
                            <a href="edit_flight.php?flight_number=<?= urlencode($flight['flight_number']); ?>" 
                               class="text-blue-500 hover:text-blue-700">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
