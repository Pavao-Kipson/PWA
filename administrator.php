<?php
session_start();
if (!isset($_SESSION['korisnicko_ime'])) {
    header("Location: login.php");
    exit();
}

include 'connect.php';

if ($_SESSION['uloga'] != 'admin') {
    echo "Pozdrav, " . htmlspecialchars($_SESSION['ime']) . ". Nemate pravo pristupa administratorskoj stranici.";
    exit();
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
    <title>Administracija</title>
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
        <h2>Administracija Vijesti</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                $stmt = $conn->prepare("DELETE FROM vijesti WHERE id = ?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    echo "Vijest je uspješno izbrisana.";
                } else {
                    echo "Greška pri brisanju vijesti: " . $stmt->error;
                }
                $stmt->close();
            }

            if (isset($_POST['update'])) {
                $id = $_POST['id'];
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
                    $image_path = $_POST['existing_image'];
                }

                $stmt = $conn->prepare("UPDATE vijesti SET naslov = ?, sazetak = ?, tekst = ?, slika = ?, kategorija = ?, arhiva = ? WHERE id = ?");
                $stmt->bind_param("ssssssi", $title, $about, $content, $image_path, $category, $archive, $id);
                
                if ($stmt->execute()) {
                    echo "Vijest je uspješno izmijenjena.";
                } else {
                    echo "Greška pri izmjeni vijesti: " . $stmt->error;
                }
                $stmt->close();
            }
        }
        
        $stmt = $conn->prepare("SELECT * FROM vijesti");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo '<form enctype="multipart/form-data" action="administrator.php" method="POST">';
            echo '<div class="form-item">';
            echo '<br><br>';
            echo '<label for="title">Naslov vijesti:</label>';
            echo '<br><br>';
            echo '<input type="text" name="title" value="' . htmlspecialchars($row['naslov']) . '" class="form-field-textual">';
            echo '</div>';
            echo '<br><br><br>';
            echo '<div class="form-item">';
            echo '<label for="about">Uvod vijesti:</label>';
            echo '<br><br>';
            echo '<textarea name="about" cols="30" rows="10" class="form-field-textual">' . htmlspecialchars($row['sazetak']) . '</textarea>';
            echo '</div>';
            echo '<br><br><br>';
            echo '<div class="form-item">';
            echo '<label for="content">Sadržaj:</label>';
            echo '<br><br>';
            echo '<textarea name="content" cols="30" rows="10" class="form-field-textual">' . htmlspecialchars($row['tekst']) . '</textarea>';
            echo '</div>';
            echo '<br><br><br>';
            echo '<div class="form-item">';
            echo '<label for="pphoto">Slika:</label>';
            echo '<br><br>';
            echo '<input type="file" class="input-text" name="pphoto">';
            echo '<input type="hidden" name="existing_image" value="' . htmlspecialchars($row['slika']) . '">';
            echo '<br><br>';
            echo '<img src="img/' . htmlspecialchars($row['slika']) . '" width="100px">';
            echo '</div>';
            echo '<br><br><br>';
            echo '<div class="form-item">';
            echo '<label for="category">Kategorija vijesti:</label>';
            echo '<br><br>';
            echo '<select name="category" class="form-field-textual">';
            echo '<option value="Sport"' . ($row['kategorija'] == 'Sport' ? ' selected' : '') . '>Sport</option>';
            echo '<option value="News"' . ($row['kategorija'] == 'News' ? ' selected' : '') . '>News</option>';
            echo '</select>';
            echo '</div>';
            echo '<br><br><br>';
            echo '<div class="form-item">';
            echo '<label>Spremiti u arhivu: </label>';
            echo '<input type="checkbox" name="archive"' . ($row['arhiva'] == 1 ? ' checked' : '') . '>';
            echo '</div>';
            echo '<br>';
            echo '<div class="form-item">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo '<button type="reset" value="Poništi">Poništi</button>';
            echo '<button type="submit" name="update" value="Prihvati">Izmjeni</button>';
            echo '<button type="submit" name="delete" value="Izbriši">Izbriši</button>';
            echo '</div>';
            echo '</form>';
            echo '<br><br><br>';
        }

        $stmt->close();
        $conn->close();
        ?>
    </main>
    <footer>
        <p></p>
        <div class="footer-box">
            <hr>
            <p>Copyright © 2024. Pavao Kipson, PWA projekt, BBC stranica</p>
        </div>
    </footer>
</body>
</html>
