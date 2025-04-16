<?php
session_start();
require_once '../db_connection.php';
// Get the database connection instance
$db = Database::getInstance();
$conn = $db->getConnection();

require_once 'PassportProxy.php';
$passportProxy = new PassportProxy($conn);

$passport_number = $_POST['passport_number'] ?? '';

if ($passportProxy->isBanned($passport_number)) {
    die("<p style='color:red;'> Access denied!!! You are banned.</p>");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'user'; // Set role as 'user' for the users table

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username is already taken. Please choose a different one.";
    } else {
        // Hash the password using bcrypt
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $role);

        if ($stmt->execute()) {
            header('Location: user_login.php');
            exit();
        } else {
            $error_message = "Error registering user. Please try again.";
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
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold text-center mb-6">Register New User</h2>

        <?php if (isset($error_message)): ?>
            <div class="text-red-500 text-center mb-4"><?= htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="POST" action="register_user.php" class="space-y-4 max-w-lg mx-auto">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="passport_number" class="block text-sm font-medium text-gray-700">Passport Number</label>
                <input type="text" name="passport_number" id="passport_number" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>




            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                Register User
            </button>

            <div class="mt-8 mb-8 inline-block mx-auto">
                <a href="index.html"
                    class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">Back to
                    Home</a>
            </div>
        </form>
    </div>
</body>

</html>

<?php
if ($conn) {
    $conn->close();
}
?>