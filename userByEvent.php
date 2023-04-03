<?php session_start();
require_once './config/config.php';

$cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306", "toto_evenements", "toto");
$stmtGetEvent = $cnx->prepare("SELECT * FROM utilisateur_evenement WHERE id_evenement = :id_evenement");
$stmtGetEvent->bindParam(":id_evenement", $_GET["idEvent"]);
$stmtGetEvent->execute();
$usersInEvent = $stmtGetEvent->fetchAll(PDO::FETCH_ASSOC);

// var_dump($usersInEvent);
if (!empty($usersInEvent)){
    echo('
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>'
    );
    foreach($usersInEvent as $user){
        $stmtUser = $cnx->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
        $stmtUser->bindParam(":id_utilisateur", $user['id_utilisateur']);
        $stmtUser->execute();
        $user = $stmtUser->fetchAll(PDO::FETCH_ASSOC);
        ?>
            <tr>
                <th scope="row"><?= $user[0]['id_utilisateur'] ?></th>
                <td><?= $user[0]['prenom'] . " " . $user[0]['nom'] ?></td>
                <td><?= $user[0]['email'] ?></td>
            </tr>
        <?php
    }
    echo('
        </tbody>
        </table>'
    );
} else {
    echo "<p class='m-2'>Personne n'est inscrit à cet évènement.</p>";
}

                    