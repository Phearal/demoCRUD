<?php session_start();
require_once './config/config.php';

if(isset($_POST['nom']) && isset($_POST['nb_places']) && isset($_POST['date']) && isset($_POST['lieu']) && isset($_POST['description']) && isset($_POST['img_cover'])){
    if($_POST['nom'] != '' && $_POST['nb_places'] != '' && $_POST['date'] != '' && $_POST['lieu'] != '' && $_POST['description'] != ''){
        $nom = htmlspecialchars($_POST['nom']);
        $nb_places = htmlspecialchars($_POST['nb_places']);
        $date = htmlspecialchars($_POST['date']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $description = htmlspecialchars($_POST['description']);
        $img_cover = $_POST['img_cover'];
        echo 'ALL FIELDS SET';
    }
}



try {
    $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto","toto");
} catch(Exception $e) {
    echo "Connexion à la BDD impossible !";
}
$stmtlieu = $cnx->prepare("SELECT * FROM lieu WHERE nom= :nom");
$stmtlieu->bindParam(':nom', $lieu);
$stmtlieu->execute();
$lieuExistant = $stmtlieu->fetch(PDO::FETCH_ASSOC);
var_dump($lieuExistant);
if(!$lieuExistant){
    $_SESSION['erreurlieuAbsent'] = "Ce lieu n'existe pas dans la base de données";
    header('location:creerEvenement.php');
}
$id_lieu = $lieuExistant['id_lieu'];

$stmt = $cnx->prepare("INSERT INTO evenement(id_evenement, nom, nb_places, date, description, img_cover, id_lieu, id_organisateur) VALUES (NULL, :nom, :nb_places, :date, :description, :img_cover, :id_lieu, :id_organisateur)");
$stmt->bindParam(":nom", $nom);
$stmt->bindParam(":nb_places", $nb_places);
$stmt->bindParam(":date", $date);
$stmt->bindParam(":description", $description);
$stmt->bindParam(":img_cover", $img_cover);
$stmt->bindParam(":id_lieu", $id_lieu);
$stmt->bindParam(":id_organisateur", $_SESSION['id_utilisateur']);
$stmt->execute();


// header('location:admin.php');