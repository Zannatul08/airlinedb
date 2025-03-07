<?php include '../db_connection.php' ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #4f46e5, #06b6d4);
            min-height: 100vh;
        }
    </style>
</head>

<body class="flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Airline Management System</h2>

        <!-- Airline Form -->
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Add New Airline</h3>
        <form method="POST" action="add_airline.php" class="mb-6">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="airline_name">Airline Name</label>
                <input type="text" id="airline_name" name="airline_name" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="country">Country</label>
                <input type="text" id="country" name="country" class="w-full p-2 border rounded">
            </div>
            <button type="submit" name="submit_add_airline" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Airline</button>
        </form>

        <!-- Airport Form -->
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Add New Airport</h3>
        <form method="POST" action="add_airport.php" class="mb-6">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="airport_name">Airport Name</label>
                <input type="text" id="airport_name" name="airport_name" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="city">City</label>
                <input type="text" id="city" name="city" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="airport_country">Country</label>
                <input type="text" id="airport_country" name="airport_country" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="iata_code">IATA Code</label>
                <input type="text" id="iata_code" name="iata_code" class="w-full p-2 border rounded" maxlength="3" required>
            </div>
            <button type="submit" name="submit_add_airport" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Airport</button>
        </form>


        <!-- Airplane Form -->
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Add New Airplane</h3>
        <form method="POST" action="add_airplane.php">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="model">Model</label>
                <input type="text" id="model" name="model" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="capacity">Capacity</label>
                <input type="number" id="capacity" name="capacity" class="w-full p-2 border rounded" required>
            </div>
            <button type="submit" name="submit_add_airplane" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Add Airplane</button>
        </form>