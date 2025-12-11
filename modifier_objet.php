<?php
// Inclusion des fichiers nécessaires pour la session et la configuration de la base de données
require 'session.php';
require 'config.php';

// Récupération de l'ID de l'objet à modifier depuis les paramètres GET de l'URL
$id = $_GET['id'];

// Requête pour récupérer les données actuelles de l'objet à modifier
$result = mysqli_query($conn, "SELECT * FROM objets WHERE id=$id");
$obj = mysqli_fetch_assoc($result);

// Vérification si le formulaire de modification a été soumis
if (isset($_POST['nom'])) {

    // Nettoyage des données saisies par l'utilisateur pour éviter les injections SQL
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $lieu = mysqli_real_escape_string($conn, $_POST['lieu']);
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Construction de la requête SQL UPDATE pour modifier l'objet dans la base de données
    $update = "UPDATE objets SET 
                nom='$nom',
                description='$description',
                lieu_trouve='$lieu',
                date_trouve='$date',
                status='$status'
               WHERE id=$id";

    // Exécution de la requête et vérification du résultat
    if (mysqli_query($conn, $update)) {
        // Message de succès si la mise à jour a réussi
        $message = "Modifié avec succès !";
    } else {
        // Message d'erreur en cas d'échec, avec l'erreur MySQL détaillée
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

<!-- Affichage conditionnel du message de succès ou d'erreur -->
<?php if (isset($message)) echo "<p>$message</p>"; ?>

<!-- Formulaire de modification des informations de l'objet -->
<form method="POST">
    Nom :<br>
    <!-- Champ pré-rempli avec la valeur actuelle de l'objet -->
    <input type="text" name="nom" value="<?= htmlspecialchars($obj['nom']) ?>" required><br><br>

    Description :<br>
    <!-- Zone de texte pré-remplie avec la description actuelle -->
    <textarea name="description"><?= htmlspecialchars($obj['description']) ?></textarea><br><br>

    Lieu trouvé :<br>
    <input type="text" name="lieu" value="<?= htmlspecialchars($obj['lieu_trouve']) ?>" required><br><br>

    Date trouvée :<br>
    <input type="date" name="date" value="<?= $obj['date_trouve'] ?>" required><br><br>

    Status :<br>
    <!-- Liste déroulante pour le statut avec sélection automatique de l'option actuelle -->
    <select name="status">
        <option <?= $obj['status']=='Non réclamé'?'selected':'' ?>>Non réclamé</option>
        <option <?= $obj['status']=='Réclamé'?'selected':'' ?>>Réclamé</option>
    </select><br><br>

    <button type="submit">Modifier</button>
</form>

<br>
<!-- Lien pour retourner à la liste des objets -->
<a href="lister_objets.php">⬅ Retour</a>

</body>
</html>
