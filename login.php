<?php
require 'decode_password.php';

// Get user input
$input_user = $_POST['username'] ?? '';
$input_pass = $_POST['password'] ?? '';

// Get database credentials from environment (Render will provide these)
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'adatok';

// Connect to MySQL
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    throw new Exception("MySQL connection failed: " . $conn->connect_error);
}

// Decode and check password first
$users = decode_password('password.txt');

if (!isset($users[$input_user])) {
    echo "Nincs ilyen felhasználó.";
    exit;
}

$correct_pass = $users[$input_user];
if ($input_pass !== $correct_pass) {
    header("refresh:3;url=https://www.police.hu");
    echo "Hibás jelszó. Átirányítás a police.hu-ra 3 másodperc múlva...";
    exit;
}

// Get user's color
$stmt = $conn->prepare("SELECT Titkos FROM tabla WHERE Username = ?");
if (!$stmt) {
    throw new Exception("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $input_user);
if (!$stmt->execute()) {
    throw new Exception("Execute failed: " . $stmt->error);
}

$stmt->bind_result($szin);
$stmt->fetch();
$stmt->close();
$conn->close();

// Successful login
echo "<body style='background-color: $szin; color: white;'>";
echo "<h1>Sikeres belépés!</h1>";
echo "<p>Kedvenc színed: <strong>$szin</strong></p>";
echo "</body>";


?>