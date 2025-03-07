<?php
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Fetch all airport maintenance records
$airport_maintenance = [];
$query = "SELECT * FROM airport_maintenance";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $airport_maintenance[] = $row;
    }
}

// Add a new airport maintenance record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_maintenance'])) {
    $airport_id = $_POST['airport_id'];
    $service_type = $_POST['service_type'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = $_POST['status'];

    $insertQuery = "INSERT INTO airport_maintenance (airport_id, service_type, start_time, end_time, status) 
                        VALUES ('$airport_id', '$service_type', '$start_time', '$end_time', '$status')";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Airport maintenance record added successfully!'); window.location.href = 'airport_maintenance.php';</script>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

// Update an existing airport maintenance record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_maintenance'])) {
    $maintenance_id = $_POST['maintenance_id'];
    $service_type = $_POST['service_type'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE airport_maintenance 
                        SET service_type = '$service_type', start_time = '$start_time', end_time = '$end_time', status = '$status' 
                        WHERE maintenance_id = '$maintenance_id'";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Airport maintenance record updated successfully!'); window.location.href = 'airport_maintenance.php';</script>";
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
    <title>Airport Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-green-100 to-blue-200 min-h-screen">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold text-center mb-8">Airport Maintenance Management</h2>

        <!-- Maintenance Records Table -->
        <h3 class="text-xl font-semibold mb-4">Existing Maintenance Records</h3>
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-sm">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-2 px-4">Maintenance ID</th>
                    <th class="py-2 px-4">Airport ID</th>
                    <th class="py-2 px-4">Service Type</th>
                    <th class="py-2 px-4">Start Time</th>
                    <th class="py-2 px-4">End Time</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($airport_maintenance as $maintenance): ?>
                    <tr>
                        <td class="py-2 px-4"><?= $maintenance['maintenance_id']; ?></td>
                        <td class="py-2 px-4"><?= $maintenance['airport_id']; ?></td>
                        <td class="py-2 px-4"><?= $maintenance['service_type']; ?></td>
                        <td class="py-2 px-4"><?= $maintenance['start_time']; ?></td>
                        <td class="py-2 px-4"><?= $maintenance['end_time']; ?></td>
                        <td class="py-2 px-4"><?= $maintenance['status']; ?></td>
                        <td class="py-2 px-4">
                            <a href="airport_maintenance.php?edit_id=<?= $maintenance['maintenance_id']; ?>" class="text-blue-600 hover:text-blue-800">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add or Update Maintenance Record Form -->
        <?php
        $editMode = isset($_GET['edit_id']);
        $editRecord = $editMode ? $conn->query("SELECT * FROM airport_maintenance WHERE maintenance_id = " . $_GET['edit_id'])->fetch_assoc() : null;
        ?>
        <h3 class="text-xl font-semibold mt-8 mb-4"><?= $editMode ? 'Update' : 'Add New'; ?> Maintenance Record</h3>
        <form action="airport_maintenance.php" method="POST" class="space-y-4 max-w-lg mx-auto bg-white p-6 rounded-lg shadow-sm">
            <?php if ($editMode): ?>
                <input type="hidden" name="maintenance_id" value="<?= $editRecord['maintenance_id']; ?>">
            <?php endif; ?>

            <div>
                <label for="airport_id" class="block text-sm font-medium text-gray-700">Airport ID</label>
                <input type="number" name="airport_id" id="airport_id" class="w-full p-2 border border-gray-300 rounded-md" required value="<?= $editMode ? $editRecord['airport_id'] : ''; ?>" <?= $editMode ? 'readonly' : ''; ?>>
            </div>

            <div>
                <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                <select name="service_type" id="service_type" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="Inspection" <?= $editMode && $editRecord['service_type'] == 'Inspection' ? 'selected' : ''; ?>>Inspection</option>
                    <option value="Repair" <?= $editMode && $editRecord['service_type'] == 'Repair' ? 'selected' : ''; ?>>Repair</option>
                    <option value="Cleaning" <?= $editMode && $editRecord['service_type'] == 'Cleaning' ? 'selected' : ''; ?>>Cleaning</option>
                </select>
            </div>

            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="datetime-local" name="start_time" id="start_time" class="w-full p-2 border border-gray-300 rounded-md" required value="<?= $editMode ? $editRecord['start_time'] : ''; ?>">
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="datetime-local" name="end_time" id="end_time" class="w-full p-2 border border-gray-300 rounded-md" required value="<?= $editMode ? $editRecord['end_time'] : ''; ?>">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="Scheduled" <?= $editMode && $editRecord['status'] == 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                    <option value="In Progress" <?= $editMode && $editRecord['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="Completed" <?= $editMode && $editRecord['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>

            <button type="submit" name="<?= $editMode ? 'update_maintenance' : 'add_maintenance'; ?>" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md"><?= $editMode ? 'Update' : 'Add'; ?> Maintenance Record</button>
        </form>
    </div>
</body>

</html>
