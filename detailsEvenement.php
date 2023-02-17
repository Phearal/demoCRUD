<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- TODO : Intégrer la navbar -->
    <?php
        // On récupère le paramètre d'URL id
        $id = $_GET["id"];
        var_dump($id);
        // Connexion à la BDD
        try {
            $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto_evenements","toto");
        } catch(Exception $e) {
            echo "Connexion à la BDD impossible !";
        }
        // Requête préparée avec un paramètre
        // !!! Ne pas mettre $id dans la requête SQL !!!
        $stmt = $cnx->prepare("SELECT * FROM evenements_utilisateurs_lieux WHERE id_evenement= :id");
        // On indique les paramètres
        $stmt->bindParam(":id", $id);
        // Exécution de la requête
        $stmt->execute();
        // On utilise fetch et pas fetchAll car on s'attend à récupérer un seul enregistrement
        $evenement = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($evenement)) :
        ?>
        <h2><?= $evenement["nom"] ?></h2>
        <p><?= $evenement["description"] ?></p>
        <p>Lieu : <?= $evenement['lieux'] ?></p>
        <p>Date : <?= $evenement['date'] ?></p>
        <p>Nombre de places : <?= $evenement['nb_places'] ?></p>
        <img src="<?= $evenement['img_cover'] ?>" alt="">
        <p>Organisateur : <?= $evenement['organisateur'] ?></p>
        <?php else : ?>
            <p>L'évènement <?= $id ?> n'existe pas.</p>
        <?php endif ?>
</body>
</html>