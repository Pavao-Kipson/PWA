<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;

    if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] == 0) {
        $upload_dir = 'img/';
        $uploaded_file = $upload_dir . basename($_FILES['pphoto']['name']);

        if (move_uploaded_file($_FILES['pphoto']['tmp_name'], $uploaded_file)) {
            $image_path = basename($_FILES['pphoto']['name']);
        } else {
            $image_path = 'default.jpg';
        }
    } else {
        $image_path = 'default.jpg';
    }

    $query = "INSERT INTO vijesti (naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES ('$title', '$about', '$content', '$image_path', '$category', '$archive')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Vijest je uspješno unesena.";
    } else {
        echo "Greška pri unosu vijesti: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
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
    <title>Unos Vijesti</title>
    <script>
        function validateForm(event) {
            event.preventDefault();
            const errorElements = document.querySelectorAll('.error');
            errorElements.forEach(el => el.remove());
            const title = document.getElementById('title');
            const about = document.getElementById('about');
            const content = document.getElementById('content');
            const pphoto = document.getElementById('pphoto');
            const category = document.getElementById('category');

            let valid = true;

            if (title.value.length < 5 || title.value.length > 30) {
                showError(title, 'Naslov vijesti mora imati 5 do 30 znakova.');
                valid = false;
            }

            if (about.value.length < 10 || about.value.length > 100) {
                showError(about, 'Kratki sadržaj vijesti mora imati 10 do 100 znakova.');
                valid = false;
            }

            if (content.value.trim() === '') {
                showError(content, 'Tekst vijesti ne smije biti prazan.');
                valid = false;
            }

            if (pphoto.files.length === 0) {
                showError(pphoto, 'Slika mora biti odabrana.');
                valid = false;
            }

            if (category.value === '') {
                showError(category, 'Kategorija mora biti odabrana.');
                valid = false;
            }

            if (valid) {
                document.getElementById('newsForm').submit();
            }
        }

        function showError(element, message) {
            element.style.borderColor = 'red';
            const error = document.createElement('div');
            error.className = 'error';
            error.style.color = 'red';
            error.innerText = message;
            element.parentNode.appendChild(error);
        }
    </script>
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
        <h2>Unos Vijesti</h2>
        <br><br>
        <form id="newsForm" action="unos.php" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event)">
            <div class="form-item">
                <label for="title">Naslov vijesti:</label>
                <br><br>
                <input type="text" name="title" id="title" class="form-field-textual">
            </div>
            <br><br><br>
            <div class="form-item">
                <label for="about">Uvod vijesti:</label>
                <br><br>
                <textarea name="about" id="about" cols="30" rows="10" class="form-field-textual" maxlength="100"></textarea>
            </div>
            <br><br><br>
            <div class="form-item">
                <label for="content">Sadržaj:</label>
                <br><br>
                <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual"></textarea>
            </div>
            <br><br><br>
            <div class="form-item">
                <label for="pphoto">Slika: </label>
                <br><br>
                <input type="file" name="pphoto" id="pphoto" accept="image/*" class="input-text">
            </div>
            <br><br><br>
            <div class="form-item">
                <label for="category">Kategorija vijesti:</label>
                <br><br>
                <select name="category" id="category" class="form-field-textual">
                    <option value="">Odaberite kategoriju</option>
                    <option value="Sport">Sport</option>
                    <option value="News">News</option>
                </select>
            </div>
            <br><br><br>
            <div class="form-item">
                <label for="archive">Spremiti u arhivu: </label>
                <input type="checkbox" name="archive" id="archive">
            </div>
            <br><br>
            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati">Prihvati</button>
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
