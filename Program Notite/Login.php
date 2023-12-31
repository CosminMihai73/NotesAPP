<!DOCTYPE html>
<html>
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
    <form action="verificare_autentificare.php" method="post">
        <label for="uname"><b>Nume utilizator</b></label>
        <input type="text" placeholder="Introduceți numele de utilizator" name="uname" required>

        <label for="psw"><b>Parolă</b></label>
        <input type="password" placeholder="Introduceți parola" name="psw" required>

        <button type="submit">Autentificare</button>
    </form>
</div>

<div class="container" style="background-color:#8DD3FFFF">
    <span class="register">Nu ai un cont? <a href="register.php">Înregistrează-te</a></span>
</div>
<?php
include 'conectare_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume_utilizator = $_POST['uname'];
    $parola = $_POST['psw'];

    // Query pentru a selecta utilizatorul din baza de date
    $query = "SELECT id, username, parola FROM utilizatori WHERE username=?";
    $stmt = $conexiune->prepare($query);

    // Verificăm dacă pregătirea interogării a reușit
    if ($stmt === false) {
        die("Eroare la pregătirea interogării: " . $conexiune->error);
    }

    // Legăm parametrii și executăm interogarea
    $stmt->bind_param("s", $nume_utilizator);
    $stmt->execute();

    // Obținem rezultatele
    $rezultat = $stmt->get_result();

    // Verificăm dacă există un rând corespunzător
    if ($rezultat->num_rows > 0) {
        $rand = $rezultat->fetch_assoc();

        // Verificăm parola folosind password_verify
        if (password_verify($parola, $rand['parola'])) {
            // Autentificare reușită
            session_start();
            $_SESSION['nume_utilizator'] = $rand['username'];
            header("Location: notite.php"); // Redirect către notite.php sau altă pagină
            exit();
        }
    }
        $stmt->close();
}

$conexiune->close();
?>

</body>
</html>
