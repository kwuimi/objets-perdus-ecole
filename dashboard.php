<?php
require 'session.php';
require 'config.php'; // Si vous avez un fichier config pour la DB

// Connexion à la base de données pour les statistiques
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Récupérer les statistiques
    // Nombre total d'objets perdus
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM objets_perdus");
    $totalObjets = $stmt->fetch()['total'];
    
    // Nombre d'objets trouvés aujourd'hui
    $stmt = $pdo->query("SELECT COUNT(*) as aujourdhui FROM objets_perdus WHERE DATE(date_creation) = CURDATE()");
    $objetsAujourdhui = $stmt->fetch()['aujourdhui'];
    
    // Nombre d'objets non réclamés
    $stmt = $pdo->query("SELECT COUNT(*) as non_reclames FROM objets_perdus WHERE statut = 'non_reclame'");
    $objetsNonReclames = $stmt->fetch()['non_reclames'];
    
    // Derniers objets ajoutés
    $stmt = $pdo->query("SELECT nom, date_creation, lieu FROM objets_perdus ORDER BY date_creation DESC LIMIT 5");
    $derniersObjets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $erreurDB = "Erreur de connexion à la base de données";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Système d'objets perdus</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9em;
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            background: white;
            border: 2px solid #667eea;
            border-radius: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            background: #667eea;
            color: white;
        }
        
        .recent-table {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: #f8f9fa;
            color: #495057;
        }
        
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #c82333;
        }
        
        .date-time {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }
        
        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="user-info">
            <h1>Tableau de bord</h1>
            <div>
                <strong>Connecté en tant que :</strong> <?php echo htmlspecialchars($_SESSION['username']); ?><br>
                <span class="date-time"><?php echo date('d/m/Y H:i'); ?></span>
            </div>
        </div>
        <p>Bienvenue dans le système de gestion des objets perdus</p>
    </div>
    
    <?php if(isset($erreurDB)): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <?php echo $erreurDB; ?>
        </div>
    <?php endif; ?>
    
    <!-- Section Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $totalObjets ?? 0; ?></div>
            <div class="stat-label">Objets perdus au total</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number"><?php echo $objetsAujourdhui ?? 0; ?></div>
            <div class="stat-label">Ajoutés aujourd'hui</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number"><?php echo $objetsNonReclames ?? 0; ?></div>
            <div class="stat-label">Non réclamés</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number"><?php echo date('H:i'); ?></div>
            <div class="stat-label">Heure actuelle</div>
        </div>
    </div>
    
    <!-- Section Actions rapides -->
    <div class="actions-grid">
        <a href="ajouter_objet.php" class="action-btn">
            <span>➕</span>
            <span>Ajouter un objet</span>
        </a>
        
        <a href="lister_objets.php" class="action-btn">
            <span>📋</span>
            <span>Voir tous les objets</span>
        </a>
        
        <a href="rechercher.php" class="action-btn">
            <span>🔍</span>
            <span>Rechercher un objet</span>
        </a>
        
        <a href="rapport.php" class="action-btn">
            <span>📊</span>
            <span>Générer un rapport</span>
        </a>
        
        <a href="parametres.php" class="action-btn">
            <span>⚙️</span>
            <span>Paramètres</span>
        </a>
        
        <a href="aide.php" class="action-btn">
            <span>❓</span>
            <span>Aide & Support</span>
        </a>
    </div>
    
    <!-- Section Derniers objets ajoutés -->
    <div class="recent-table">
        <h3>📝 Derniers objets ajoutés</h3>
        <?php if(!empty($derniersObjets)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom de l'objet</th>
                        <th>Lieu de découverte</th>
                        <th>Date d'ajout</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($derniersObjets as $objet): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($objet['nom']); ?></td>
                            <td><?php echo htmlspecialchars($objet['lieu']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($objet['date_creation'])); ?></td>
                            <td>
                                <a href="voir_objet.php?id=<?php echo $objet['id']; ?>" style="color: #667eea;">Voir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #666; text-align: center;">Aucun objet enregistré pour le moment.</p>
        <?php endif; ?>
    </div>
    
    <!-- Pied de page avec déconnexion -->
    <div style="text-align: center; margin-top: 30px;">
        <a href="logout.php" class="logout-btn">🚪 Déconnexion</a>
        <p style="color: #666; margin-top: 10px;">
            © <?php echo date('Y'); ?> - Système de gestion des objets perdus
        </p>
    </div>
    
    <script>
        // Mise à jour de l'heure en temps réel
        function updateTime() {
            const now = new Date();
            const timeElement = document.querySelector('.stat-number:last-child');
            if(timeElement) {
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                timeElement.textContent = `${hours}:${minutes}`;
            }
        }
        
        // Mettre à jour l'heure toutes les minutes
        setInterval(updateTime, 60000);
        
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>