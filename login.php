<?php
session_start();
require 'config.php';

// Si le formulaire est soumis
if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Le même hash que dans la BD

    // Vérifier si l'utilisateur existe
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Récupérer les données
        $user = mysqli_fetch_assoc($result);

        // Créer la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirection
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Nom d'utilisateur ou  mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>

    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

    <form method="POST" action="">
        <label>Nom d'utilisateur :</label><br>
        <input type="text" name="username" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Se connecter</button>
    </form>

</body>
</html>
