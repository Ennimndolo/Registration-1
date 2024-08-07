<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$servername = "sql309.epizy.com"; // Update with your actual server address
$username = "if0_37038371"; // Update with your actual username
$password = "BmxhiVqH4V"; // Update with your actual password
$dbname = "if0_37038371_classregistration"; // Update with your actual database name
$port = 3306; // Default MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $gender = htmlspecialchars($_POST['gender']);
    $class = htmlspecialchars($_POST['class']);
    $btech_subclass = isset($_POST['btech-subclass']) ? htmlspecialchars($_POST['btech-subclass']) : null;

    // Check if the email matches the one used for account creation
    if ($email !== $_SESSION['email']) {
        echo "Error: The email used does not match the email used for account creation.";
        exit();
    }

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT * FROM registrations WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: This email is already registered.";
        exit();
    }

    // Insert registration data into `registrations` table
    $stmt = $conn->prepare("INSERT INTO registrations (name, email, phone, gender, class) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sssss", $name, $email, $phone, $gender, $class);

    if ($stmt->execute()) {
        // Insert optional BTECH subclass if applicable
        if ($class === 'BTECH' && $btech_subclass) {
            $stmt = $conn->prepare("UPDATE registrations SET btech_subclass = ? WHERE email = ?");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("ss", $btech_subclass, $email);
            $stmt->execute();
        }

        // Redirect to home.php with a success message
        $_SESSION['loggedin'] = true; // Set session variable to indicate successful registration
        header("Location: home.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
