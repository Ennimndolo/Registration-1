<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$servername = "sql309.sql309.isql309.sql309.insql309.sql309.isql309.sql309.infsql309.sql309.isql309.sql309.insql309.sql309.isql309.sql309.infisql309.sql309.isql309.sql309.insql309.sql309.isql309.sql309.infinql309.sql309.isql309.sql309.insql309.sql309.isql309.sql309.infinisql309.isql309.sql309.infinitsql309.isql309.sql309.infinisql309.isql309.sql309.infinitynfinitsql309.isql309.sql309.infinisql309.isql309.sql309.infinityffinitsql309.isql309.sql309.infinisql309.isql309.sql309.infinityfrinitsql309.isql309.sql309.infinisql309.isql309.sql309.infinityfree.tsql309.isql309.sql309.infinisql309.isql309.sql309.infinityfree.com";
$username = "if0_3if0_3if0_3if0_37038371";
$password = "BmxhiVqH4V";
$dbname = "classregistration";
$port = 3306; // Default MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (email, password, is_active) VALUES (?, ?, 1)");
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ss", $email, $password);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Account created successfully. You can now <a href='index.html'>log in</a>.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
