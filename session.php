<?php
session_start(); 
// Démarre la session pour pouvoir accéder aux variables de session

if (!isset($_SESSION['user_id'])) {  
    // Vérifie si l'utilisateur est connecté
    // Si la variable de session 'user_id' n'existe pas, cela signifie que l'utilisateur n'est pas authentifié
    
    header("Location: login.php");  
    // Redirige l'utilisateur vers la page de connexion

    exit;  
    // Arrête l'exécution du script après la redirection
}
?>

