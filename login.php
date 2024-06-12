<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];

    $stmt = $conn->prepare("SELECT id, lozinka, uloga, ime FROM korisnik WHERE korisnicko_ime = ?");
    $stmt->bind_param("s", $korisnicko_ime);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $uloga, $ime);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($lozinka, $hashed_password)) {
            $_SESSION['korisnicko_ime'] = $korisnicko_ime;
            $_SESSION['uloga'] = $uloga;
            $_SESSION['ime'] = $ime;
            header("Location: administrator.php");
        } else {
            echo "Neispravna lozinka.";
        }
    } else {
        echo "Korisnik ne postoji. <a href='registracija.php'>Registrirajte se ovdje</a>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Text:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> 
    <title>Prijava</title>
</head>
<body>
    <header>
        <div class="headerBox">
            <div class="logo">
                <img src="BBClogo.jpg" alt="BBC Logo">
            </div>
            <nav class="nav-menu">
                <ul>
                    <li id="Home"><a href="index.php">Home</a></li>
                    <li id="News"><a href="kategorija.php?id=News">News</a></li>
                    <li id="Sport"><a href="kategorija.php?id=sport">Sport</a></li>
                    <li><a href="administrator.php">Administracija</a></li>
                    <li><a href="unos.php">Unos</a></li>
                    <li><a href="registracija.php">Registracija</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <h2>Prijava</h2>
        <br><br>
        <form action="login.php" method="POST">
            <div class="form-item">
                <label for="korisnicko_ime">Korisničko ime:</label>
                <br><br>
                <input type="text" id="korisnicko_ime" name="korisnicko_ime" class="form-field-textual" required>
            </div>
            <br><br><br>
            <div class="form-item">
                <label for="lozinka">Lozinka:</label>
                <br><br>
                <input type="password" id="lozinka" name="lozinka" class="form-field-textual" required>
            </div>
            <br><br><br>
            <div class="form-item">
                <button type="submit">Prijava</button>
            </div>
        </form>
    </main>
    <br><br><br><br><br><br><br><br><br><br>
    <footer>
        <p></p>
        <div class="footer-box">
            <hr>
            <p>Copyright © 2024. Pavao Kipson, PWA projekt, BBC stranica</p>
        </div>
    </footer>
</body>
</html>
