<?php
if (isset($_POST["prenom"])){
    $prenom=$_POST["prenom"];
}else{ 
    header("location: ./Inscription.php?prenom=erreur");
    die(); 
}   

if (isset($_POST["nom"])){
    $nom=$_POST["nom"];
}else{
    header("location: ./Inscription.php?nom=erreur");
    die();
}   

if (isset($_POST["email"])){
    $email=$_POST["email"];
}else{
    header("location: ./Inscription.php?email=erreur");
    die();
}   

if (isset($_POST["pseudo"])){
    $pseudo=$_POST["pseudo"];
}else{
    header("location: ./Inscription.php?pseudo=erreur");
    die();
}   

if (isset($_POST["motdepasse"])){
    $motdepasse=$_POST["motdepasse"];
}else{
    header("location: ./Inscription.php?motdepasse=erreur");
    die();
}   

if (isset($_POST["datenaissance"])){
    $datenaissance=$_POST["datenaissance"];
}else{
    header("location: ./Inscription.php?datenaissance=erreur");
    die();
}   

if (isset($_POST["genre"])){
    $genre=$_POST["genre"];
}else{
    header("location: ./Inscription.php?genre=erreur");
    die();
}   

$bdd=new PDO(
    "mysql:host=localhost;dbname=netflix;charset=utf8",
    "root",
    ""
);

$sql = "INSERT INTO Utilisateur (pseudo, motdepasse, prenom, nom, email, datenaissance, genre) 
            VALUES (:pseudo, :motdepasse, :prenom, :nom, :email, :datenaissance, :genre)";

    $requete = $bdd->prepare($sql);
    $requete->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $requete->bindParam(":motdepasse", $motdepasse, PDO::PARAM_STR);
    $requete->bindParam(":prenom", $prenom, PDO::PARAM_STR);
    $requete->bindParam(":nom", $nom, PDO::PARAM_STR);
    $requete->bindParam(":email", $email, PDO::PARAM_STR);
    $requete->bindParam(":datenaissance", $datenaissance, PDO::PARAM_STR);
    $requete->bindParam(":genre", $genre, PDO::PARAM_STR);

    $res=$requete->execute();

$_SESSION["pseudo"]=$pseudo;
$_SESSION["motdepasse"]=$motdepasse;
$_SESSION["prenom"]=$prenom;
$_SESSION["nom"]=$nom;
$_SESSION["email"]=$email;
$_SESSION["datenaissance"]=$datenaissance;
$_SESSION["genre"]=$genre;

if($res){
header("Location: ./Accueil.php");
die();
}

?>





