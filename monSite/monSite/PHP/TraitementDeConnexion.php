<?php
if (isset($_POST["pseudo"])){
    $pseudo=$_POST["pseudo"];
}else{
  
    header("Location: ./Connexion.php?pseudo=erreur");
    die();
    //quitter
}    

if (isset($_POST["motdepasse"])){
    $motdepasse=$_POST["motdepasse"];
}else{
   
    header("Location: ./Connexion.php?motdepasse=erreur");
    die();
    //quitter
}    

$bdd = new PDO (
    "mysql:host=localhost;dbname=netflix;charset=utf8",
    "root",
    ""
);


$sql = "SELECT * FROM Utilisateur
    WHERE pseudo=:pseudo
    AND motdepasse=:motdepasse";

$requete=$bdd->prepare($sql);
$requete->bindParam ("pseudo",$pseudo,PDO :: PARAM_STR);
$requete->bindParam ("motdepasse",$motdepasse,PDO :: PARAM_STR);
$requete->execute();
$resultat=$requete->fetchAll();


//Si la requete n'est pas vide (ie : si j'arrive à me connecter)
if(!empty($resultat)){
    session_start();
    $_SESSION["pseudo"]=$pseudo;
    //Si je suis admin
    if($resultat[0]["admin"] == 1){
        $_SESSION["admin"]=1;
        header("Location: ./AdminPanel.php");
        die();
    }
    header("Location: ./Accueil.php");
    die();
    //si j'echoue à me connecter
}else{
    header("Location: ./Connexion.php");
    die();
}
    
?>