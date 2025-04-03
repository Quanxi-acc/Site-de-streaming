<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=netflix', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les comptes existants
$stmt = $pdo->query("SELECT nom, pp FROM compteNetflix");
$comptes = $stmt->fetchAll();

// Sélectionner un compte
if (isset($_POST['select_account'])) {
    $_SESSION['user'] = $_POST['account_name'];
    $_SESSION['pp'] = $_POST['account_pp'];
    header('Location: Accueil.php'); // Redirection vers Accueil après mise en session
    exit();
}

// Ajouter un nouveau compte
if (isset($_POST['add_account'])) {
    $new_name = $_POST['new_account'];
    $new_pp = $_POST['new_pp'];
    if (!empty($new_name) && !empty($new_pp)) {
        $stmt = $pdo->prepare("INSERT INTO compteNetflix (nom, pp) VALUES (?, ?)");
        $stmt->execute([$new_name, $new_pp]);
        header('Location: CompteNetflix.php'); // Redirection pour rafraîchir la page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du Compte - Netflix</title>
    <link rel="stylesheet" href="../CSS/CompteNetflix.css">
</head>
<body>
    <h2>Choisissez un compte</h2>
    <form method="post">
        <?php foreach ($comptes as $compte): ?>
            <button type="submit" name="select_account">
                <input type="hidden" name="account_name" value="<?php echo htmlspecialchars($compte['nom']); ?>">
                <input type="hidden" name="account_pp" value="<?php echo htmlspecialchars($compte['pp']); ?>">
                <img src="<?php echo htmlspecialchars($compte['pp']); ?>" alt="Profil">
                <span><?php echo htmlspecialchars($compte['nom']); ?></span>
            </button>
        <?php endforeach; ?>
    </form>
    <h3>Ajouter un compte</h3>
    <form method="post">
        <input type="text" name="new_account" placeholder="Nom du compte" required>
        <input type="text" name="new_pp" placeholder="Lien de l'image (ex: ../Image/Batman)" required>
        <button type="submit" name="add_account">Ajouter</button>
    </form>
</body>
</html>
