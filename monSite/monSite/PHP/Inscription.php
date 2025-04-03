
<?php
    if(isset($_POST["error"])){
        if($_POST["error"] == "form"){
            $error = "form";
        }else if($_POST["error"] == "unique"){
            $error = "unique";
        }
    }else{
        $error = "";
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>

    <?php
        if($error == "form")
            echo "<p id=\"error\"> Le formulaire n'est pas correct </p>";
        if($error == "unique")
            echo "<p id=\"unique\"> Cet email existe déjà.</p>";
    ?>

<form action="TraitementInscription.php" method="post">
    <div>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom">
    </div>
    <br>
    <div>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom">
    </div>
    <br>
    <div>
        <label for="pseudo">Pseudo:</label>
        <input type="text" id="pseudo" name="pseudo">
    </div>
    <br>
    <div>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
    </div>
    <br>
    <div>
        <label for="motdepasse">Mot de passe:</label>
        <input type="text" id="motdepasse" name="motdepasse">
    </div>
    <br>
    <div>
        <label for="datenaissance">Date de naissance:</label>
        <input type="date" id="datenaissance" name="datenaissance" >
    </div>
    <br>
    <div>
        <span>Genre:<br>
        <input type="radio" id="homme" name="genre" value="homme">
        <label for="homme">Homme</label><br>
        <input type="radio" id="femme" name="genre" value="femme">
        <label for="femme">Femme</label>
    </div>

    <br>
    <input type="submit" value="S'inscrire" />

<div class="link">
<a href="../PHP/Connexion.php">Se connecter ?</a>
</div>

</form>
</body>
</html>
