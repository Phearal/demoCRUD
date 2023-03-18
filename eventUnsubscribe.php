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
$stmt = $cnx->prepare("DELETE FROM utilisateur_evenement WHERE id_evenement = :id_evenement AND id_utilisateur = :id_utilisateur");
$stmt->bindParam(":id_utilisateur", $idUser);
$stmt->bindParam(":id_evenement", $idEvent);
$stmt->execute();

header('location:index.php');