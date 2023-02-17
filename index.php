<?php session_start(); ?>

<?php if(isset($_SESSION["id_utilisateur"])): ?>
    <div>
        Bonjour <?= $_SESSION['prenom']; ?>
        <br><a href="./deconnexion.php">Déconnexion</a>
    </div>
<?php else: ?>
    <div>
        <a href="./connexion.php">Connexion</a>
    </div>
<?php endif ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script defer src="./js/main.js"></script>
    <title>Document</title>
</head>
<body>
    <h1>Gestion des évènements</h1>
    <nav>
        <ul>
            <li><a href="./index.php">Accueil</a></li>
            <li><a href="./inscription.php">Inscription</a></li>
        </ul>
    </nav>
    <hr>
    <main>
        <section>
            <h2>Liste des évènements</h2>
            <?php
                $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto_evenements","toto");
                // var_dump($cnx);
                $stmt = $cnx->prepare("SELECT * FROM evenement");
                $stmt->execute();
                $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($evenements as $evenement):
            ?>
                <h3><?= $evenement['nom'] ?></h3>
                <p><?= $evenement['description'] ?></p>
                <p>Date : <?= $evenement['date'] ?></p>
                <p>Nombre de places : <?= $evenement['nb_places'] ?></p>
                <img src="<?= $evenement['img_cover'] ?>" alt="">
                <a href="detailsEvenement.php?id=<?= $evenement["id_evenement"] ?>">Voir en détail</a>
            <?php endforeach ?>
        </section>
    </main>
</body>
</html>