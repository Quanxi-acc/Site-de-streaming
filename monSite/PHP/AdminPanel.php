<?php
    session_start();
    if(!isset($_SESSION["admin"]) || $_SESSION["admin"]!=1){ /* Si NON Admin -> Acceuil */
        header("Location: ./Accueil.php");
        die();
    }


function ajouterFilm($nom, $annee, $acteur, $realisateur, $genre, $type){
    $sql = "INSERT INTO film(nom, annee, fkGenre, fkType) VALUES (:nom, :annee, :fkGenre, :fkType);";
    $requete = $bd->prepare($sql);
    $requete->bindParam("nom", $nom, PDO::PARAM_STR);
    $requete->bindParam("annee", $annee, PDO::PARAM_INT);
    $requete->bindParam("fkGenre", $genre, PDO::PARAM_INT);
    $requete->bindParam("fkType", $type, PDO::PARAM_INT);
    $res = $requete->execute();

    if($res){

        /* Récupérer le film inséré (id) */
        $film = $_POST['idFilm'];
        $nbActeur = count($acteur);
        /*
         Boucle sur les acteurs
         $acteur est un tableau 
         $acteur <- [17, 45, 21, 34]
         Les acteurs d'id 17, 45, 21 et 34 jouent dans le film
         On doit tous les ajouter 
         */
        for($i=0;$i<$nbActeur;$i++){
            $sql = "INSERT INTO jouer(fkFilm, fkActeur) VALUES (:film, :acteur);";
            $requete = $bd->prepare($sql);
            $requete->bindParam("film", $film, PDO::PARAM_INT);
            $requete->bindParam("acteur", $acteur[$i], PDO::PARAM_INT);
            $resActeur = $requete->execute();
        }
        /*
        Idem réalisateur
        */
        $nbRealisateur = count($realisateur);

        for($i=0;$i<$nbRealisateur;$i++){
            $sql = "INSERT INTO realiser(fkFilm, fkRea) VALUES (:film, :realisateur);";
            $requete = $bd->prepare($sql);
            $requete->bindParam("film", $film, PDO::PARAM_INT);
            $requete->bindParam("realisateur", $realisateur[$i], PDO::PARAM_INT);
            $resReal = $requete->execute();
        }

        if($resActeur && $resReal){
            //Insertion Réussie
        }else{
            //Insertion Echouée
        }

    }else{
        //insertion Echouée
    }
}

try{
    $bd = new PDO("mysql:host=localhost;dbname=netflix", "root", "");
}catch(Exception $e){
    die($e->getMessage());
}

/* Afficher dans le select les genres */ 
try{
    $sql = "SELECT * FROM genre;";
    $requete = $bd->prepare($sql);
    $requete->execute();
    $donnees = $requete->fetchAll();
}catch(Exception $e){
    die($e->getMessage());
}

$htmlGenre = "";
foreach($donnees as $valeur){
    $htmlGenre.="<option value='";
    $htmlGenre.=$valeur["idGenre"];
    $htmlGenre.="'>";
    $htmlGenre.=$valeur["genre"];
    $htmlGenre.="</option>";
}


/* Afficher dans le select les types */ 

try{
    $sql = "SELECT * FROM type;";
    $requete = $bd->prepare($sql);
    $requete->execute();
    $donnees = $requete->fetchAll();
}catch(Exception $e){
    die($e->getMessage());
}

$htmlType = "";
foreach($donnees as $valeur){
    $htmlType.="<option value='";
    $htmlType.=$valeur["idType"];
    $htmlType.="'>";
    $htmlType.=$valeur["type"];
    $htmlType.="</option>";
}

/* Afficher dans le select un Réalisateur */ 

try{
    $sql = "SELECT * FROM realisateur;";
    $requete = $bd->prepare($sql);
    $requete->execute();
    $donnees = $requete->fetchAll();

}catch(Exception $e){
    die($e->getMessage());
}

$htmlRealisateur = "";
foreach($donnees as $valeur){
    $htmlRealisateur.="<option value='";
    $htmlRealisateur.=$valeur["idRea"];
    $htmlRealisateur.="'>";
    $htmlRealisateur.=$valeur["nom"];
    $htmlRealisateur.=$valeur["prenom"];
    $htmlRealisateur.="</option>";
}



