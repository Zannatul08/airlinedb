<?php
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Check if the medical_team_id is passed as a query parameter
if (isset($_GET['team_id'])) {
    $team_id = $_GET['team_id'];

    // Fetch the current medical team details
    $query = "SELECT * FROM medical_assistance WHERE medical_team_id = $team_id";
    $result = $conn->query($query);

    // If team exists, fetch its details
    if ($result->num_rows > 0) {
        $team = $result->fetch_assoc();
    } else {
        echo "Team not found!";
        exit;
    }
}

// Update medical team details after form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_medical_team'])) {
    $team_lead = $_POST['team_lead'];
    $service_type = $_POST['service_type'];
    $availability_status = $_POST['availability_status'];
    $response_time = $_POST['response_time'];
    $airport_id = $_POST['airport_id'];

    // Update query
    $updateQuery = "UPDATE medical_assistance 
                    SET team_lead = '$team_lead', 
                        service_type = '$service_type', 
                        availability_status = '$availability_status', 
                        response_time = '$response_time', 
                        airport_id = '$airport_id' 
                    WHERE medical_team_id = $team_id";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Medical team updated successfully!'); window.location.href = 'medical_assistance.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medical Team</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-green-100 to-blue-200 min-h-screen">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold text-center mb-8">Edit Medical Team</h2>

        <!-- Edit Form -->
        <form action="edit_medical_team.php?team_id=<?= $team_id ?>" method="POST" class="space-y-4 max-w-lg mx-auto bg-white p-6 rounded-lg shadow-sm">
            <div>
                <label for="team_lead" class="block text-sm font-medium text-gray-700">Team Lead</label>
                <input type="text" name="team_lead" id="team_lead" class="w-full p-2 border border-gray-300 rounded-md" value="<?= $team['team_lead']; ?>" required>
            </div>

            <div>
                <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                <select name="service_type" id="service_type" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="Emergency Response" <?= $team['service_type'] == 'Emergency Response' ? 'selected' : ''; ?>>Emergency Response</option>
                    <option value="First Aid" <?= $team['service_type'] == 'First Aid' ? 'selected' : ''; ?>>First Aid</option>
                    <option value="Health Checks" <?= $team['service_type'] == 'Health Checks' ? 'selected' : ''; ?>>Health Checks</option>
                </select>
            </div>

            <div>
                <label for="availability_status" class="block text-sm font-medium text-gray-700">Availability Status</label>
                <select name="availability_status" id="availability_status" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="Available" <?= $team['availability_status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                    <option value="Engaged" <?= $team['availability_status'] == 'Engaged' ? 'selected' : ''; ?>>Engaged</option>
                </select>
            </div>

            <div>
                <label for="response_time" class="block text-sm font-medium text-gray-700">Response Time (minutes)</label>
                <input type="number" name="response_time" id="response_time" class="w-full p-2 border border-gray-300 rounded-md" value="<?= $team['response_time']; ?>" required>
            </div>

            <div>
                <label for="airport_id" class="block text-sm font-medium text-gray-700">Airport ID</label>
                <input type="number" name="airport_id" id="airport_id" class="w-full p-2 border border-gray-300 rounded-md" value="<?= $team['airport_id']; ?>" required>
            </div>

            <button type="submit" name="update_medical_team" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">Update Medical Team</button>
        </form>
    </div>

    <!-- Back to Medical Assistance Page Button -->
    <div class="mb-8 flex justify-center">
    <a href="medical_assistance.php" class="px-6 py-2 bg-green-300 text-gray-700 rounded-lg hover:bg-gray-300">Back to Medical Assistance</a>
</div>

</body>

</html>
