<?php
// Database connection
include '../db_connection.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();

// Handle Add Crew Member
if (isset($_POST['add_crew'])) {
    $crew_name = $_POST['crew_name'];
    $crew_role = $_POST['crew_role'];
    $stmt = $conn->prepare("INSERT INTO crew (name, role) VALUES (?, ?)");
    $stmt->bind_param("ss", $crew_name, $crew_role);
    if ($stmt->execute()) {
        $message = "Crew member added successfully!";
    } else {
        $message = "Error adding crew member.";
    }
    $stmt->close();
}

// Handle Assign Crew to Flight
if (isset($_POST['assign_crew'])) {
    $flight_id = $_POST['flight_id'];
    $crew_id = $_POST['crew_id'];
    $shift_start = $_POST['shift_start'];
    $shift_end = $_POST['shift_end'];
    $stmt = $conn->prepare("INSERT INTO crew_assignment (flight_id, crew_id, shift_start, shift_end) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $flight_id, $crew_id, $shift_start, $shift_end);
    if ($stmt->execute()) {
        $message = "Crew assigned to flight successfully!";
    } else {
        $message = "Error assigning crew.";
    }
    $stmt->close();
}

// Handle Delete Crew Assignment
if (isset($_POST['delete_crew'])) {
    $delete_crew_name = $_POST['delete_crew_name'];
    $delete_flight_id = $_POST['delete_flight_id'];
    $stmt = $conn->prepare("DELETE ca FROM crew_assignment ca
                                 INNER JOIN crew c ON ca.crew_id = c.crew_id
                                 WHERE c.name = ? AND ca.flight_id = ?");
    $stmt->bind_param("si", $delete_crew_name, $delete_flight_id);
    if ($stmt->execute()) {
        $message = "Crew assignment deleted successfully!";
    } else {
        $message = "Error deleting assignment.";
    }
    $stmt->close();
}

// Fetch data for dropdowns
$flights = $conn->query("SELECT flight_id, flight_number FROM flight")->fetch_all(MYSQLI_ASSOC);
$crew_members = $conn->query("SELECT crew_id, name, role FROM crew")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Crew</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Manage Crew</h2>
        <p class="text-center text-gray-600 mb-6">Add crew, assign them to flights, or delete assignments.</p>

        <?php if (isset($message)): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Add Crew Form -->
        <form action="" method="POST" class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Add New Crew Member</h3>
            <div>
                <label for="crew_name" class="block text-sm font-medium text-gray-700">Crew Name</label>
                <input type="text" name="crew_name" id="crew_name" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            <div>
                <label for="crew_role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="crew_role" id="crew_role" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="Pilot">Pilot</option>
                    <option value="Co-Pilot">Co-Pilot</option>
                    <option value="Flight Attendant">Flight Attendant</option>
                </select>
            </div>
            <button type="submit" name="add_crew"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                Add Crew Member
            </button>
        </form>

        <!-- Assign Crew Form -->
        <form action="" method="POST" class="space-y-4 mt-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Assign Crew to Flight</h3>
            <div>
                <label for="flight_id" class="block text-sm font-medium text-gray-700">Flight</label>
                <select name="flight_id" id="flight_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select Flight</option>
                    <?php foreach ($flights as $flight): ?>
                        <option value="<?= $flight['flight_id']; ?>"><?= $flight['flight_number']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="crew_id" class="block text-sm font-medium text-gray-700">Crew Member</label>
                <select name="crew_id" id="crew_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select Crew Member</option>
                    <?php foreach ($crew_members as $crew): ?>
                        <option value="<?= $crew['crew_id']; ?>"><?= $crew['name']; ?> (<?= $crew['role']; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="shift_start" class="block text-sm font-medium text-gray-700">Shift Start</label>
                <input type="datetime-local" name="shift_start" id="shift_start" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            <div>
                <label for="shift_end" class="block text-sm font-medium text-gray-700">Shift End</label>
                <input type="datetime-local" name="shift_end" id="shift_end" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            <button type="submit" name="assign_crew"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                Assign Crew
            </button>
        </form>

        <!-- Delete Crew Assignment -->
        <form action="" method="POST" class="space-y-4 mt-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Delete Crew Assignment</h3>
            <div>
                <label for="delete_crew_name" class="block text-sm font-medium text-gray-700">Crew Name</label>
                <input type="text" name="delete_crew_name" id="delete_crew_name" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
            </div>
            <div>
                <label for="delete_flight_id" class="block text-sm font-medium text-gray-700">Flight ID</label>
                <input type="text" name="delete_flight_id" id="delete_flight_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
            </div>
            <button type="submit" name="delete_crew"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                Delete Assignmed Crew
            </button>
        </form>
        <div class="mt-8 mb-8 inline-block mx-auto">
        <a href="../admin/admin.php"
        class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">Back to Home</a>
        </div>
    </div>
</body>

</html>
