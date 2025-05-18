<?php
session_start();

// Redirection vers login si non connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Supprimer un voyage du panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $index = intval($_POST['supprimer']);
    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
        $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexe
    }
}

// Accéder à un voyage pour paiement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payer'])) {
    $index = intval($_POST['payer']);
    if (isset($_SESSION['panier'][$index])) {
        $_SESSION['current_voyage'] = $_SESSION['panier'][$index];
        header("Location: recapitulatif.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link id="theme-style" rel="stylesheet" href="../css/style_nuit.css">
    <script src="../js/theme.js" defer></script>
</head>
<body>
    <video class="fond" autoplay muted loop>
        <source src="../img/video.mp4">
    </video>

    <div class="top">
        <div class="topleft">
            <a href="index.php">
                <video id="logo-video" class="logo" autoplay muted>
                    <source src="../img/Logo-3-[cut](site).mp4" type="video/mp4">
                </video>
            </a>
        </div>
        <ul>
            <li><a href="aboutus.php">A propos</a></li>
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
            <li>|</li>
            <li><a href="panier.php" class="panier-icon">🛒</a></li>
			<button id="theme-switch">Mode jour/nuit</button><!---->
        </ul>
        <a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>

    <div class="en-tete"></div>
    <div class="espace-voyager"></div>

    <section class="panier">
    <h1>Mon Panier</h1>

    <?php
    $panier = $_SESSION['panier'] ?? [];
    if (empty($panier)) {
        echo '<div class="panier-vide">Votre panier est vide.</div>';
    } else {
        $prix_total = 0;
        echo '<div class="panier-liste">';
        foreach ($panier as $index => $voyage) {
            $description = "Du " . date('d/m/Y', strtotime($voyage['dates']['depart'])) . " au " . date('d/m/Y', strtotime($voyage['dates']['arrivee'])) . " (" . $voyage['dates']['duree'] . " jours)";
            $nbAdultes = intval($voyage['passagers']['adultes'] ?? 0);
            $nbEnfants = intval($voyage['passagers']['enfants'] ?? 0);
            $prixBase = intval($voyage['prix']);
            $prixOptions = 0;

            if (!empty($voyage['options']) && is_array($voyage['options'])) {
                foreach ($voyage['options'] as $opt) {
                    $prixOptions += $opt['prix'] * $nbAdultes;
                    $prixOptions += $opt['prix'] * $nbEnfants * 0.7;
                }
            }

            $prixVoyage = ($prixBase * $nbAdultes) + ($prixBase * $nbEnfants * 0.7) + $prixOptions;
            $prix_total += $prixVoyage;

            echo '<div class="panier-item">';
            echo "<h3>" . htmlspecialchars($voyage['titre']) . "</h3>";
            echo "<p>" . htmlspecialchars($description) . "</p>";
            echo "<p><strong>Total :</strong> " . number_format($prixVoyage, 2) . " €</p>";

            echo '<form method="POST" style="display:inline-block;">';
            echo '<input type="hidden" name="supprimer" value="' . $index . '">';
            echo '<button class="btn-supprimer" type="submit">Supprimer</button>';
            echo '</form>';

            echo '<form method="POST" style="display:inline-block; margin-left: 20px;">';
            echo '<input type="hidden" name="payer" value="' . $index . '">';
            echo '<button class="btn-ajouter-panier" type="submit">Payer</button>';
            echo '</form>';

            echo '</div>';
        }
        echo '</div>';

        echo '<div style="margin-top: 30px; text-align: right;"><h2>Total global : ' . number_format($prix_total, 2) . ' €</h2></div>';
    }
    ?>
</section>

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
