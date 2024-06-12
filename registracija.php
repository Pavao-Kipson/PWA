<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_BCRYPT);
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO korisnik (korisnicko_ime, lozinka, ime, prezime, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $korisnicko_ime, $lozinka, $ime, $prezime, $email);

    if ($stmt->execute()) {
        echo "Registracija uspješna!";
    } else {
        echo "Greška pri registraciji: " . $stmt->error;
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
    <title>Registracija</title>
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
        <h2>Registracija</h2>
        <br><br>
        <form action="registracija.php" method="POST">
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
                <label for="ime">Ime:</label>
                <br><br>
                <input type="text" id="ime" name="ime" class="form-field-textual" required>
            </div>
            <br><br><br>
            <div class="form-item">
                <label for="prezime">Prezime:</label>
                <br><br>
                <input type="text" id="prezime" name="prezime" class="form-field-textual" required>
            </div>
            <br><br><br>
            <div class="form-item">
                <label for="email">Email:</label>
                <br><br>
                <input type="email" id="email" name="email" class="form-field-textual" required>
            </div>
            <br><br><br>
            <div class="form-item">
                <button type="submit">Registracija</button>
            </div>
        </form>
    </main>
    <br><br><br>
    <footer>
        <p></p>
        <div class="footer-box">
            <hr>
            <p>Copyright © 2024. Pavao Kipson, PWA projekt, BBC stranica</p>
        </div>
    </footer>
</body>
</html>
