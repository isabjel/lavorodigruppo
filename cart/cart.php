<?php
// cart.php
session_start();

$host = 'localhost'; // or your host
$dbname = 'record_shop_db';
$username = 'root';
$password = "root";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header('Location: /isa/login?redirect=/isa/cart/cart.php');
    exit;
}

// Create database connection
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Fetch cart items for the user
$userId = $_SESSION["user_id"];
$stmt = $conn->prepare("
    SELECT p.id, p.label, p.price, c.quantity, p.image 
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.customer_id = ?");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div class="cart-container">
        <h1>Your Shopping Cart</h1>
        <form action="update_cart.php" method="post">
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <img class="product-image" src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>" alt="<?php echo htmlspecialchars($item['label']); ?>" />
                    <div class="product-details">
                        <h2 class="product-title"><?php echo htmlspecialchars($item['label']); ?></h2>
                        <p class="product-price">€<?php echo htmlspecialchars($item['price']); ?></p>
                        <div class="product-quantity">
                            <label for="quantity-<?php echo $item['id']; ?>">Quantity:</label>
                            <input type="number" id="quantity-<?php echo $item['id']; ?>" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
                        </div>
                        <p class="product-total">Total: €<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="update-cart">Update Cart</button>
        </form>
    </div>
</body>
</html>

