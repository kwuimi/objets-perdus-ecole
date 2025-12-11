<?php
// Inclusion des fichiers nécessaires pour la session et la configuration de la base de données
require 'session.php';
require 'config.php';

// Vérifie si le formulaire a été soumis en vérifiant la présence du champ 'nom'
if (isset($_POST['nom'])) {

    // Nettoyage des données saisies par l'utilisateur pour éviter les injections SQL
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $lieu = mysqli_real_escape_string($conn, $_POST['lieu']);
    // La date n'a pas besoin d'être échappée car elle provient d'un champ date HTML
    $date = $_POST['date'];

    // Construction de la requête SQL pour insérer un nouvel objet dans la table 'objets'
    $query = "INSERT INTO objets (nom, description, lieu_trouve, date_trouve)
              VALUES ('$nom', '$description', '$lieu', '$date')";

    // Exécution de la requête et vérification du résultat
    if (mysqli_query($conn, $query)) {
        // Message de succès si l'insertion a réussi
        $message = "Objet ajouté avec succès !";
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
    <title>Ajouter un objet</title>
</head>
<body>

<h2>Ajouter un objet perdu</h2>

<!-- Affichage conditionnel du message de succès ou d'erreur -->
<?php if (isset($message)) echo "<p>$message</p>"; ?>

<!-- Formulaire de saisie des informations sur l'objet perdu -->
<form method="POST">
    Nom de l'objet :<br>
    <input type="text" name="nom" required><br><br>

    Description :<br>
    <textarea name="description"></textarea><br><br>

    Lieu trouvé :<br>
    <input type="text" name="lieu" required><br><br>

    Date trouvée :<br>
    <input type="date" name="date" required><br><br>

    <button type="subit">Ajouter</button>
</form>

<br>
<!-- Lien pour retourner au tableau de bord -->
<a href="dashboard.php">⬅ Retour</a>

</body>
</html>
