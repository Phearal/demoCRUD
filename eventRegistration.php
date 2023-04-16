<?php
session_start();
require_once './config/config.php';

if(isset($_SESSION["id_utilisateur"]) && isset($_GET['idEvent']) && $_SESSION["id_utilisateur"] != "" && $_GET['idEvent'] != ""){
    $idUser = htmlspecialchars($_SESSION["id_utilisateur"]);
    $idEvent = htmlspecialchars($_GET['idEvent']);
} else {
    header('location:index.php');
}

$cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto_evenements", "toto");

$stmtCheckPlace = $cnx->prepare("SELECT * FROM `evenement` WHERE id_evenement = :id_evenement");
$stmtCheckPlace->bindParam(":id_evenement", $idEvent);
$stmtCheckPlace->execute();
$thisEvent = $stmtCheckPlace->fetch(PDO::FETCH_ASSOC);

if($thisEvent && $thisEvent['nb_places'] > 0){
    $newNbPlace = $thisEvent['nb_places']-1;
    $stmtUpdatePlace = $cnx->prepare("UPDATE evenement SET nb_places = :nb_places WHERE id_evenement = :id_evenement");
    $stmtUpdatePlace->bindParam(":nb_places", $newNbPlace);
    $stmtUpdatePlace->bindParam(":id_evenement", $idEvent);
    $stmtUpdatePlace->execute();

    $stmtInsert = $cnx->prepare("INSERT INTO utilisateur_evenement(id_utilisateur, id_evenement) VALUES (:id_utilisateur, :id_evenement)");
    $stmtInsert->bindParam(":id_utilisateur", $idUser);
    $stmtInsert->bindParam(":id_evenement", $idEvent);
    $stmtInsert->execute();
} else {
    $_SESSION['eventPlein'] = "Plus de places disponibles !";
}



header('location:detailsEvenement.php?id=' . $idEvent);