<?php
session_start();
require_once '../db_connection.php';
require_once 'PricingStrategy.php';
require_once 'EconomyPricing.php';
require_once 'BusinessPricing.php';
require_once 'TicketComponent.php';
require_once 'Ticket.php';
require_once 'DiscountDecorator.php';
require_once 'EarlyBookingDiscountDecorator.php';
require_once 'PromotionalDiscountDecorator.php';
require_once 'Flight.php';
require_once 'FlightObserver.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header('Location: user_login.php');
    exit();
}

$conn = Database::getInstance()->getConnection();

// Initialize variables
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$loggedInUserId = $_SESSION['user_id'];

// Handle subscription to flight updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subscribe_flight'])) {
    $flight_id = $_POST['flight_id'];

    // Check if the user is already subscribed
    $checkQuery = "SELECT * FROM flight_observers WHERE user_id = ? AND flight_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $loggedInUserId, $flight_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Add the user as an observer
        $insertQuery = "INSERT INTO flight_observers (user_id, flight_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $loggedInUserId, $flight_id);
        if ($stmt->execute()) {
            echo "<script>alert('Subscribed to flight updates successfully!');</script>";
        } else {
            echo "<script>alert('Error subscribing to flight updates: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('You are already subscribed to this flight!');</script>";
    }
}

// Handle ticket booking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_ticket'])) {
    $flight_id = $_POST['flight_id'];
    $pricing_type = $_POST['pricing_type'];

    // Fetch the base price of the flight
    $sql = "SELECT price FROM flight WHERE flight_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $flight_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $flight = $result->fetch_assoc();
    $basePrice = floatval($flight['price']);

    // Select pricing strategy
    $pricingStrategy = ($pricing_type === 'business') ? new BusinessPricing() : new EconomyPricing();

    // Create a base ticket
    $ticket = new Ticket($basePrice, $pricingStrategy);

    // Apply discounts using decorators
    $ticketWithEarlyBookingDiscount = new EarlyBookingDiscountDecorator($ticket, $flight_id);
    $ticketWithAllDiscounts = new PromotionalDiscountDecorator($ticketWithEarlyBookingDiscount);

    // Calculate the final price and get the description
    $finalPrice = $ticketWithAllDiscounts->getPrice();
    $description = $ticketWithAllDiscounts->getDescription();

    // Calculate the total discount percentage
    $earlyBookingDiscount = $ticketWithEarlyBookingDiscount->getDiscountPercentage();
    $promotionalDiscount = $ticketWithAllDiscounts->getDiscountPercentage();
    $totalDiscount = 0;
    if ($earlyBookingDiscount > 0) {
        $totalDiscount += $earlyBookingDiscount;
    }
    if ($promotionalDiscount > 0) {
        $totalDiscount += $promotionalDiscount * (1 - $earlyBookingDiscount / 100); // Adjust for sequential discounts
    }

    // Insert the ticket into the database
    $insertQuery = "INSERT INTO ticket (user_id, flight_id, final_price, pricing_type, discount_applied) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iidsd", $loggedInUserId, $flight_id, $finalPrice, $pricing_type, $totalDiscount);
    if ($stmt->execute()) {
        echo "<script>alert('Ticket booked successfully! Final Price: $$finalPrice\\n$description');</script>";
    } else {
        echo "<script>alert('Error booking ticket: " . $stmt->error . "');</script>";
    }
}

// Fetch flights
if ($search) {
    $sql = "SELECT flight_id, flight_number, departure_time, arrival_time, status, price, gate_number 
            FROM flight 
            WHERE flight_number LIKE '%$search%' OR status LIKE '%$search%'";
} else {
    $sql = "SELECT flight_id, flight_number, departure_time, arrival_time, status, price, gate_number FROM flight";
}

$result = $conn->query($sql);

// Fetch notifications for the logged-in user
$notifications = [];
$notifQuery = "SELECT fs.* FROM flight_status fs
               JOIN flight_observers fo ON fs.flight_id = fo.flight_id
               WHERE fo.user_id = ?";
