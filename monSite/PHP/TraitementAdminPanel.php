<?php 
    session_start();
    if($_SESSION["admin"]!=1){ /* Si NON Admin -> Salut mon pote */
        header("Location: Accueil.php");
        die();
    }
    
    try{    /* Connexion à la BD */
        $bd=new PDO ("mysql:host=localhost;dbname=netflix", "root", "");
    }catch (Exception $e){
        die($e->getMessage());
    }

    if (isset($_POST["buttonFilm"])) {
        if (isset($_POST["nomFilm"]) && isset($_POST["anneeSortie"]) && isset($_POST["genre"]) && isset($_POST["type"])) {
        
        $nomFilm = $_POST["nomFilm"];
        $anneeSortie = $_POST["anneeSortie"];
        $genre = $_POST["genre"];
        $type = $_POST["type"];
        $acteurs = isset($_POST["acteur"]) ? $_POST["acteur"] : [];
        $realisateurs = isset($_POST["realisateur"]) ? $_POST["realisateur"] : [];

         // Insérer le film
            $sql = "INSERT INTO film (nom, annee, fkGenre, fkType) VALUES (:nom, :annee, :fkGenre, :fkType)";
            $requete = $bd->prepare($sql);
            $requete->bindParam(":nom", $nomFilm, PDO::PARAM_STR);
            $requete->bindParam(":annee", $anneeSortie, PDO::PARAM_INT);
            $requete->bindParam(":fkGenre", $genre, PDO::PARAM_INT);
            $requete->bindParam(":fkType", $type, PDO::PARAM_INT);
            $res  = $requete->execute();

            // Récupérer l'ID du film inséré
            $filmID = $bd->lastInsertId();

            // Associer les acteurs au film
            foreach ($acteurs as $acteur) {
                $sql = "INSERT INTO jouer (fkFilm, fkActeur) VALUES (:film, :acteur)";
                $requete = $bd->prepare($sql);
                $requete->bindParam(":film", $filmID, PDO::PARAM_INT);
                $requete->bindParam(":acteur", $acteur, PDO::PARAM_INT);
                $requete->execute();
            }

            // Associer les réalisateurs au film
            foreach ($realisateurs as $realisateur) {
                $sql = "INSERT INTO realiser (fkFilm, fkRea) VALUES (:film, :realisateur)";
                $requete = $bd->prepare($sql);
                $requete->bindParam(":film", $filmID, PDO::PARAM_INT);
                $requete->bindParam(":realisateur", $realisateur, PDO::PARAM_INT);
                $requete->execute();
            }

            if ($res) {
                echo "Film ajouté avec succès !";
            } else {
                echo "Échec de l'ajout du Film.";
            }
        }
    }



    if(isset($_POST["buttonActeur"])){
        /*Insertion d'un Acteur dans la bd */
        if(isset($_POST["auteurNom"])    &&
           isset($_POST["auteurPrenom"]) &&
           isset($_POST["dateNaissance"])){

            $nom=$_POST["auteurNom"];
            $prenom=$_POST["auteurPrenom"];
            $dateNaissance=$_POST["dateNaissance"];

            $sql = "INSERT INTO acteur (nom, prenom, dateN) VALUES (:nom, :prenom, :dateNaissance)";
            $requete = $bd->prepare($sql);
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':dateNaissance', $dateNaissance);
            $res = $requete->execute();
        }

        if ($res) {
            echo "Acteur ajouté avec succès !";
        } else {
            echo "Échec de l'ajout de l'acteur.";
    }
    }

        if(isset($_POST["buttonRealisateur"])){
            /*Insertion d'un Réalisateur dans la bd */
            if(isset($_POST["realisateurNom"])    &&
               isset($_POST["realisateurPrenom"]) &&
               isset($_POST["dateNaissanceRealisateur"])){
    
                /*Récupère les donnees dans la bd */
                $nom=$_POST["realisateurNom"];
                $prenom=$_POST["realisateurPrenom"];
                $dateNaissance=$_POST["dateNaissanceRealisateur"];
    
                $sql = "INSERT INTO realisateur (nom, prenom, dateN) VALUES (:nom, :prenom, :dateNaissance)";
                $requete = $bd->prepare($sql);
                $requete->bindParam(':nom', $nom);
                $requete->bindParam(':prenom', $prenom);
                $requete->bindParam(':dateNaissance', $dateNaissance);
                $res = $requete->execute();
    if ($res) {
        echo "Réalisateur ajouté avec succès !";
    } else {
         echo "Échec de l'ajout de l'acteur.";
}
}
}

if(isset($_POST["buttonGenre"])){
    /*Insertion d'un genre dans la BD */
    if(isset($_POST["genre"])){
        
        /*Récupère le genre dans la bd */
        $genre = $_POST["genre"];

        $sql = "INSERT INTO genre (genre) VALUES (:genre)";
        $requete = $bd->prepare($sql);
        $requete->bindParam(":genre", $genre);
        $res = $requete->execute();

        if ($res) {
            echo "Genre ajouté avec succès !";
        } else {
            echo "Échec de l'ajout du genre.";
        }
}
}

if(isset($_POST["buttonType"])){
    /*Insertion d'un type dans la BD */
    if(isset($_POST["type"])){
        
        /*Récupère le genre dans la bd */
        $genre = $_POST["type"];

        $sql = "INSERT INTO type (type) VALUES (:type)";
        $requete = $bd->prepare($sql);
        $requete->bindParam(":type", $genre);
        $res = $requete->execute();

        if ($res) {
            echo "Type ajouté avec succès !";
        } else {
            echo "Échec de l'ajout du type.";
        }
}
}
?>