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
if(!$lieuExistant){
    $_SESSION['erreurlieuAbsent'] = "Ce lieu n'existe pas dans la base de données";
    header('location:creerEvenement.php');
}
$id_lieu = $lieuExistant['id_lieu'];

if($img_cover != ''){
    $stmt = $cnx->prepare("UPDATE evenement SET nom=:nom, nb_places=:nb_places, date=:date, description=:description, img_cover=:img_cover, id_lieu=:id_lieu WHERE id_evenement=:id_evenement");
    $stmt->bindParam(":img_cover", $img_cover);
} else {
    $stmt = $cnx->prepare("UPDATE evenement SET nom=:nom, nb_places=:nb_places, date=:date, description=:description, id_lieu=:id_lieu WHERE id_evenement=:id_evenement");
}
$stmt->bindParam(":nom", $nom);
$stmt->bindParam(":nb_places", $nb_places);
$stmt->bindParam(":date", $date);
$stmt->bindParam(":description", $description);
$stmt->bindParam(":id_lieu", $id_lieu);
$stmt->bindParam(":id_evenement", $_GET['id']);
$stmt->execute();

header('location:admin.php');