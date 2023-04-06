<?php
// Connexion à la base de données
$cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto","toto");

// Récupération des données
$order = $_GET['ao'];
switch ($order) {
    case 1:
        $stmt = $cnx->query("SELECT * FROM `evenement` ORDER BY nom ASC");
        break;
    case 2:
        $stmt = $cnx->query("SELECT * FROM `evenement` ORDER BY nom DESC");
        break;
}
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Conversion en JSON
$json = json_encode($data);

// Envoi de la réponse
header('Content-Type: application/json');
echo $json;