<?php
require 'session.php';
require 'config.php';

if (isset($_POST['nom'])) {

    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $lieu = mysqli_real_escape_string($conn, $_POST['lieu']);
    $date = $_POST['date'];

    $query = "INSERT INTO objets (nom, description, lieu_trouve, date_trouve)
              VALUES ('$nom', '$description', '$lieu', '$date')";

    if (mysqli_query($conn, $query)) {
        $message = "Objet ajouté avec succès !";
    } else {
        $message = "Erreur : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un objet</title>
</head>
<body>

<h2>Ajouter un objet perdu</h2>

<?php if (isset($message)) echo "<p>$message</p>"; ?>

<form method="POST">
    Nom de l'objet :<br>
    <input type="text" name="nom" required><br><br>

    Description :<br>
    <textarea name="description"></textarea><br><br>

    Lieu trouvé :<br>
    <input type="text" name="lieu" required><br><br>

    Date trouvée :<br>
    <input type="date" name="date" required><br><br>

    <button type="submit">Ajouter</button>
</form>

<br>
<a href="dashboard.php">⬅ Retour</a>

</body>
</html>
