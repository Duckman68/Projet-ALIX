<?php
session_start();

// Vérification de la session et récupération des données utilisateur
$pp = "../img/default.png";
$isLoggedIn = false;
$isAdmin = false;

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);

    if ($data !== null) {
        $email = $_SESSION['email'];
        foreach ($data["admin"] as $admin) {
            if ($admin["email"] === $email) {
                $isAdmin = true;
                if (!empty($admin["pp"])) {
                    $pp = $admin["pp"];
                }
                break;
            }
        }
        if (!$isAdmin) {
            foreach ($data["user"] as $user) {
                if ($user["email"] === $email) {
                    if (!empty($user["pp"])) {
                        $pp = $user["pp"];
                    }
                    break;
                }
            }
        }
    }
}

// Récupération des données du voyage depuis la session
$voyage_data = $_SESSION['current_voyage'] ?? null;
if (!$voyage_data) {
    header("Location: voyager.php");
    exit();
}

// Calcul du prix total
$prix_total = 0;
foreach ($voyage_data['options'] as $option) {
    $prix_total += $option['prix'] * $voyage_data['passagers']['adultes'];
    $prix_total += $option['prix'] * $voyage_data['passagers']['enfants'] * 0.7; // 30% de réduction pour les enfants
}
?>

<!DOCTYPE html>
<html>
<head>    
    <meta charset="UTF-8">
    <title>A.L.I.X.</title>
    <link href="../css/style.css" rel="stylesheet" />
 
</head>
<body>
    <video class="fond" autoplay loop muted>
        <source src="../img/video.mp4">
    </video>
    <div class="top">
        <div class="topleft">
            <a href="index.php">
                <video class="logo" autoplay muted>
                    <source src="../img/Logo-3-[cut](site).mp4" type="video/mp4">
                </video>
            </a>
        </div>
        <ul>
            <li><a href="aboutus.php">A propos</a></li>
            <li>|</li>
            <li><a href="voyager.php">Voyager</a></li>
            <?php if (!$isLoggedIn): ?>
                <li>|</li>
                <li><a href="login.php">Connexion</a></li>
                <li>|</li>
                <li><a href="sign-up.php">Inscription</a></li>
            <?php else: ?>
                <?php if ($isAdmin): ?>
                    <li>|</li>
                    <li><a href="admin.php">Admin</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
        <a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>
    <div class="en-tete"></div>
    
    <div class="corps-recap">
        <h1>Récapitulatif de votre voyage</h1>
        
        <div class="recap-commande">
            <!-- Section Informations générales -->
            <div class="recap-section">
                <h2>Informations du voyage</h2>
                <div class="recap-details">
                    <div>
                        <div class="detail-item">
                            <span class="detail-label">Destination :</span>
                            <span class="detail-value"><?php echo htmlspecialchars($voyage_data['titre']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Date de départ :</span>
                            <span class="detail-value"><?php echo date('d/m/Y', strtotime($voyage_data['dates']['depart'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Date de retour :</span>
                            <span class="detail-value"><?php echo date('d/m/Y', strtotime($voyage_data['dates']['arrivee'])); ?></span>
                        </div>
                    </div>
                    <div>
                        <div class="detail-item">
                            <span class="detail-label">Durée :</span>
                            <span class="detail-value"><?php echo $voyage_data['duree']; ?> jours</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Classe :</span>
                            <span class="detail-value"><?php echo htmlspecialchars(ucfirst($voyage_data['classe'])); ?> Class</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Sans escale :</span>
                            <span class="detail-value"><?php echo $voyage_data['sans_escale'] ? 'Oui' : 'Non'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section Passagers -->
            <div class="recap-section">
                <h2>Passagers</h2>
                <div class="recap-details">
                    <div>
                        <div class="detail-item">
                            <span class="detail-label">Adultes :</span>
                            <span class="detail-value"><?php echo $voyage_data['passagers']['adultes']; ?> (Plein tarif)</span>
                        </div>
                    </div>
                    <div>
                        <div class="detail-item">
                            <span class="detail-label">Enfants :</span>
                            <span class="detail-value"><?php echo $voyage_data['passagers']['enfants']; ?> (-30%)</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Bébés :</span>
                            <span class="detail-value"><?php echo $voyage_data['passagers']['bebes']; ?> (Gratuit)</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section Options choisies -->
            <div class="recap-section">
                <h2>Options sélectionnées</h2>
                <?php foreach ($voyage_data['etapes'] as $etape): ?>
                    <h3><?php echo htmlspecialchars($etape['titre']); ?></h3>
                    <?php foreach ($etape['options'] as $option): ?>
                        <div class="option-item">
                            <span><?php echo htmlspecialchars($option['nom']); ?></span>
                            <span><?php echo $option['prix']; ?> € / personne</span>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            
            <!-- Section Total -->
            <div class="total-section">
                <div class="detail-item">
                    <span class="detail-label">Total :</span>
                    <span class="total-amount"><?php echo $prix_total; ?> €</span>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="action-buttons">
                <a href="selection_option.php" class="btn btn-modifier">Modifier le voyage</a>
                <a href="payment.php" class="btn btn-confirmer">Confirmer et payer</a>
            </div>
        </div>
    </div>
    
    <div class="bottom">
        <h1>Crédits</h1>
        <div class="textebot">
            <h2>Nassim</h2>
            <h2>Atahan</h2>
            <h2>Romain</h2>
            <h2>Gabin</h2>
        </div>
    </div>
</body>
</html>