<?php

var_dump($_POST);
$test = $_POST;
var_dump($test['email']);


// Vérifier les données de $_POST
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['mdp'])){
    //// On vérifie que tous les champs ne soient pas vides
    if($_POST['nom'] != '' && $_POST['prenom'] != '' && $_POST['email'] != '' && $_POST['mdp'] != ''){
        //// Protection des champs du formulaire contre l'injection de Javascript
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        //// Encoder le mot de passe
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $role = "utilisateur";
    }
}


// Enregistrer les données dans la BDD
try {
    $cnx = new PDO("mysql:host=localhost;dbname=gestion_evenements;charset=utf8;port=3306","toto_evenements","toto");
} catch(Exception $e) {
    echo "Connexion à la BDD impossible !";
}
//// Faire la requête SQL
$stmt = $cnx->prepare("INSERT INTO utilisateur(id_utilisateur, nom, prenom, email, mdp, role) VALUES (NULL, :nom, :prenom, :email, :mdp, :role)");
$stmt->bindParam(":nom", $nom);
$stmt->bindParam(":prenom", $prenom);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":mdp", $mdp);
$stmt->bindParam(":role", $role);
$stmt->execute();
//// Vérifier qu'il n'y a pas déjà un utilisateur avec cet email