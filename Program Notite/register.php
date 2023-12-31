<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<h2>Aplicatie Notite</h2>

<div class="imgcontainer">
    <img src="poze/avatar-removebg-preview.png" alt="Avatar" class="avatar">
</div>

<div class="container">
    <form method="post" action="register.php">
        <label for="uname"><b>Nume utilizator</b></label>
        <input type="text" placeholder="Introduceți numele de utilizator" name="uname" required>

        <label for="psw"><b>Parolă</b></label>
        <input type="password" placeholder="Introduceți parola" name="psw" required>

        <label for="psw-repeat"><b>Repetare parolă</b></label>
        <input type="password" placeholder="Reintroduceți parola" name="psw-repeat" required>

        <button type="submit">Creare cont</button>
    </form>
</div>

<div class="container" style="background-color:#8DD3FFFF">
    <span class="register">Ai cont deja? <a href="Login.php">Conecteza-te</a></span>
</div>
<?php
include 'conectare_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume_utilizator = $_POST['uname'];
    $parola = $_POST['psw'];
    $parola_repeat = $_POST['psw-repeat'];

    // Verificăm dacă parolele coincid
    if ($parola !== $parola_repeat) {
        echo "Parolele nu coincid.";
        exit();
    }

    // Hash pentru parolă (în producție, ar trebui să utilizați funcții de hashare mai sigure)
    $parola_hash = password_hash($parola, PASSWORD_DEFAULT);

    // Query pentru inserarea utilizatorului în baza de date
    $query = "INSERT INTO utilizatori (username, parola) VALUES (?, ?)";
    $stmt = $conexiune->prepare($query);

    // Verificăm dacă pregătirea interogării a reușit
    if ($stmt === false) {
        die("Eroare la pregătirea interogării: " . $conexiune->error);
    }

    // Legăm parametrii și executăm interogarea
    $stmt->bind_param("ss", $nume_utilizator, $parola_hash);
    $rezultat = $stmt->execute();

    if ($rezultat) {
        echo "Cont creat cu succes!";
        header("Location: Login.php");
        exit();
    } else {
        echo "Eroare la înregistrare: " . $stmt->error;
    }

    $stmt->close();
}

$conexiune->close();
?>

</body>
</html>