$stmt = $conn->prepare($notifQuery);
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$notifResult = $stmt->get_result();
while ($row = $notifResult->fetch_assoc()) {
    $notifications[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <div class="max-w-5xl mx-auto p-4">
        <h1 class="text-3xl font-bold text-center text-green-600 mb-8">Available Flights</h1>

        <!-- Notifications Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Flight Update Notifications</h2>
            <?php if (count($notifications) > 0): ?>
                <ul class="space-y-2">
                    <?php foreach ($notifications as $notif): ?>
                        <li class="p-3 bg-blue-100 rounded-lg">
                            Flight ID: <?= htmlspecialchars($notif['flight_id']); ?> - 
                            Status: <?= htmlspecialchars($notif['status_update']); ?><?php if ($notif['gate_number']): ?>, 
                            Gate Number: <?= htmlspecialchars($notif['gate_number']); ?><?php endif; ?> - 
                            Reason: <?= htmlspecialchars($notif['reason'] ?? 'No reason provided'); ?> - 
                            Updated at: <?= htmlspecialchars($notif['update_time']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-500">No notifications available. Subscribe to flights to receive updates.</p>
            <?php endif; ?>
        </div>

        <div class="mb-6">
            <form action="user.php" method="GET" class="flex justify-center items-center space-x-4">
                <input type="text" name="search" placeholder="Search by flight number or status"
                    value="<?= htmlspecialchars($search) ?>"
                    class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" />
                <button type="submit"
                    class="h-full px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">Search</button>
                <div class="space-x-3 my-3">
                    <a href="../admin/index.html"
                        class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">Back to Home</a>
                    <a href="http://localhost/airlinedb/admin/admin_login.php"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Switch to Admin</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead>
                    <tr class="bg-green-100 text-left text-gray-600 uppercase text-sm">
                        <th class="py-3 px-4 border-b">Flight ID</th>
                        <th class="py-3 px-4 border-b">Flight Number</th>
                        <th class="py-3 px-4 border-b">Departure Time</th>
                        <th class="py-3 px-4 border-b">Arrival Time</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">Gate Number</th>
                        <th class="py-3 px-4 border-b">Base Price</th>
                        <th class="py-3 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $basePrice = floatval($row['price']);
                            echo "<tr class='border-b hover:bg-gray-50'>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["flight_id"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["flight_number"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["departure_time"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["arrival_time"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["status"]) . "</td>
                                <td class='py-3 px-4'>" . htmlspecialchars($row["gate_number"]) . "</td>
                                <td class='py-3 px-4'>$" . number_format($basePrice, 2) . "</td>
                                <td class='py-3 px-4'>
                                    <button onclick=\"document.getElementById('book-form-{$row['flight_id']}').style.display='block'\" 
                                            class='px-9 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition '>
                                        Book Ticket
                                    </button>
                                    <form action='user.php' method='POST' class='inline'>
                                        <input type='hidden' name='flight_id' value='{$row['flight_id']}'>
                                        <button type='submit' name='subscribe_flight' 
                                                class='px-3 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition mt-2 flex flex-grow'>
                                            Subscribe to get Updates
                                        </button>
                                    </form>
                                    <div id='book-form-{$row['flight_id']}' style='display:none;' class='mt-2 p-4 bg-gray-100 rounded-lg'>
                                        <form action='user.php' method='POST'>
                                            <input type='hidden' name='flight_id' value='{$row['flight_id']}'>
                                            <div class='mb-2'>
                                                <label class='block text-sm font-medium text-gray-700'>Pricing Type</label>
                                                <select name='pricing_type' class='w-full px-3 py-2 border border-gray-300 rounded-md'>
                                                    <option value='economy'>Economy</option>
                                                    <option value='business'>Business</option>
                                                </select>
                                            </div>
                                            <button type='submit' name='book_ticket' 
                                                    class='w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition'>
                                                Confirm Booking
                                            </button>
                                            <button type='button' onclick=\"document.getElementById('book-form-{$row['flight_id']}').style.display='none'\" 
                                                    class='w-full mt-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition'>
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='py-4 text-center text-gray-500'>No flights found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
if ($conn) {
    $conn->close();
}
?>