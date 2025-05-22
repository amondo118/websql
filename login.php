<?php
require 'decode_password.php';


$correct_pass = $users[$input_user];
if ($input_pass !== $correct_pass) {
    header("refresh:3;url=https://www.police.hu");
    echo "Hibás jelszó. Átirányítás a police.hu-ra 3 másodperc múlva...";
    exit;
}
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'adatok';

// Connect to MySQL
try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($conn->connect_error) {
        throw new Exception("MySQL connection failed: " . $conn->connect_error);
    }

    // Rest of your login logic...
    $users = decode_password('password.txt');
    $input_user = $_POST['username'];
    $input_pass = $_POST['password'];

    if (!isset($users[$input_user])) {
        echo "Nincs ilyen felhasználó.";
        exit;
    }

    // ... rest of your code

} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

$stmt = $conn->prepare("SELECT Titkos FROM tabla WHERE Username = ?");
$stmt->bind_param("s", $input_user);
$stmt->execute();
$stmt->bind_result($szin);
$stmt->fetch();
$stmt->close();
$conn->close();

echo "<body style='background-color: $szin; color: white;'>";
echo "<h1>Sikeres belépés!</h1>";
echo "<p>Kedvenc színed: <strong>$szin</strong></p>";
echo "</body>";
?>
