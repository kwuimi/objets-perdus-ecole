<?php
// Inclusion des fichiers nécessaires pour la session et la configuration de la base de données
require 'session.php';
require 'config.php';

// Exécution de la requête SQL pour récupérer tous les objets triés par date de découverte décroissante
$results = mysqli_query($conn, "SELECT * FROM objets ORDER BY date_trouve DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des objets perdus</title>
</head>
<body>

<h2>Liste des objets perdus</h2>

<!-- Tableau pour afficher la liste des objets -->
<table border="1" cellpadding="5">
    <tr>
        <!-- En-têtes du tableau -->
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Lieu trouvé</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <!-- Boucle PHP pour afficher chaque objet récupéré de la base de données -->
    <?php while ($row = mysqli_fetch_assoc($results)) { ?>
        <tr>
            <!-- Affichage des données de l'objet dans chaque cellule du tableau -->
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['lieu_trouve']) ?></td>
            <td><?= $row['date_trouve'] ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
                <!-- Liens pour modifier et supprimer l'objet avec transmission de l'ID en paramètre GET -->
                <a href="modifier_objet.php?id=<?= $row['id'] ?>">Modifier</a> |
                <!-- Lien de suppression avec confirmation JavaScript avant exécution -->
                <a href="supprimer_objet.php?id=<?= $row['id'] ?>" onclick="return confirm('Supprimer ?');">
                    Supprimer
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<br>
<!-- Lien pour retourner au tableau de bord -->
<a href="dashboard.php">⬅ Retour</a>

</body>
</html>
