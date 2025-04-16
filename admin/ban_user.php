<?php
require_once '../db_connection.php';
require_once 'PassportProxy.php';

// Get the database instance and connection
$db = Database::getInstance();
$conn = $db->getConnection();



$proxy = new PassportProxy($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passport_number = $_POST['passport_number'];
    if ($proxy->banPassport($passport_number)) {
        echo "<script>alert(' $passport_number has been banned.'); window.location.href = 'ban_user.php';</script>";

    } else {

        echo "<script>alert(' Failed to ban $passport_number. It may already be banned.'); window.location.href = 'ban_user.php';</script>";
    }
}

// Fetch banned users list

$check_ban = []; // Corrected line
$query = "SELECT * FROM banned_passports ORDER BY id DESC";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $check_ban[] = $row; // Corrected line
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ban Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-green-100 to-blue-200 min-h-screen">
    <div class="container mx-auto p-8 text-center">
        <h2 class="text-2xl font-bold text-center mb-8">Ban a Users Ban Users by Passport</h2>

        <h3 class="text-xl font-semibold mb-4">Banned Passport List</h3>
        <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg text-center shadow-sm">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Passport Number</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($check_ban as $check): ?>
                    <tr>
                        <td class="py-2 px-4"><?= $check['id']; ?></td>
                        <td class="py-2 px-4"><?= $check['passport_number']; ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3 class="mt-5 pt-5 text-xl font-semibold mb-4">Ban a user</h3>
        <form action="" method="POST" class="space-y-4 max-w-lg mx-auto bg-white p-6 rounded-lg shadow-sm">
            <div>
                <label for="passport_number" class="block text-sm font-medium text-gray-700">Enter Passport
                    Number:</label>
                <input type="number" name="passport_number" id="passport_number"
                    class="w-full p-2 border border-gray-300 rounded-md" required placeholder="Passport Number">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">Enter</button>
        </form>
    </div>
    <div class="flex justify-center mt-4 mb-4">
        <a href="admin.php"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow-md transition duration-300 transform hover:scale-105">
            Go Back
        </a>
    </div>

</body>

</html>