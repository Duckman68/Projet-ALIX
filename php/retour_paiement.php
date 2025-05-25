<?php
session_start();

// Détection connexion utilisateur
$isLoggedIn = isset($_SESSION['email']);
$isAdmin = false;
$pp = "../img/default.png";

if ($isLoggedIn) {
    $json_file = "../json/utilisateurs.json";
    $data = json_decode(file_get_contents($json_file), true);
    $email = $_SESSION['email'];
    if (!empty($data)) {
        foreach ($data['admin'] as $admin) {
            if ($admin['email'] === $email) {
                $isAdmin = true;
                if (!empty($admin['pp'])) $pp = $admin['pp'];
                break;
            }
        }
        if (!$isAdmin) {
            foreach ($data['user'] as $user) {
                if ($user['email'] === $email) {
                    if (!empty($user['pp'])) $pp = $user['pp'];
                    break;
                }
            }
        }
    }
}

function afficherEntete() {
    global $pp, $isLoggedIn, $isAdmin;
    ?>
    <!DOCTYPE html>
    <html>
    <head>  
        <meta charset="UTF-8">
        <title>A.L.I.X. — Paiement</title>
        <link rel="icon" href="../img/favicon.png" type="image/png">
        <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" />
        <script src="../js/theme.js" defer></script>
    </head>
    <body>
        <video class="fond" autoplay loop muted>
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
                <li>|</li>
                <li><a href="voyager.php">Voyager</a></li>
                <?php if ($isLoggedIn && $isAdmin): ?>
                    <li>|</li>
                    <li><a href="admin.php">Admin</a></li>
                <?php endif; ?>
                <?php if (!$isLoggedIn): ?>
                    <li>|</li>
                    <li><a href="login.php">Connexion</a></li>
                    <li>|</li>
                    <li><a href="sign-up.php">Inscription</a></li>
                <?php endif; ?>
                <li>|</li>
                <li><a href="panier.php" class="panier-icon" title="Voir le panier">🛒</a></li>
                <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
            </ul>
            <a href="user.php">
                <img src="<?= htmlspecialchars($pp ?? '../img/default.png') ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
            </a>
        </div>
        <div class="en-tete"></div>
    <?php
}

function afficherFooter() {
    ?>
    <footer class="site-footer">
        <div class="footer-grid">
            <div class="footer-links">
                <h3>Liens rapides</h3>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="voyager.php">Voyager</a></li>
                    <li><a href="aboutus.php">À propos</a></li>
                    <li><a href="panier.php">Panier</a></li>
                </ul>
                <div class="footer-social">
                    <a href="https://www.linkedin.com/in/alix-exp%C3%A9rience-60b037367/" target="_blank" rel="noopener">
                        <img src="../img/link.png" alt="LinkedIn">
                    </a>
                    <a href="https://www.instagram.com/alix_experience?igsh=MTV4dDV2YWpsczdqNQ==" target="_blank" rel="noopener">
                        <img src="../img/insta.jpeg" alt="Instagram">
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61576688187239" target="_blank" rel="noopener">
                        <img src="../img/facebook.png" alt="Facebook">
                    </a>
                    <a href="https://x.com/alix_experience" target="_blank" rel="noopener">
                        <img src="../img/X.jpeg" alt="X">
                    </a>
                </div>
            </div>
            <div class="footer-contact">
                <h3>Contact</h3>
                <p><strong>Mail :</strong> <a href="mailto:contact@alix.com">contact@alix.com</a></p>
                <p><strong>Téléphone :</strong> +33 1 23 45 67 89</p>
                <p><strong>Adresse :</strong><br>
                    <a href="https://www.google.com/maps/search/?api=1&query=Avenue+des+Champs-%C3%89lys%C3%A9es,+75008+Paris" target="_blank" rel="noopener">
                        Avenue des Champs-Élysées, 75008 Paris
                    </a>
                </p>
            </div>
            <div class="footer-newsletter">
                <h3>Newsletter</h3>
                <p>Inscrivez-vous pour recevoir nos offres exclusives :</p>
                <form class="newsletter-form" action="#" method="post">
                    <input type="email" name="email" placeholder="Votre email" required>
                    <button type="submit">S’abonner</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="footer-credits">Nassim | Atahan | Romain | Gabin</p>
            <p>© <?= date('Y') ?> A.L.I.X. — Tous droits réservés.</p>
            <button class="back-to-top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });" aria-label="Retour en haut"></button>
        </div>
    </footer>
    </body>
    </html>
    <?php
}

if (
    isset($_GET['transaction']) &&
    isset($_GET['status']) &&
    isset($_GET['montant']) &&
    isset($_GET['vendeur']) &&
    isset($_GET['control'])
) {
    $transaction_id = $_GET['transaction'];
    $status = $_GET['status'];
    $montant = $_GET['montant'];
    $vendeur = $_GET['vendeur'];
    $control_recu = $_GET['control'];

    function getAPIKey($vendeur) {
        return substr(md5($vendeur), 1, 15);
    }

    $api_key = getAPIKey($vendeur);
    $control_calcule = md5($api_key . "#" . $transaction_id . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

    if ($control_calcule !== $control_recu) {
        afficherEntete();
        echo "<div class='espace-profil'><h2 style='color:red;text-align:center;'>Erreur de vérification : données corrompues.</h2></div>";
        afficherFooter();
        exit();
    }

    if ($status === "accepted") {
        if (isset($_SESSION['email']) && isset($_SESSION['current_voyage'])) {
            $email = $_SESSION['email'];
            $voyage = $_SESSION['current_voyage'];

            $fichier_utilisateurs = '../json/utilisateurs.json';
            $utilisateurs = json_decode(file_get_contents($fichier_utilisateurs), true);

            $trouve = false;
            foreach ($utilisateurs['admin'] as &$admin) {
                if ($admin['email'] === $email) {
                    $admin['voyage']['achetes'][] = $voyage;
                    $trouve = true;
                    break;
                }
            }
            if (!$trouve) {
                foreach ($utilisateurs['user'] as &$user) {
                    if ($user['email'] === $email) {
                        $user['voyage']['achetes'][] = $voyage;
                        break;
                    }
                }
            }

            file_put_contents($fichier_utilisateurs, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            unset($_SESSION['current_voyage']);
            unset($_SESSION['panier']); // Vider le panier après paiement

            afficherEntete();
            echo "<div class='espace-profil'><h2 style='color:lime;text-align:center;'>✅ Paiement accepté ! Merci pour votre réservation.</h2></div>";
            afficherFooter();
            exit();
        } else {
            afficherEntete();
            echo "<div class='espace-profil'><h2 style='color:red;text-align:center;'>Erreur : utilisateur ou voyage introuvable.</h2></div>";
            afficherFooter();
            exit();
        }
    } elseif ($status === "declined") {
        afficherEntete();
        echo "<div class='espace-profil'><h2 style='color:orange;text-align:center;'>❌ Paiement refusé. Transaction : $transaction_id</h2></div>";
        afficherFooter();
    } else {
        afficherEntete();
        echo "<div class='espace-profil'><h2 style='color:gray;text-align:center;'>Statut inconnu pour la transaction : $transaction_id</h2></div>";
        afficherFooter();
    }
} else {
    afficherEntete();
    echo "<div class='espace-profil'><h2 style='color:red;text-align:center;'>Paramètres de retour incomplets.</h2></div>";
    afficherFooter();
}
