<?php
$host = 'localhost'; // or your host
$dbname = 'record_shop_db';
$username = 'root';
$password = "root";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    if (isset($_GET['type'])) {
        $type = $_GET['type'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE type = :type");
        $stmt->bindParam(':type', $type);
    } else {
        $stmt = $conn->prepare("SELECT * FROM products WHERE type = 'home'");
    }
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Connessione fallita" . $e->getMessage();
}
?><html>
<head>
<title>Disc Jockey</title>
<link rel="stylesheet" href="csslavoro.css" type="text/css" />
</head>
<body>
<ul class="intestazione">
<li><a href="/isa/signup">Iscriviti</a></li>
<li><a href="giftcard.html">Gift card</a></li>
<li><a href="paginapuntivendita.html">Negozi</a></li>
<li><a href="paginacontatti.html">Contatti</a></li>
</ul>
<ul class="menu">
<li><IMG SRC="images/logo.png"></li>
<li><a href="?type=home">Home</a></li>
<li><a href="?type=novelty">Novit&agrave</a></li>
<li><a href="?type=bestseller">I pi&ugrave venduti</a></li>
<li><a href="?type=sale">In offerta</a></li>
<li><a href="/isa/cart/cart.php"><IMG width="200px" height="75px" SRC="images/borse.png"></a></li>
</ul>
<div id="menuvert">
<ul>
<li><center><IMG margin="24px 0 0 0" SRC="images/menu.png"></center></li>
<li><a href="?type=new"><u>Nuovi</u></a></li>
<li><a href="?type=used"><u>Usati</u></a></li>
</ul>
</div>
<div id="contenuto">
<table width="100%">
<TR>
<td align="center" width="50%">
<IMG SRC="images/offerta.png" width=100% height=100%></td>
<td align="center" width="50%" >
<IMG SRC="images/offerta2.png" width=100% height=100%></td>
</tr>
</table>
<table width="100%">
<TR>
<?php foreach ($products as $product): ?>
<td align="center" width="20%">
<a href="product/product.php?id=<?php echo $product['id']; ?>"><IMG width: 512px src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo htmlspecialchars($product['label']); ?>" width=70% height=70%></a></td>
<?php endforeach; ?>
</tr>
<tr>
<?php foreach ($products as $product): ?>
<td align="center" width="20%"><u><?php echo htmlspecialchars($product['label']); ?></u></td>
<?php endforeach; ?>
</tr>
<tr>
<?php foreach ($products as $product): ?>
<td align="center" width="20%"><u><?php echo htmlspecialchars($product['artist_name']); ?></u></td>
<?php endforeach; ?>

</tr>
<tr>
<?php foreach ($products as $product): ?>
<td align="center" width="20%"><?php echo htmlspecialchars($product['price']); ?></td>
<?php endforeach; ?>

</table>
</div>
</body>
</html>