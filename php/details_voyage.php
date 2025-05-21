<?php
session_start();

// Redirection si non connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Vérifie que l'ID du voyage est fourni
if (!isset($_GET['id'])) {
    echo "Aucun identifiant de voyage fourni.";
    exit();
}

// Chargement des données utilisateurs
$json_file = "../json/utilisateurs.json";
$data = json_decode(file_get_contents($json_file), true);
$email = $_SESSION['email'];
$utilisateur = null;
$isAdmin = false;
$pp = "../img/default.png";

// Recherche utilisateur dans admin ou user
foreach (["admin", "user"] as $role) {
    foreach ($data[$role] as $user) {
        if ($user['email'] === $email) {
            $utilisateur = $user;
            $isAdmin = ($role === "admin");
            $pp = $user["pp"] ?? $pp;
            break 2;
        }
    }
}

if (!$utilisateur) {
    echo "Utilisateur non trouvé.";
    exit();
}

// Récupération du voyage par ID
$voyage = null;
foreach ($utilisateur['voyage']['achetes'] as $v) {
    if ($v['voyage_id'] === $_GET['id']) {
        $voyage = $v;
        break;
    }
}

if (!$voyage) {
    echo "Voyage non trouvé.";
    exit();
}

// Formatage
$date_depart = date('d/m/Y', strtotime($voyage['dates']['depart']));
$date_arrivee = date('d/m/Y', strtotime($voyage['dates']['arrivee']));
$classe = ucfirst($voyage['classe']);
$sans_escale = $voyage['sans_escale'] ? 'Oui' : 'Non';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du Voyage</title>
    <link id="theme-style" rel="stylesheet" href="../css/style_nuit.css">
    <script src="../js/theme.js" defer></script>
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
            <?php if ($isAdmin): ?>
                <li><a href="admin.php">Admin</a></li>
                <li>|</li>
            <?php endif; ?>
            <li><a href="panier.php" title="Voir le panier" class="panier-icon">🛒</a></li>
            <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
        </ul>
        <a href="user.php">
            <img src="<?= htmlspecialchars($pp) ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>

    <div class="en-tete"></div>

    <div class="detail-voyage-container">
        <h1>Détail du Voyage</h1>

        <div class="detail-section">
            <h2>Informations Générales</h2>
            <p><span class="detail-label">Destination :</span> <?= htmlspecialchars($voyage['titre']) ?></p>
            <p><span class="detail-label">Départ :</span> <?= $date_depart ?></p>
            <p><span class="detail-label">Retour :</span> <?= $date_arrivee ?></p>
            <p><span class="detail-label">Durée :</span> <?= $voyage['dates']['duree'] ?> jours</p>
            <p><span class="detail-label">Classe :</span> <?= $classe ?></p>
            <p><span class="detail-label">Sans escale :</span> <?= $sans_escale ?></p>
        </div>

        <div class="detail-section">
            <h2>Passagers</h2>
            <p><span class="detail-label">Adultes :</span> <?= $voyage['passagers']['adultes'] ?></p>
            <p><span class="detail-label">Enfants :</span> <?= $voyage['passagers']['enfants'] ?></p>
            <p><span class="detail-label">Bébés :</span> <?= $voyage['passagers']['bebes'] ?></p>
        </div>

        <div class="detail-section">
            <h2>Options</h2>
            <?php if (!empty($voyage['options'])): ?>
                <?php foreach ($voyage['options'] as $opt): ?>
                    <div class="option-item">
                        <strong><?= htmlspecialchars($opt['etape']) ?> :</strong>
                        <?= htmlspecialchars($opt['nom']) ?> — <?= $opt['prix'] ?> €
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune option sélectionnée.</p>
            <?php endif; ?>
        </div>

        <a href="user.php" class="btn btn-modifier" style="margin-top: 30px; display: inline-block;">← Retour au profil</a>
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
