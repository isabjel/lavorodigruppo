<?php
// signup.php
session_start(); 
$host = 'localhost'; // or your host
$dbname = 'record_shop_db';
$username = 'root';
$password = "root";

// Create database connection
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $userpassword =$_POST['password'];

    // Insert query
    $stmt = $conn->prepare("INSERT INTO customer (name, email, address, password) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $address);
    $stmt->bindParam(4, $userpassword);

    // Execute and check for errors
    try {
        $stmt->execute();
        $last_id = $conn->lastInsertId();

        // Set session variables
        $_SESSION["user_id"] = $last_id;
        $_SESSION["user_name"] = $name;
        $_SESSION["user_email"] = $email;
        echo "Registrazione avvenuta con successo!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
