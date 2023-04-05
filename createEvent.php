<?php
$formError = null;
try {
    $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto", "toto");
} catch (Exception $e) {
    echo "Connexion à la BDD impossible !";
}
if (isset($_POST["submit"])) {
    if ($_FILES["img_cover"]["size"] > 0) {
        $types = ["image/jpeg", "image/png"];
        $mimeFichier = mime_content_type($_FILES["img_cover"]["tmp_name"]);
        if (!in_array($mimeFichier, $types)) {
            $formError[] = "Type de fichier non autorisé";
        }
        $maxSize = 5 * 1024 * 1024;
        if ($_FILES["img_cover"]["size"] > $maxSize) {
            $formError[] = "La taille du fichier est trop grande";
        }
        if ($formError === null) {
            $fileName = uniqid() . $_FILES["img_cover"]["name"];
            move_uploaded_file($_FILES["img_cover"]["tmp_name"], "assets/img/uploads/" . $fileName);
        }
    } else {
        $formError[] = "Le fichier ne peut pas être vide";
    }

    if (isset($_POST['nom']) && isset($_POST['nb_places']) && isset($_POST['date']) && isset($_POST['lieu']) && isset($_POST['description'])) {
        if ($_POST['nom'] != '' && $_POST['nb_places'] != '' && $_POST['date'] != '' && $_POST['lieu'] != '' && $_POST['description'] != '') {
            $nom = htmlspecialchars($_POST['nom']);
            $nb_places = htmlspecialchars($_POST['nb_places']);
            $date = htmlspecialchars($_POST['date']);
            $lieu = htmlspecialchars($_POST['lieu']);
            $description = htmlspecialchars($_POST['description']);
        }
    }

    $stmtLieuExistant = $cnx->prepare("SELECT * FROM lieu WHERE nom= :nom");
    $stmtLieuExistant->bindParam(':nom', $lieu);
    $stmtLieuExistant->execute();
    $lieuExistant = $stmtLieuExistant->fetch(PDO::FETCH_ASSOC);

    if (!$lieuExistant) {
        $_SESSION['erreurlieuAbsent'] = "Ce lieu n'existe pas dans la base de données";
        // header('location:creerEvenement.php');
    }
    $id_lieu = $lieuExistant['id_lieu'];

    $filePath = "assets/img/uploads/" . $fileName;

    $stmtEvent = $cnx->prepare("INSERT INTO evenement(id_evenement, nom, nb_places, date, description, img_cover, id_lieu, id_organisateur) VALUES (NULL, :nom, :nb_places, :date, :description, :img_cover, :id_lieu, :id_organisateur)");
    $stmtEvent->bindParam(":nom", $nom);
    $stmtEvent->bindParam(":nb_places", $nb_places);
    $stmtEvent->bindParam(":date", $date);
    $stmtEvent->bindParam(":description", $description);
    $stmtEvent->bindParam(":img_cover", $filePath);
    $stmtEvent->bindParam(":id_lieu", $id_lieu);
    $stmtEvent->bindParam(":id_organisateur", $_SESSION['id_utilisateur']);
    $stmtEvent->execute();
}


// header('location:admin.php');