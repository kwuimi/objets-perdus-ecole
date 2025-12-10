<?php
require 'session.php';
require 'config.php';

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

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Lieu trouvé</th>
        <th>Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($results)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nom'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['lieu_trouve'] ?></td>
            <td><?= $row['date_trouve'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="modifier_objet.php?id=<?= $row['id'] ?>">Modifier</a> |
                <a href="supprimer_objet.php?id=<?= $row['id'] ?>" onclick="return confirm('Supprimer ?');">
                    Supprimer
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<br>
<a href="dashboard.php">⬅ Retour</a>

</body>
</html>
