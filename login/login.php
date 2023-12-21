<?php
// login.php
session_start(); // Start the session

$host = 'localhost'; // or your host
$dbname = 'record_shop_db';
$username = 'root';
$password = 'root';

try {
    // Create database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $submittedPassword = $_POST['password'];

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM customer WHERE email = ? and password = ?");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $submittedPassword);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Set session variables
            $_SESSION["user_id"] = $user['id'];
            $_SESSION["user_name"] = $user['name'];
            $_SESSION["user_email"] = $user['email'];

            // Redirect
            if (isset($_GET['redirect'])) {
                header("Location: " . $_GET['redirect']);
                exit();
            }
            header('Location: /isa');
            exit();
            echo "Login eseguito con successo!";
        } else {
            echo "Email o password non valida :(";
        }
    }
} catch(PDOException $e) {
    echo "Connessione fallita: " . $e->getMessage();
}
?>
