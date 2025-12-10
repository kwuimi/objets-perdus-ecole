<?php
require 'session.php';
require 'config.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM objets WHERE id=$id");

header("Location: lister_objets.php");
exit;
?>
