<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: index.html');
    exit();
}

// Database connection details
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

// Retrieve user name
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT name FROM registrations WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$name = $row['name'];
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            width: 300px;
            padding: 20px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h2 {
            margin-bottom: 20px;
        }
        .container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        .btn-smis {
            background-color: navy;
        }
        .btn-sfimish {
            background-color: dodgerblue;
        }
        .btn-accommodation {
            background-color: grey;
        }
        .btn-download {
            background-color: green;
        }
        .btn-logout {
            background-color: purple;
        }
        .container button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="font-weight: 300;">Thank you, <i><?php echo htmlspecialchars($name); ?></i><br>
        your details have been recorded</h2>
        <button class="btn-smis" onclick="window.location.href='http://smis.poly.ac.mw/login'">SMIS</button>
        <button class="btn-sfimish" onclick="window.location.href='https://sfmis.heslgb.mw/login'">SFIMIS</button>
        <button class="btn-accommodation" onclick="window.location.href='https://www.mubas.ac.mw/students/accommodation'">ACCOMMODATION</button>
        <button class="btn-download" onclick="window.location.href='generate_pdf.php'">Download PDF</button>
        <button class="btn-logout" onclick="window.location.href='index.html'">LOGOUT</button>
    </div>
</body>
</html>
