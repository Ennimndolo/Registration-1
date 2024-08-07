<?php
session_start();

// Update with your actual server information
$servername = "sql309.epizy.com"; // Use the correct server address
$username = "if0_37038371";
$password = "BmxhiVqH4V";
$dbname = "if0_37038371_classregistration"; // Ensure this matches the actual database name
$port = 3306; // Default MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email is already registered.";
    } else {
        // Insert user data into `users` table
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $email, $password_hash);

        if ($stmt->execute()) {
            // Store the email in session
            $_SESSION['email'] = $email;
            header("Location: index.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
$conn->close();
?>
