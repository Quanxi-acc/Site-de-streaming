<?php
$boolPseudo = 0;
if (isset ($_POST ["pseudo"]) && $_POST["pseudo"]=="erreur"){
  $textError = "<p> Le pseudo saisi est invalide </p>";
  $boolPseudo = 1;
}
$boolMdp = 0;
if (isset ($_POST["motdepasse"]) && $_POST["motdepasse"]=="erreur"){
  $textError2 = "<p> Le mot de passe est invalide </p>";
  $boolMdp = 1;
}
$boolAdmin=0;
if(isset($_POST["erreur"]) && $_POST ["erreur"] == "admin"){
  $textError3 = " <p> Vous n'êtes pas administrateurs </p>";
  $boolAdmin=1;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
</head>
<body>
<form action="TraitementDeConnexion.php" method="post">

<?php
  if($boolPseudo == 1){
      echo $textError;
  }
  if($boolMdp == 1){
      echo $textError2;
  }
  if($boolAdmin){
    echo $textError3;  
  }
?>


<div>
  <label for="pseudo">Pseudo:</label>
  <input type="text" id="pseudo" name="pseudo" />
</div>
<br>
<div>
  <label for="motdepasse">Mot de passe:</label>
  <input type="text" id="motdepasse" name="motdepasse" required />
</div>

<input type="submit" value="Se connecter" />


<div class="link">
<a href="Inscription.php">Pas encore Inscrit ?</a>
</div>

</body>
</html>