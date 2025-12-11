<?php
require 'session.php';
require 'config.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM objets WHERE id=$id");
$obj = mysqli_fetch_assoc($result);

if (isset($_POST['nom'])) {

    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $lieu = mysqli_real_escape_string($conn, $_POST['lieu']);
    $date = $_POST['date'];
    $status = $_POST['status'];

    $update = "UPDATE objets SET 
                nom='$nom',
                description='$description',
                lieu_trouve='$lieu',
                date_trouve='$date',
                status='$status'
               WHERE id=$id";

    if (mysqli_query($conn, $update)) {
        $message = "Modifié avec succès !";
    } else {
        $message = "Erreur : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier objet</title>
</head>
<body>

<h2>Modifier l'objet</h2>

<?php if (isset($message)) echo "<p>$message</p>"; ?>

<form method="POST">
    Nom :<br>
    <input type="text" name="nom" value="<?= $obj['nom'] ?>" required><br><br>

    Description :<br>
    <textarea name="desription"><?= $obj['description'] ?></textarea><br><br>

    Lieu trouvé :<br>
    <input type="text" name="lieu" value="<?= $obj['lieu_trouve'] ?>" required><br><br>

    Date trouvée :<br>
    <input type="date" name="date" value="<?= $obj['date_trouve'] ?>" required><br><br>

    Status :<br>
    <select name="status">
        <option <?= $obj['status']=='Non réclamé'?'selected':'' ?>>Non réclamé</option>
        <option <?= $obj['status']=='Réclamé'?'selected':'' ?>>Réclamé</option>
    </select><br><br>

    <button type="submit">Modifier</button>
</form>

<br>
<a href="lister_objets.php">⬅ Retour</a>

</body>
</html>
