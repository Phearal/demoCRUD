<?php
    session_start();
    require_once './config/config.php';
    if(!(isset($_SESSION["id_utilisateur"]) && $_SESSION['role'] == 'administrateur')){
        header('location:connexion.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS ?>">
    <!-- <link rel="stylesheet" href="<?= CSS ?>style.css">
    <link rel="stylesheet" href="<?= CSS ?>accueil.css"> -->
    <script defer src="<?= BOOTSTRAP_JS ?>"></script>
    <!-- <script defer src="<?= JS ?>main.js"></script> -->
    <title><?= TITLE ?>Admin</title>
</head>
<body>
    <?php require_once TEMPLATE_PARTS . '_header.php';?>
    <h1>Page admin</h1>
    <div class="container">
        
    </div>
</body>
</html>