<?php
include 'conectare_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume_utilizator = $_POST['uname'];
    $parola = $_POST['psw'];

    $query = "SELECT id, username, parola FROM utilizatori WHERE username=?";
    $stmt = $conexiune->prepare($query);

    if ($stmt === false) {
        die("Eroare la pregătirea interogării: " . $conexiune->error);
    }

    $stmt->bind_param("s", $nume_utilizator);
    $stmt->execute();

    $rezultat = $stmt->get_result();

    if ($rezultat->num_rows > 0) {
        $rand = $rezultat->fetch_assoc();

        if (password_verify($parola, $rand['parola'])) {
            // Autentificare reușită, redirect către notite.php
            header("Location: notite.php");
            exit();
        } else {
            // Parolă incorectă
            echo '<script>alert("Parolă incorectă!"); window.location.href = "index.php?error=Parola incorecta";</script>';

        }
    } else {
        // Nume de utilizator inexistent
        echo '<script>alert("Nume de utilizator inexistent!"); window.location.href = "index.php?error=Nume de utilizator inexistent";</script>';
    }

    $stmt->close();
}

$conexiune->close();
?>
