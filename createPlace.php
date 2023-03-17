<?php session_start();
require_once './config/config.php';

if(isset($_POST['nom']) && isset($_POST['adresse']) && isset($_POST['ville']) && isset($_POST['CP']) && $_POST['nom'] != '' && $_POST['adresse'] != '' && $_POST['ville'] != '' && $_POST['CP'] != ''){
    if($_POST['nom'] != '' && $_POST['adresse'] != '' && $_POST['ville'] != '' && $_POST['CP'] != ''){
        $nom = htmlspecialchars($_POST['nom']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $ville = htmlspecialchars($_POST['ville']);
        $CP = htmlspecialchars($_POST['CP']);
    }
}



try {
    $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto","toto");
} catch(Exception $e) {
    echo "Connexion à la BDD impossible !";
}
$stmtlieu = $cnx->prepare("SELECT * FROM lieu WHERE nom= :nom");
$stmtlieu->bindParam(':nom', $nom);
$stmtlieu->execute();
$lieuExistant = $stmtlieu->fetch(PDO::FETCH_ASSOC);
if($lieuExistant){
    $_SESSION['erreurLieuExistant'] = "Un lieu porte déjà ce nom dans la base de données !";
    header('location:creerLieu.php');
}

$stmt = $cnx->prepare("INSERT INTO lieu(id_lieu, nom, adresse, ville, CP) VALUES (NULL, :nom, :adresse, :ville, :CP)");
$stmt->bindParam(":nom", $nom);
$stmt->bindParam(":adresse", $adresse);
$stmt->bindParam(":ville", $ville);
$stmt->bindParam(":CP", $CP);
$stmt->execute();


header('location:admin.php');