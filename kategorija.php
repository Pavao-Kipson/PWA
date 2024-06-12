<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Text:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Kategorija Vijesti</title>
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
                    <li id="Sport"><a href="kategorija.php?id=Sport">Sport</a></li>
                    <li><a href="administrator.php">Administracija</a></li>
                    <li><a href="unos.php">Unos</a></li>
                    <li><a href="registracija.php">Registracija</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h2><?php echo htmlspecialchars($_GET['id']); ?></h2>
        <br><br><br>
        <section class="novosti">
            <?php
            include 'connect.php';
            $category = $_GET['id'];
            $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='$category'";
            $result = mysqli_query($conn, $query);

            while($row = mysqli_fetch_array($result)) {
                echo '<div>';
                echo '<a href="clanak.php?id=' . $row['id'] . '" style="color: black; text-decoration: none;">';
                echo '<img src="img/' . $row['slika'] . '" alt="">';
                echo '<h4 style="color: black; text-decoration: none;">' . htmlspecialchars($row['naslov']) . '</h4>';
                echo '<p>' . htmlspecialchars($row['sazetak']) . '</p>';
                echo '</a>';
                echo '</div>';
            }
            ?>
        </section>
    </main>
    <br><br><br><br><br><br><br><br><br>
    <br><br>
    <footer>
        <p></p>
        <div class="footer-box">
            <hr>
            <p>Copyright © 2024. Pavao Kipson, PWA projekt, BBC stranica</p>        
        </div>
    </footer>
</body>
</html>
