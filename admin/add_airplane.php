<?php include '../db_connection.php'; ?>

<?php
// Handle the Add Airplane form
if (isset($_POST['submit_add_airplane'])) {
    $model = $_POST['model'];
    $capacity = $_POST['capacity'];
    $airline_id = $_POST['airline_id'];

    $query = "INSERT INTO airplane (model, capacity, airline_id) VALUES ('$model', '$capacity', '$airline_id')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Airplane added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding airplane: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch airlines for dropdown
$airline_query = "SELECT airline_id, airline_name FROM airline";
$airline_result = mysqli_query($conn, $airline_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Airplane To the Database</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #4f46e5, #06b6d4);
            min-height: 100vh;
        }
    </style>
</head>

<body class="flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full space-y-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Add New Airplane</h2>
        
        <!-- Airplane Form -->
        <form method="POST" action="add_airplane.php" class="space-y-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="model">Model</label>
                <input type="text" id="model" name="model" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="capacity">Capacity</label>
                <input type="number" id="capacity" name="capacity" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="airline_id">Airline</label>
                <select id="airline_id" name="airline_id" class="w-full p-2 border rounded" required>
                    <option value="">Select Airline</option>
                    <?php while ($row = mysqli_fetch_assoc($airline_result)): ?>
                        <option value="<?php echo $row['airline_id']; ?>"><?php echo htmlspecialchars($row['airline_name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" name="submit_add_airplane" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 w-full">Add Airplane</button>
        </form>
    </div>
</body>

</html>
