<?php
echo "<h2>Név: Kovács Péter | Neptun: ABC123</h2>";
?>

<form method="POST" action="login.php">
  <label for="username">Felhasználónév (email):</label><br>
  <input type="text" name="username" required><br><br>

  <label for="password">Jelszó:</label><br>
  <input type="password" name="password" required><br><br>

  <input type="submit" value="Bejelentkezés">
</form>
