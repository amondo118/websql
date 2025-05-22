<?php
require 'decode_password.php';

$users = decode_password('password.txt');

$input_user = $_POST['username'];
$input_pass = $_POST['password'];

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
$host = getenv('RENDER_DB_HOST');
$user = getenv('RENDER_DB_USER');
$pass = getenv('RENDER_DB_PASSWORD');
$db   = getenv('RENDER_DB_NAME');

$conn = new mysqli($host, $user, $pass, $db);
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
