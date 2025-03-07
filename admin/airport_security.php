<?php
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Fetch all airport security records
$airport_security = []; // Corrected line
$query = "SELECT * FROM airport_security";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $airport_security[] = $row; // Corrected line
    }
}

// Add a new airport security record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_security'])) {
    $airport_id = $_POST['airport_id'];
    $security_type = $_POST['security_type'];
    $staff_count = $_POST['staff_count'];
    $status = $_POST['status'];
    $last_inspection_date = $_POST['last_inspection_date'];
    $next_inspection_date = $_POST['next_inspection_date'];

    $insertQuery = "INSERT INTO airport_security (airport_id, security_type, staff_count, status, last_inspection_date, next_inspection_date) 
                        VALUES ('$airport_id', '$security_type', '$staff_count', '$status', '$last_inspection_date', '$next_inspection_date')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Airport security record added successfully!'); window.location.href = 'airport_security.php';</script>";
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
    <title>Airport Security</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-green-100 to-blue-200 min-h-screen">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold text-center mb-8">Airport Security Management</h2>

        <!-- Security Records Table -->
        <h3 class="text-xl font-semibold mb-4">Existing Security Records</h3>
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-sm">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-2 px-4">Airport ID</th>
                    <th class="py-2 px-4">Security Type</th>
                    <th class="py-2 px-4">Staff Count</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Last Inspection Date</th>
                    <th class="py-2 px-4">Next Inspection Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($airport_security as $security): ?>
                    <tr>
                        <td class="py-2 px-4"><?= $security['airport_id']; ?></td>
                        <td class="py-2 px-4"><?= $security['security_type']; ?></td>
                        <td class="py-2 px-4"><?= $security['staff_count']; ?></td>
                        <td class="py-2 px-4"><?= $security['status']; ?></td>
                        <td class="py-2 px-4"><?= $security['last_inspection_date']; ?></td>
                        <td class="py-2 px-4"><?= $security['next_inspection_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add New Security Form -->
        <h3 class="text-xl font-semibold mt-8 mb-4">Add New Security Record</h3>
        <form action="airport_security.php" method="POST" class="space-y-4 max-w-lg mx-auto bg-white p-6 rounded-lg shadow-sm">
            <div>
                <label for="airport_id" class="block text-sm font-medium text-gray-700">Airport ID</label>
                <input type="number" name="airport_id" id="airport_id" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="security_type" class="block text-sm font-medium text-gray-700">Security Type</label>
                <select name="security_type" id="security_type" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="Checkpoint">Checkpoint</option>
                    <option value="Perimeter Security">Perimeter Security</option>
                    <option value="Surveillance">Surveillance</option>
                </select>
            </div>

            <div>
                <label for="staff_count" class="block text-sm font-medium text-gray-700">Staff Count</label>
                <input type="number" name="staff_count" id="staff_count" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <div>
                <label for="last_inspection_date" class="block text-sm font-medium text-gray-700">Last Inspection Date</label>
                <input type="date" name="last_inspection_date" id="last_inspection_date" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="next_inspection_date" class="block text-sm font-medium text-gray-700">Next Inspection Date</label>
                <input type="date" name="next_inspection_date" id="next_inspection_date" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <button type="submit" name="add_security" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">Add Security Record</button>
        </form>
    </div>
    <div class="flex justify-center mt-4 mb-4">
        <a href="admin.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow-md transition duration-300 transform hover:scale-105">
            Go Back
        </a>
    </div>

</body>

</html>