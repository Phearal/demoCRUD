<?php
session_start();

    $id = $_GET["id"];
    try {
        $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto","toto");
    } catch(Exception $e) {
        echo "Connexion à la BDD impossible !";
    }
    $stmt = $cnx->prepare("DELETE FROM `lieu` WHERE id_lieu= :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

header('location:admin.php');