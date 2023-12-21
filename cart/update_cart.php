<?php
// update_cart.php
session_start();

$host = 'localhost'; // or your host
$dbname = 'record_shop_db';
$username = 'root';
$password = "root";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    echo "Please log in to update your cart.";
    exit;
}

// Create database connection
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        // Update cart item quantity
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE product_id = ? AND customer_id = ?");
        $stmt->execute([$quantity, $productId, $_SESSION["user_id"]]);
    }
    echo "Cart updated successfully!";
    header("Location: cart.php");
    exit;
}
?>
