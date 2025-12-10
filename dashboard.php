<?php
require 'session.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>
<body>
    <h2>Bienvenue, <?php echo $_SESSION['username']; ?> !</h2>

    <a href="ajouter_objet.php">➕ Ajouter un objet perdu</a><br><br>
    <a href="lister_objets.php">📋 Voir les objets perdus</a><br><br>
    <a href="logout.php" style="color:red;">🚪 Déconnexion</a>
</body>
</html>
