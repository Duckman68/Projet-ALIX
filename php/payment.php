<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


if (!isset($_SESSION['current_voyage'])) {
    header("Location: voyager.php");
    exit();
}

$voyage_data = $_SESSION['current_voyage'];
$titre = htmlspecialchars($voyage_data['titre']);
$date_depart = date('d/m/Y', strtotime($voyage_data['dates']['depart']));
$date_retour = date('d/m/Y', strtotime($voyage_data['dates']['arrivee']));
$duree = $voyage_data['dates']['duree'] ?? 0;
$classe = htmlspecialchars(ucfirst($voyage_data['classe']));
$sans_escale = $voyage_data['sans_escale'] ? 'Oui' : 'Non';

$adultes = $voyage_data['passagers']['adultes'];
$enfants = $voyage_data['passagers']['enfants'];
$bebes = $voyage_data['passagers']['bebes'];
$prix_base = $voyage_data['prix'];

$prix_total = ($prix_base * $adultes) + ($prix_base * 0.7 * $enfants);
foreach ($voyage_data['options'] as $option) {
    $prix_total += ($option['prix'] * $adultes) + ($option['prix'] * 0.7 * $enfants);
}

$montant_formate = number_format($prix_total, 2, '.', '');
$transaction_id = strtoupper(bin2hex(random_bytes(5)));
$vendeur = "MI-2_J";

function getAPIKey($vendeur) {
    return substr(md5($vendeur), 1, 15);
}

$api_key = getAPIKey($vendeur);

$retour = "http://localhost:1234/php/retour_paiement.php";
$control = md5($api_key . "#" . $transaction_id . "#" . $montant_formate . "#" . $vendeur . "#" . $retour . "#");

$pp = "../img/default.png";
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);

    if ($data !== null) {
        foreach ($data['user'] as $user) {
            if ($user['email'] === $email && !empty($user['pp'])) {
                $pp = $user['pp'];
                break;
            }
        }
        foreach ($data['admin'] as $admin) {
            if ($admin['email'] === $email && !empty($admin['pp'])) {
                $pp = $admin['pp'];
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>A.L.I.X. - Paiement</title>
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" /><!---->
	<script src="../js/theme.js" defer></script><!---->
</head>
<body>
    <video class="fond" autoplay loop muted>
        <source src="../img/video.mp4" type="video/mp4">
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
            <li>|</li>
            <li><a href="sign-up.php">Inscription</a></li>
            <li>|</li>
            <li><a href="panier.php" title="Voir le panier" class="panier-icon">🛒</a></li>
            <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
        </ul>
        <a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>

    <div class="en-tete"></div>

    <div class="flight">
        <h2 style="color:#00ffff;">Informations de votre voyage</h2>
        <p><strong>Destination :</strong> <?php echo $titre; ?></p>
        <p><strong>Départ :</strong> <?php echo $date_depart; ?></p>
        <p><strong>Retour :</strong> <?php echo $date_retour; ?></p>
        <p><strong>Durée :</strong> <?php echo $duree; ?> jours</p>
        <p><strong>Classe :</strong> <?php echo $classe; ?> Class</p>
        <p><strong>Sans escale :</strong> <?php echo $sans_escale; ?></p>
        <p><strong>Total à payer :</strong> <span style="color:#00ffff;font-size:20px;"><?php echo $prix_total; ?> €</span></p>
    </div>

    <div class="flight" style="margin-top: 30px;">
        <h2 style="color:#00ffff;">Informations de paiement</h2>
        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
            <input type="hidden" name="transaction" value="<?= $transaction_id ?>">
            <input type="hidden" name="montant" value="<?= $montant_formate ?>">
            <input type="hidden" name="vendeur" value="<?= $vendeur ?>">
            <input type="hidden" name="retour" value="<?= $retour ?>">
            <input type="hidden" name="control" value="<?= $control ?>">
            <button type="submit">Payer <?= $montant_formate ?> €</button>
        </form>
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
