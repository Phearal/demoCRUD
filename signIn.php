<?php
// permet d'utilisaer une session ($_SESSION)
session_start();
try {
    $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto_evenements","toto");
} catch(Exception $e) {
    echo "Connexion à la BDD impossible !";
}
$stmt = $cnx->prepare("SELECT * FROM utilisateur WHERE email= :email");
$email = htmlspecialchars($_POST["email"]);
$stmt->bindParam(":email", $email);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC); // fetch renvoie false si l'email n'est pas dans la BDD
var_dump($utilisateur);
// Vérifier s'il existe un utilisateur avec cet email dans la BDD
if($utilisateur){
    var_dump($utilisateur);
    // Vérifier le mot de passe
    $mdp=$_POST['mdp'];
    if(password_verify($mdp, $utilisateur['mdp'])){
        // Mettre l'utilisateur en session
        $_SESSION['id_utilisateur'] = $utilisateur["id_utilisateur"];
        $_SESSION['nom'] = $utilisateur["nom"];
        $_SESSION['prenom'] = $utilisateur["prenom"];
        $_SESSION['role'] = $utilisateur["role"];
        var_dump($_SESSION);
        header('location:index.php');
    } else {
        header('location:connexion.php');
    }
} else {
    header('location:connexion.php');
}