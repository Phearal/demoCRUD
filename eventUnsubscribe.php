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

$newNbPlace = $thisEvent['nb_places']+1;
$stmtUpdatePlace = $cnx->prepare("UPDATE evenement SET nb_places = :nb_places WHERE id_evenement = :id_evenement");
$stmtUpdatePlace->bindParam(":nb_places", $newNbPlace);
$stmtUpdatePlace->bindParam(":id_evenement", $idEvent);
$stmtUpdatePlace->execute();

$stmtDelete = $cnx->prepare("DELETE FROM utilisateur_evenement WHERE id_evenement = :id_evenement AND id_utilisateur = :id_utilisateur");
$stmtDelete->bindParam(":id_utilisateur", $idUser);
$stmtDelete->bindParam(":id_evenement", $idEvent);
$stmtDelete->execute();




header('location:detailsEvenement.php?id=' . $idEvent);