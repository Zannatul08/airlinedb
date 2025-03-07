<?php
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Fetch all medical teams for displaying
$medical_teams = [];
$query = "SELECT * FROM medical_assistance";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medical_teams[] = $row;
    }
}

// Add a new medical team
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_medical_team'])) {
    $team_lead = $_POST['team_lead'];
    $service_type = $_POST['service_type'];
    $availability_status = $_POST['availability_status'];
    $response_time = $_POST['response_time'];
    $airport_id = $_POST['airport_id'];

    // Insert into Medical Assistance table
    $insertMedicalQuery = "INSERT INTO medical_assistance (team_lead, service_type, availability_status, response_time, airport_id) 
                                VALUES ('$team_lead', '$service_type', '$availability_status', '$response_time', '$airport_id')";
    
    if ($conn->query($insertMedicalQuery) === TRUE) {
        // Get the newly created medical_team_id
        $medical_team_id = $conn->insert_id;

        // Insert into Team_lead table
        $insertTeamLeadQuery = "INSERT INTO team_lead (medical_team_id, start_date) 
                                    VALUES ('$medical_team_id', CURDATE())";

        if ($conn->query($insertTeamLeadQuery) === TRUE) {
            echo "<script>alert('Medical team and team lead added successfully!'); window.location.href = 'medical_assistance.php';</script>";
        } else {
            echo "Error: " . $insertTeamLeadQuery . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $insertMedicalQuery . "<br>" . $conn->error;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Assistance</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-green-100 to-blue-200 min-h-screen">
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold text-center mb-8">Medical Assistance Management</h2>

        <!-- Medical Team Table -->
        <h3 class="text-xl font-semibold mb-4">Existing Medical Teams</h3>
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-sm">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-2 px-4">Team Lead</th>
                    <th class="py-2 px-4">Service Type</th>
                    <th class="py-2 px-4">Availability Status</th>
                    <th class="py-2 px-4">Response Time (min)</th>
                    <th class="py-2 px-4">Airport ID</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medical_teams as $team): ?>
                    <tr>
                        <td class="py-2 px-4"><?= $team['team_lead']; ?></td>
                        <td class="py-2 px-4"><?= $team['service_type']; ?></td>
                        <td class="py-2 px-4"><?= $team['availability_status']; ?></td>
                        <td class="py-2 px-4"><?= $team['response_time']; ?></td>
                        <td class="py-2 px-4"><?= $team['airport_id']; ?></td>
                        <td class="py-2 px-4">
                            <a href="edit_medical_team.php?team_id=<?= $team['medical_team_id']; ?>" class="text-blue-600 hover:text-blue-800">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add New Medical Team Form -->
        <h3 class="text-xl font-semibold mt-8 mb-4">Add New Medical Team</h3>
        <form action="medical_assistance.php" method="POST" class="space-y-4 max-w-lg mx-auto bg-white p-6 rounded-lg shadow-sm">
            <div>
                <label for="team_lead" class="block text-sm font-medium text-gray-700">Team Lead</label>
                <input type="text" name="team_lead" id="team_lead" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="service_type" class="block text-sm font-medium text-gray-700">Service Type</label>
                <select name="service_type" id="service_type" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="Emergency Response">Emergency Response</option>
                    <option value="First Aid">First Aid</option>
                    <option value="Health Checks">Health Checks</option>
                </select>
            </div>

            <div>
                <label for="availability_status" class="block text-sm font-medium text-gray-700">Availability Status</label>
                <select name="availability_status" id="availability_status" class="w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="Available">Available</option>
                    <option value="Engaged">Engaged</option>
                </select>
            </div>

            <div>
                <label for="response_time" class="block text-sm font-medium text-gray-700">Response Time (minutes)</label>
                <input type="number" name="response_time" id="response_time" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="airport_id" class="block text-sm font-medium text-gray-700">Airport ID</label>
                <input type="number" name="airport_id" id="airport_id" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>

            <button type="submit" name="add_medical_team" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">Add Medical Team</button>
        </form>
    </div>

</body>

</html>
