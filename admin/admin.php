<?php
session_start();

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'admin') {
    // Redirect to login page if not logged in or not an admin
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">

    <div class="max-w-7xl mx-auto p-4">
        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-green-600">Admin Dashboard</h1>
            <div class="space-x-4">
                <a href="../admin//index.html" 
                   class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">Back to Home</a>
                <a href="http://localhost/airlinedb/admin/user.php" 
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Switch to User</a>
            </div>
        </div>

        <!-- Admin Options -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="add_flight.php" 
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">Add Flight</h2>
                <p class="text-gray-600 mt-2">Add a new flight to the system.</p>
            </a>

            <a href="update_flight.php" 
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">Manage Flight</h2>
                <p class="text-gray-600 mt-2">View and Modify an existing flight's details.</p>
            </a>

            <a href="add_route.php" 
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">Add Route</h2>
                <p class="text-gray-600 mt-2">Add a route on the system.</p>
            </a>
            <a href="add_airport.php" 
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">Add Airport</h2>
                <p class="text-gray-600 mt-2">Add a airport on the system.</p>
            </a>

            <!-- <a href="user.php" 
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">View All Flights</h2>
                <p class="text-gray-600 mt-2">See all flights currently scheduled.</p>
            </a> -->

            <a href="add_crew.php" 
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">Manage Crew</h2>
                <p class="text-gray-600 mt-2">Add, update, or remove crew members.</p>
            </a>

            <a href="airport_security.php" 
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">Manage Airport Security</h2>
                <p class="text-gray-600 mt-2">Manage airport security details and personnel.</p>
            </a>

            <a href="airport_maintenance.php" 
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">Airport Maintenance</h2>
                <p class="text-gray-600 mt-2">Schedule and update airport maintenance tasks.</p>
            </a>

           
            <a href="medical_assistance.php" 
            class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <h2 class="text-lg font-semibold text-green-600">Manage Medical Assistance</h2>
                <p class="text-gray-600 mt-2">View and manage the medical teams for emergencies, first aid, and health checks.</p>
            </a>

        </div>
    </div>
    
</body>
</html>
