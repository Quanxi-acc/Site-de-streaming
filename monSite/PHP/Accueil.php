<?php
// Connexion à la base de données
try {
    $bd = new PDO("mysql:host=localhost;dbname=netflix", "root", "");
} catch (Exception $e) {
    die($e->getMessage());
}

// Récupération des films
$sql = "SELECT * FROM film";
$requete = $bd->prepare($sql);
$requete->execute();
$films = $requete->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Netflix</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Netflix</h1>
            </div>
            <ul>
                <li><a href="Accueil.php">Accueil</a></li>
                <li><a href="Films.php">Films</a></li>
                <li><a href="Series.php">Séries</a></li>
                <li><a href="MonCompte.php">Mon Compte</a></li>
            </ul>
        </nav>
    </header>

    <!-- Carousel -->
    <section class="carousel">
        <div class="carousel-container">
            <?php foreach ($films as $film): ?>
                <div class="carousel-item">
                    <img src="<?php echo $film['image'] ?>" 
                         alt="<?php echo $film['nom']; ?>"> 
                </div>
            <?php endforeach; ?>
        </div>
        <button class="prev">&#10094;</button>
        <button class="next">&#10095;</button>
    </section>

    <script src="../JS/Carousel.js" ></script>
    <link href="../CSS/Accueil.css" rel="stylesheet" />
</body>
</html>
