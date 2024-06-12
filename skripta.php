<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $archive = isset($_POST['archive']) ? 'Da' : 'Ne';
    
    if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] == 0) {
        $upload_dir = 'img/';
        $uploaded_file = $upload_dir . basename($_FILES['pphoto']['name']);
        
        if (move_uploaded_file($_FILES['pphoto']['tmp_name'], $uploaded_file)) {
            $image_path = $uploaded_file;
        } else {
            $image_path = 'img/default.jpg';
        }
    } else {
        $image_path = 'img/default.jpg';
    }

    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<link rel="stylesheet" href="style.css">';
    echo '<title>' . htmlspecialchars($title) . '</title>';
    echo '</head>';
    echo '<body>';
    echo '<header>';
    echo '<div class="headerBox">';
    echo '<div class="logo">';
    echo '<img src="BBClogo.jpg" alt="BBC Logo">';
    echo '</div>';
    echo '<nav class="nav-menu">';
    echo '<ul>';
    echo '<li id="Home"><a href="index.html">Home</a></li>';
    echo '<li id="News"><a href="kategorija.php?id=News">News</a></li>';
    echo '<li id="Sport"><a href="clanak.html">Sport</a></li>';
    echo '<li><a href="#">Administracija</a></li>';
    echo '<li><a href="unos.html">Unos</a></li>';
    echo '</ul>';
    echo '</nav>';
    echo '</div>';
    echo '</header>';
    echo '<main>';
    echo '<section role="main">';
    echo '<div class="row">';
    echo '<p class="category">' . htmlspecialchars($category) . '</p>';
    echo '<br><br>';
    echo '<h1 class="title">' . htmlspecialchars($title) . '</h1>';
    echo '<br><br>';
    echo '</div>';
    echo '<section class="slika">';
    echo "<img src='" . htmlspecialchars($image_path) . "' alt='News Image'>";
    echo '</section>';
    echo '<section class="about">';
    echo '<p>' . htmlspecialchars($about) . '</p>';
    echo '</section>';
    echo '<br><br>';
    echo '<section class="sadrzaj">';
    echo '<p>' . htmlspecialchars($content) . '</p>';
    echo '</main>';
    echo '<br><br>';
    echo '<footer>';
    echo '<p></p>';
    echo '<div class="footer-box">';
    echo '<hr>';
    echo '<p>Copyright © 2024. Pavao Kipson, PWA projekt, BBC stranica</p>';
    echo '</div>';
    echo '</footer>';
    echo '</body>';
    echo '</html>';
}
?>
