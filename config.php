<?php
// Paramètres de connexion
$host = "localhost";
$user = "root";        // utilisateur par défaut XAMPP
$pass = "";            // mot de passe vide dans XAMPP
$db   = "objets_perdus";

// Connexion
$conn = mysqli_connect($host, $user, $pass, $db);

// Vérification de la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Toujours utiliser UTF-8
mysqli_set_charset($conn, "utf8");
?>
