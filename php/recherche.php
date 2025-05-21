<?php
session_start();
$query = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

$voyages_data = json_decode(file_get_contents("../json/voyage.json"), true);
$etapes_data = json_decode(file_get_contents("../json/etapes.json"), true);

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

// Résultats
$results = [];
$matching_etape_ids = [];

if ($etapes_data && isset($etapes_data['etapes'])) {
    foreach ($etapes_data['etapes'] as $etape) {
        if (stripos($etape['titre'], $query) !== false) {
            $matching_etape_ids[] = $etape['id'];
        }
    }
}

if ($query && $voyages_data && isset($voyages_data['voyages'])) {
    foreach ($voyages_data['voyages'] as $voyage) {
        $matchTitre = stripos($voyage['titre'], $query) !== false;
        $matchEtape = false;

        foreach ($voyage['etapes'] as $etape_id) {
            if (in_array($etape_id, $matching_etape_ids)) {
                $matchEtape = true;
                break;
            }
        }

        if ($matchTitre || $matchEtape) {
            $results[] = $voyage;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Résultats de recherche</title>
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet">
    <script src="../js/theme.js" defer></script>
    <script src="../js/tri_recherche.js" defer></script>
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
            <li><a href="panier.php" title="Voir le panier" class="panier-icon">🛒</a></li>
            <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
        </ul>
        <a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>

    <div class="espace"></div>

    <div class="recherche">
        <form action="recherche.php" method="GET" class="recherche">
            <input type="text" name="q" placeholder="Chercher une planète, un voyage" required value="<?php echo htmlspecialchars($query); ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>


    <div class="flight">
        <div class="tri">
            <label for="sort-select">Trier par :</label>
            <select id="sort-select">
                <option value="default">Par défaut</option>
                <option value="prix-asc">Prix croissant</option>
                <option value="prix-desc">Prix décroissant</option>
                <option value="duree-asc">Durée croissante</option>
                <option value="duree-desc">Durée décroissante</option>
                <option value="date-asc">Date de début croissante</option>
                <option value="date-desc">Date de début décroissante</option>
            </select>
        </div>


        <h1 style="text-align:center; margin-top: 40px;">Résultats pour "<?php echo htmlspecialchars($query); ?>"</h1>

        <?php if (empty($results)): ?>
            <p style="text-align:center;">Aucun voyage trouvé.</p>
        <?php else: ?>
            <ul style="list-style: none; padding: 0; max-width: 900px; margin: 30px auto;">
                <?php foreach ($results as $voyage): ?>
                <li class="voyage-item"
                    data-prix="<?= htmlspecialchars($voyage['prix']) ?>"
                    data-date="<?= htmlspecialchars($voyage['dates']['debut']) ?>"
                    data-duree="<?= htmlspecialchars($voyage['dates']['duree_jours']) ?>"
                    style="background: rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 20px; margin-bottom: 20px; color: white;">
    
                    <h2><?= htmlspecialchars($voyage['titre']) ?></h2>
                    <p><strong>Camp de base :</strong> <?= htmlspecialchars($voyage['camp_de_base']) ?></p>
                    <p><strong>Prix :</strong> <?= htmlspecialchars($voyage['prix']) ?> crédits</p>
                    <p><strong>Durée :</strong> <?= htmlspecialchars($voyage['dates']['duree_jours']) ?> jours</p>
                    <p><strong>Date de début :</strong> <?= htmlspecialchars($voyage['dates']['debut']) ?></p>
                    <a href="voyager.php?id=<?= $voyage['id'] ?>" class="btn-reserver">Réserver</a>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

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
