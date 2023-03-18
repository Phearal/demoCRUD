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
$stmt = $cnx->prepare("INSERT INTO utilisateur_evenement(id_utilisateur, id_evenement) VALUES (:id_utilisateur, :id_evenement)");
$stmt->bindParam(":id_utilisateur", $idUser);
$stmt->bindParam(":id_evenement", $idEvent);
$stmt->execute();

header('location:index.php');