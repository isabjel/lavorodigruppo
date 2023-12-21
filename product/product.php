<?php
// product.php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$host = 'localhost'; // or your host
$dbname = 'record_shop_db';
$username = 'root';
$password = "root";

// Create database connection
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bindParam(1, $productId, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Prodotto non trovato!";
    exit();
}

// If user clicked the "Add to Cart" button
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];
        $quantity = 1; // Example quantity

        // Insert into cart table
        $stmt = $conn->prepare("INSERT INTO cart (customer_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->bindParam(2, $productId, PDO::PARAM_INT);
        $stmt->bindParam(3, $quantity, PDO::PARAM_INT);
        $stmt->execute();

        echo "Prodotto aggiunto al carrello!";
    } else {
        header("Location: /isa/login"); // Redirect to login if not logged in
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Disc Jockey</title>
<link rel="stylesheet" href="../csslavoro.css" type="text/css" />
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<body>
<ul class="intestazione">
<li><a href="/isa/giftcard.html">Gift card</a></li>
<li><a href="/isa/paginapuntivendita.html">Negozi</a></li>
<li><a href="/isa/paginacontatti.html">Contatti</a></li>
</ul>
<ul class="menu">
<li><IMG SRC="../images/logo.png"></li>
<li><a href="/isa?type=home">Home</a></li>
<li><a href="/isa?type=novelty">Novit&agrave</a></li>
<li><a href="/isa?type=bestseller">I pi&ugrave venduti</a></li>
<li><a href="/isa?type=sale">In offerta</a></li>
<li><a href="/isa/cart/cart.php"><IMG width="200px" height="75px" SRC="../images/borse.png"></a></li>
</ul>
<div id="menuvert">
<ul>
<li><center><IMG SRC="../images/menu.png"></center></li>
<li><a href="/isa?type=new"><u>Nuovi</u></a></li>
<li><a href="/isa?type=used"><u>Usati</u></a></li>
</ul>
</div>
<div id="contenuto">
<div class="product-card">
        <div class="product-image">
            <!-- Image source will be the path to your product image -->
            <img width="250px" height="250px" src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo htmlspecialchars($product['label']); ?>">
        </div>
        <div class="product-info">
            <h2><?php echo htmlspecialchars($product['label']); ?></h2>
            <p>(7" black vinyl)</p>
            <p class="artist"><?php echo htmlspecialchars($product['artist_name']); ?></p>
            <p class="release-date">Universal music 23 novembre 2023</p>
            <p class="price">€ <?php echo htmlspecialchars($product['price']); ?></p>
            <div class="product-actions">
            <form action="product.php?id=<?php echo htmlspecialchars($productId); ?>" method="post">
                <input type="submit" class="btn add-to-cart" value="Aggiungi al carrello" />
</form>
               
            </div>
        </div>
    </div>
<br>
<h1>Descrizione</h1>
<p class="descrizione"> <?php echo htmlspecialchars($product['descrizione']); ?>
</p>
</div>
</body>
</html>
