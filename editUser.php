<?php session_start();
require_once './config/config.php';

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['roleSelect'])){
    if($_POST['nom'] != '' && $_POST['prenom'] != '' && $_POST['email'] != '' && $_POST['mdp'] != '' && $_POST['roleSelect'] != ''){
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $role = htmlspecialchars($_POST['roleSelect']);
    }
}

try {
    $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto","toto");
} catch(Exception $e) {
    echo "Connexion à la BDD impossible !";
}
$stmtCheck = $cnx->prepare("SELECT * FROM utilisateur WHERE id_utilisateur= :id_utilisateur");
$stmtCheck->bindParam(':id_utilisateur', $_GET['id']);
$stmtCheck->execute();
$user = $stmtCheck->fetch(PDO::FETCH_ASSOC);
if(!$user){
    $_SESSION['erreurUserAbsent'] = "Cet utilisateur n'existe pas dans la base de données";
    header('location:admin.php');
}
if ($_POST['mdp'] != $user['mdp']){
    $mdp = htmlspecialchars($_POST['mdp']);
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);
} else {
    $mdp = $_POST['mdp'];
}

$stmtUpdateUser = $cnx->prepare("UPDATE utilisateur SET nom=:nom, prenom=:prenom, email=:email, role=:role, mdp=:mdp WHERE id_utilisateur=:id_utilisateur");
$stmtUpdateUser->bindParam(":nom", $nom);
$stmtUpdateUser->bindParam(":prenom", $prenom);
$stmtUpdateUser->bindParam(":email", $email);
$stmtUpdateUser->bindParam(":role", $role);
$stmtUpdateUser->bindParam(":mdp", $mdp);
$stmtUpdateUser->bindParam(':id_utilisateur', $_GET['id']);
$stmtUpdateUser->execute();

header('location:admin.php');