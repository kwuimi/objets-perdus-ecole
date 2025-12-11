<?php
// Inclusion des fichiers nécessaires pour la session et la configuration de la base de données
require 'session.php';
require 'config.php';

// Récupération de l'ID de l'objet à supprimer depuis les paramètres GET de l'URL
$id = $_GET['id'];

// Exécution de la requête DELETE pour supprimer l'objet correspondant à l'ID
// NOTE IMPORTANTE: Cette requête est vulnérable aux injections SQL car l'ID n'est pas validé ni échappé
mysqli_query($conn, "DELETE FROM objets WHERE id=$id");

// Redirection vers la page de liste des objets après la suppression
header("Location: lister_objets.php");
// Arrêt de l'exécution du script pour s'assurer que la redirection fonctionne
exit;
?>
