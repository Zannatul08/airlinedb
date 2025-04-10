<?php
session_start();
require_once '../db_connection.php';

// Get the database connection instance
$db = Database::getInstance();
$conn = $db->getConnection();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a query to find the user by username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify username and password
    if ($user && password_verify($password, $user['password'])) {
        // Successful login, set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect to user dashboard
        header('Location: user.php');
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
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex flex-col justify-center items-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border border-gray-300">
            <h2 class="text-2xl font-bold text-gray-700 text-center mb-6">User Login</h2>

            <?php
            if (isset($error_message)) {
                echo "<div class='bg-red-100 text-red-700 p-3 mb-4 rounded-lg text-center'>" . htmlspecialchars($error_message) . "</div>";
            }
            ?>

            <form method="POST" action="user_login.php" class="space-y-6">
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
                <p class="text-sm text-gray-600">Don't have a user account? Contact an admin to register.</p>
            </div>
        </div>
    </div>

</body>

</html>