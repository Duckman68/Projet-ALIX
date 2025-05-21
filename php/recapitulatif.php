<?php
session_start();

$pp = "../img/default.png";
$isLoggedIn = false;
$isAdmin = false;

if (!isset($_SESSION['email'])) {
    $_SESSION['redirect_after_login'] = "recapitulatif.php";
    header("Location: login.php");
    exit();
}

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

$voyage_data = $_SESSION['current_voyage'] ?? null;
if (!$voyage_data) {
    header("Location: voyager.php");
    exit();
}

// Calcul du prix total
$adultes = $voyage_data['passagers']['adultes'];
$enfants = $voyage_data['passagers']['enfants']; 
$bebes = $voyage_data['passagers']['bebe'];

$prix_base = $voyage_data['prix'];
$prix_total = ($prix_base * $adultes) + ($prix_base * 0.7 * $enfants);

foreach ($voyage_data['options'] as $option) {
    $prix_total += ($option['prix'] * $adultes) + ($option['prix'] * $enfants * 0.7);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>A.L.I.X.</title>
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" /><!---->
	<script src="../js/theme.js" defer></script><!---->
</head>
<body>
<video class="fond" autoplay loop muted><source src="../img/video.mp4"></video>

<div class="top">
    <div class="topleft">
        <a href="index.php">
            <video id="logo-video" class="logo" autoplay muted><source src="../img/Logo-3-[cut](site).mp4" type="video/mp4"></video>
        </a>
    </div>
    <ul>
        <li><a href="aboutus.php">A propos</a></li>
        <li>|</li>
        <li><a href="voyager.php">Voyager</a></li>
        <?php if (!$isLoggedIn): ?>
            <li>|</li><li><a href="login.php">Connexion</a></li><li>|</li><li><a href="sign-up.php">Inscription</a></li>
        <?php else: ?>
            <?php if ($isAdmin): ?><li>|</li><li><a href="admin.php">Admin</a></li><?php endif; ?>
        <?php endif; ?>
        <li>|</li>
        <li>
            <a href="panier.php" title="Voir le panier" class="panier-icon">🛒</a>
        </li>
		<button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
    </ul>
    <a href="user.php"><img src="<?= htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'"></a>
</div>

<div class="en-tete"></div>

<div class="corps-recap">
    <h1>Récapitulatif de votre voyage</h1>
    <div class="recap-commande">
        <div class="recap-section">
            <h2>Informations du voyage</h2>
            <div class="recap-details">
                <div>
                    <div class="detail-item"><span class="detail-label">Destination :</span><span class="detail-value"><?= htmlspecialchars($voyage_data['titre']); ?></span></div>
                    <div class="detail-item"><span class="detail-label">Date de départ :</span><span class="detail-value"><?= date('d/m/Y', strtotime($voyage_data['dates']['depart'])); ?></span></div>
                    <div class="detail-item"><span class="detail-label">Date de retour :</span><span class="detail-value"><?= date('d/m/Y', strtotime($voyage_data['dates']['arrivee'])); ?></span></div>
                </div>
                <div>
                    <div class="detail-item"><span class="detail-label">Durée :</span><span class="detail-value"><?= $voyage_data['dates']['duree']; ?> jours</span></div>
                </div>
            </div>
        </div>

        <div class="recap-section">
            <h2>Passagers</h2>
            <div class="recap-details">
                <div>
                    <div class="detail-item"><span class="detail-label">Adultes :</span><span class="detail-value"><?= $voyage_data['passagers']['adultes']; ?> (Plein tarif)</span></div>
                </div>
                <div>
                    <div class="detail-item"><span class="detail-label">Enfants :</span><span class="detail-value"><?= $voyage_data['passagers']['enfants']; ?> (-30%)</span></div>
                    <div class="detail-item"><span class="detail-label">Bébés :</span><span class="detail-value"><?= $voyage_data['passagers']['bebes']; ?> (Gratuit)</span></div>
                </div>
            </div>
        </div>

        <div class="recap-section">
            <h2>Options sélectionnées</h2>
            <?php foreach ($voyage_data['options'] as $option): ?>
                <div class="option-item">
                    <span><?= htmlspecialchars($option['nom']); ?></span>
                    <span><?= $option['prix']; ?> € / personne</span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="total-section">
            <div class="detail-item">
                <span class="detail-label">Total :</span>
                <span class="total-amount"><?= $prix_total; ?> €</span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="selection_option.php" class="btn btn-modifier">Modifier le voyage</a>
            <?php if ($isLoggedIn): ?>
                <a href="payment.php" class="btn btn-confirmer">Confirmer et payer</a>
            <?php else: ?>
                <a href="login.php?redirect=recapitulatif" class="btn btn-confirmer">Se connecter pour payer</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="espace-bottom-login"></div>
<footer class="site-footer">
		<div class="footer-grid">
			<div class="footer-links">
				<h3>Liens rapides</h3>
				<ul>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="voyager.php">Voyager</a></li>
					<li><a href="aboutus.php">À propos</a></li>
					<li><a href="Panier.php">Panier</a></li>
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
				<p>
					<strong>Mail :</strong>
					<a href="mailto:contact@alix.com">contact@alix.com</a>
				</p>
				<p><strong>Téléphone :</strong> +33 1 23 45 67 89</p>
				<p>
					<strong>Adresse :</strong><br>
					<a
					href="https://www.google.com/maps/search/?api=1&query=Avenue+des+Champs-%C3%89lys%C3%A9es,+75008+Paris"
					target="_blank"
					rel="noopener"
					>
					Avenue des Champs-Élysées, 75008 Paris
					</a>
				</p>
			</div>

			<div class="footer-newsletter">
				<h3>Newsletter</h3>
				<p>Inscrivez-vous pour recevoir nos offres exclusives :</p>
				<form class="newsletter-form" action="#" method="post">
					<input
					type="email"
					name="email"
					placeholder="Votre email"
					required
					>
					<button type="submit">S’abonner</button>
				</form>
			</div>
		</div>

		<div class="footer-bottom">
			<p class="footer-credits">Nassim | Atahan | Romain | Gabin</p>
			<p>© <?= date('Y') ?> A.L.I.X. — Tous droits réservés.</p>
			<button
			class="back-to-top"
			aria-label="Retour en haut"
			onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
			></button>
		</div>
	</footer>
</body>
</html>
