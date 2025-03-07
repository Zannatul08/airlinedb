<?php
session_start();
include '../db_connection.php'; // Include the database connection

// Get the database connection instance
$db = Database::getInstance();
$conn = $db->getConnection();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a query to find the admin by username
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Verify username and password
    if ($admin && password_verify($password, $admin['password'])) {
        // Successful login, set session variables
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = $admin['role'];

        // Redirect to admin dashboard
        header('Location: admin.php');
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex flex-col justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border border-gray-300">
            <h2 class="text-2xl font-bold text-gray-700 text-center mb-6">Admin Login</h2>

            <?php
            if (isset($error_message)) {
                echo "<div class='bg-red-100 text-red-700 p-3 mb-4 rounded-lg text-center'>" . htmlspecialchars($error_message) . "</div>";
            }
            ?>

            <form method="POST" action="admin_login.php" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-600">Username:</label>
                    <input type="text" id="username" name="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-600">Password:</label>
                    <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>

                <button type="submit" class="w-full py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Login</button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Don't have an admin account? <a href="register_admin.php" class="text-blue-600 hover:underline">Register here</a></p>
            </div>
        </div>
    </div>

</body>

</html>