/* Afficher dans le select un Acteur */ 

try{
    $sql = "SELECT * FROM acteur;";
    $requete = $bd->prepare($sql);
    $requete->execute();
    $donnees = $requete->fetchAll();

}catch(Exception $e){
    die($e->getMessage());
}

$htmlActeur = "";
foreach($donnees as $valeur){
    $htmlActeur.="<option value='";
    $htmlActeur.=$valeur["idActeur"];
    $htmlActeur.="'>";
    $htmlActeur.=$valeur["nom"];
    $htmlActeur.=$valeur["prenom"];
    $htmlActeur.="</option>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap" rel="stylesheet">

    <h1>Admin Panel</h1> 

    <form id="uploadBanner" enctype="multipart/form-data" action=TraitementAdminPanel.php method="POST">
        <div class="section">
            <h2>Ajouter un Film</h2>
            <label for="nomFilm">Nom du Film :</label>
            <input type="text" id="nomFilm" name="nomFilm">

            <label for="anneeSortie">Année de sortie :</label>
            <input type="text" id="anneeSortie" name="anneeSortie">

            
            <h2>Ajouter un Acteur</h2>
            <select id="acteur" name="acteur[]">
            <?php echo $htmlActeur
             ?>
            </select>

            <input  type="button" value="Modifier">

            <h2>Ajouter un Réalisateur</h2>
            <select id="realisateur" name="realisateur[]">
                    <?php echo $htmlRealisateur; ?>
            </select>
            <input  type="button" value="Modifier">

            <h2>Ajouter un Genre</h2>
            <select id="genre" name="genre">
                    <?php echo $htmlGenre; ?>
            </select>
            <input  type="button" value="Modifier">

            <h2>Ajouter un Type</h2>
            <select id="type" name="type">
                <?php echo $htmlType; ?>
            </select>
            <input  type="button" value="Modifier">

            <br>
            </select>

            <br>

            <button name="buttonFilm" type="submit">Enregistrer dans la Base de Données </button>
            <br>
        </div>
    </form>

    <form action=TraitementAdminPanel.php method="POST">
        <div class="section">
            <h2>Ajouter un Acteur</h2>
            <label for="auteurNom">Nom de l'Acteur :</label>
            <input type="text" id="auteurNom" name="auteurNom">

            <label for="auteurPrenom">Prénom de l'Acteur :</label>
            <input type="text" id="auteurPrenom" name="auteurPrenom">

            <label for="dateNaissanceActeur">Date de naissance de l'Acteur :</label>
            <input type="date" id="dateNaissanceActeur" name="dateNaissance">

            <button name="buttonActeur" type="submit">Enregistrer dans la Base de Données</button>
        </div>
    </form>

    <form action="TraitementAdminPanel.php" method="POST">
    <div class="section">
        <h2>Ajouter un Réalisateur</h2>
        <label for="realisateurNom">Nom du Réalisateur :</label>
        <input type="text" id="realisateurNom" name="realisateurNom">

        <label for="realisateurPrenom">Prénom du Réalisateur :</label>
        <input type="text" id="realisateurPrenom" name="realisateurPrenom">

        <label for="dateNaissanceRealisateur">Date de naissance du Réalisateur :</label>
        <input type="date" id="dateNaissanceRealisateur" name="dateNaissanceRealisateur">
        
        <button name="buttonRealisateur" type="submit">Enregistrer dans la Base de Données</button>
    </div>
</form>



<form action="TraitementAdminPanel.php" method="POST">
    <div class="section">
        <h2>Ajouter un Genre</h2>
        <label for="genre">Genre :</label>
        <input type="text" id="genre" name="genre">
        <button name="buttonGenre" type="submit">Enregistrer dans la Base de Données</button>
    </div>
</form>


    <form action=TraitementAdminPanel.php method="POST">
        <div class="section">

            <h2>Ajouter un Type</h2>
            <label for="type">Type :</label>
            <input type="text" id="type" name="type">

            <button name="buttonType" type="submit">Enregistrer dans la Base de Données</button>
        </div>
    </form>


<link href="../CSS/AdminPanel.css" rel="stylesheet" />

<script src="../JS/Sky.js"></script>
<script src="../JS/Modifier.js"></script>
</body>
</html>
