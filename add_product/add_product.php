<?php
$host = 'localhost'; // or your host
$dbname = 'record_shop_db';
$username = 'root';
$password = "root";

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $label = $_POST['label'];
    $artistName = $_POST['artist_name'];
    $price = $_POST['price'];
    $discountedPrice = $_POST['discounted_price'];
    $type = $_POST['type'];

    $image = file_get_contents($_FILES['image']['tmp_name']);

    $stmt = $conn->prepare("INSERT INTO products (label, artist_name, price, discounted_price, image, type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $label);
    $stmt->bindParam(2, $artistName);
    $stmt->bindParam(3, $price);
    $stmt->bindParam(4, $discountedPrice);
    $stmt->bindParam(5, $image, PDO::PARAM_LOB);
    $stmt->bindParam(6, $type);
    $stmt->execute();
    echo "Product added successfully!";
}
?>
