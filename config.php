<?php
/**
 * Configuration simplifiée
 */

// ============================================
// CONFIGURATION DE BASE
// ============================================

$config = [
    // Base de données
    'db_host' => 'localhost',
    'db_user' => 'root',
    'db_pass' => '',
    'db_name' => 'objets_perdus',
    
    // Application
    'app_name' => 'Objets Perdus École',
    'site_url' => 'http://localhost/objets-perdus-ecole',
    
    // Sécurité
    'session_name' => 'OBJETSPERDUS',
    'session_timeout' => 1800,
];

// ============================================
// CONNEXION À LA BASE DE DONNÉES
// ============================================

function db_connect() {
    global $config;
    
    $conn = mysqli_connect(
        $config['db_host'],
        $config['db_user'], 
        $config['db_pass'],
        $config['db_name']
    );
    
    if (!$conn) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }
    
    mysqli_set_charset($conn, "utf8");
    return $conn;
}

// ============================================
// FONCTIONS ESSENTIELLES
// ============================================

// Nettoyage de chaîne
function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Requête sécurisée
function db_query($sql, $params = []) {
    $conn = db_connect();
    
    if (empty($params)) {
        return mysqli_query($conn, $sql);
    }
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;
    
    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}

// Récupérer tous les résultats
function db_fetch_all($sql, $params = []) {
    $result = db_query($sql, $params);
    $rows = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    
    return $rows;
}

// Récupérer un seul résultat
function db_fetch_one($sql, $params = []) {
    $result = db_query($sql, $params);
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    return null;
}

// Connexion automatique
$db = db_connect();

?>