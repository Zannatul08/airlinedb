<?php
session_start();
include '../db_connection.php';
// Get the database connection instance
$db = Database::getInstance();
$conn = $db->getConnection();

require_once 'PassportProxy.php';
$passportProxy = new PassportProxy($conn);

$passport_number = $_POST['passport_number'] ?? '';

if ($passportProxy->isBanned($passport_number)) {
    die("<p style='color:red;'> Access denied. You are banned.</p>");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'admin'; // We will default this to 'admin'

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        $error_message = "Username is already taken. Please choose a different one.";
    } else {
        // Hash the password using bcrypt
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new admin into the database
        $stmt = $conn->prepare("INSERT INTO admins (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $role);

        if ($stmt->execute()) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $username;
            header('Location: admin_login.php'); // Redirect to the admin login after successful registration
            exit();
        } else {
            $error_message = "Error registering admin. Please try again.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 font-sans">

    <div class="max-w-md mx-auto mt-12 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center text-green-600">Register New Admin</h2>

        <?php if (isset($error_message)): ?>
            <div class="text-red-500 text-center mt-4"><?= $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="register_admin.php" class="mt-6">
            <label for="username" class="block text-gray-700">Username:</label>
            <input type="text" id="username" name="username" required
                class="w-full p-3 border border-gray-300 rounded-lg mt-2">

            <label for="password" class="block text-gray-700 mt-4">Password:</label>
            <input type="password" id="password" name="password" required
                class="w-full p-3 border border-gray-300 rounded-lg mt-2">

            <label for="password" class="block text-gray-700 mt-4">Passport number</label>
            <input type="text" name="passport_number" required
                class="w-full p-3 border border-gray-300 rounded-lg mt-2">


            <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg mt-6 hover:bg-blue-600">Register
                Admin</button>
        </form>

        <div class="mt-4 text-center">
            <a href="admin_login.php" class="text-blue-500 hover:underline">Already have an account? Login here</a>
        </div>
    </div>

</body>

</html>