<?php
session_start();

// Correct the server name
$servername = "sql309.epizy.com";
$username = "if0_37038371";
$password = "BmxhiVqH4V";
$dbname = "if0_37038371_classregistration"; // Use the full database name provided by InfinityFree
$port = 3306; // Default MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            header("Location: register.html");
            exit();
        } else {
            echo "Invalid login.";
        }
    } else {
        echo "Invalid login.";
    }

    $stmt->close();
}
$conn->close();
?>
