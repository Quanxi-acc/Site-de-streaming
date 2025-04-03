<?php
session_start();

// Connexion à la base de données
try {
    $bd = new PDO("mysql:host=localhost;dbname=netflix", "root", "");
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die($e->getMessage());
}

// Vérifier le compte en session
$userInfo = null;
if (isset($_SESSION['user'])) {
    $stmt = $bd->prepare("SELECT pp FROM compteNetflix WHERE nom = :nom");
    $stmt->bindParam(':nom', $_SESSION['user'], PDO::PARAM_STR);
    $stmt->execute();
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupérer les films (type 3)
$sql = "SELECT * FROM film WHERE fkType = 3";
$requete = $bd->prepare($sql);
$requete->execute();
$films = $requete->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films - Netflix</title>
    <link rel="stylesheet" href="../CSS/Accueil.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Netflix</h1>
        </div>

        <nav>
            <ul>
                <li><a href="Accueil.php">Accueil</a></li>
                <li><a href="Films.php">Films</a></li>
                <li><a href="Series.php">Séries</a></li>
                <li><a href="CompteNetflix.php">Mon Compte</a></li>
            </ul>
        </nav>

        <div class="profil">
            <?php if ($userInfo): ?>
                <img src="<?php echo htmlspecialchars($userInfo['pp']); ?>" >
            <?php endif; ?>
        </div>
    </header>

    <!-- Carousel -->
    <section class="carousel">
        <div class="carousel-container">
            <?php foreach ($films as $film): ?>
                <div class="carousel-item">
                    <img src="<?php echo htmlspecialchars($film['image']); ?>" 
                         alt="<?php echo htmlspecialchars($film['nom']); ?>"> 
                </div>
            <?php endforeach; ?>
        </div>
        <button class="prev" aria-label="Précédent">&#10094;</button>
        <button class="next" aria-label="Suivant">&#10095;</button>
    </section>

    <script src="../JS/Carousel.js"></script>
</body>
</html>
