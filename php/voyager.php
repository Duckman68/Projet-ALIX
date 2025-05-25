<?php
session_start();

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

$voyages_data = json_decode(file_get_contents("../json/voyage.json"), true);
$voyages_all = $voyages_data['voyages'] ?? [];
$etapes_data = json_decode(file_get_contents("../json/etapes.json"), true);


$searchQuery = strtolower($_GET['search'] ?? '');
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$voyagesParPage = 5;

$voyagesFiltres = array_filter($voyages_all, function ($voyage) use ($searchQuery, $etapes_data) {
    if ($searchQuery === '') return true;

    // Cherche dans le titre
    if (stripos($voyage['titre'], $searchQuery) !== false) return true;

    // Cherche dans le camp de base
    if (stripos($voyage['camp_de_base'], $searchQuery) !== false) return true;

    // Cherche dans les noms des étapes
    foreach ($voyage['etapes'] as $etape_id) {
        if (!empty($etapes_data[$etape_id]) && stripos($etapes_data[$etape_id], $searchQuery) !== false) {
            return true;
        }
    }

    return false;
});



$totalVoyages = count($voyagesFiltres);
$totalPages = max(1, ceil($totalVoyages / $voyagesParPage));
$debut = ($page - 1) * $voyagesParPage;
$voyages = array_slice($voyagesFiltres, $debut, $voyagesParPage);
?>

<!DOCTYPE html>
<html>
<head>
    <title>A.L.I.X.</title>
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <meta charset="UTF-8">
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" />
    <script src="../js/theme.js" defer></script>
    <script src="../js/voyager.js"></script>
</head>
<body>
    <video class="fond" autoplay loop muted>
        <source src="../img/video2.mp4">
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
            <li>
                <a href="panier.php" title="Voir le panier" class="panier-icon">🛒</a>
            </li>
            <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
        </ul>
        <a href="user.php">
            <img src="<?= htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>
    
    <div class="en-tete"></div>
    <div class="espace-voyager"></div>

    <section class="flight">
        <form method="get" action="voyager.php" class="search-bar">
            <input type="text" name="search" placeholder="Rechercher une destination..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">Rechercher</button>
        </form>
    </section>

    <div class="results-container">
        <h2>Voyages disponibles</h2>
        <?php if (empty($voyages)): ?>
            <p class="no-result">Aucune destination ne correspond à votre recherche.</p>
        <?php else: ?>
        <div class="hotel-style-list">
            <?php foreach ($voyages as $voyage): ?>
            <?php
            $imagePath = "../img/" . strtolower(str_replace(' ', '_', $voyage['titre'])) . ".png";
            if (!file_exists($imagePath)) {
                $imagePath = "../php/map/images/Mars.png";
            }
            ?>
            <div class="voyage-card">
                <img src="<?= $imagePath ?>" alt="planète" class="voyage-img">
                <div class="voyage-details">
    <h3><?= htmlspecialchars($voyage['titre']) ?></h3>
    <div class="voyage-content">
        <p class="voyage-desc">
            <?= nl2br(substr($voyage['descriptif'], 0, 300)) ?>
        </p>
        <div class="voyage-meta">
            <span class="price"><?= htmlspecialchars($voyage['prix']) ?> €</span>
            <form method="post" action="selection_option.php">
                <input type="hidden" name="voyage-id" value="<?= htmlspecialchars($voyage['id']) ?>">
                <input type="hidden" name="date-voyage" value="<?= date('Y-m-d') ?>">
                <input type="hidden" name="date-arrivee" value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                <button type="submit" class="btn-reserver">Réserver</button>
            </form>
        </div>
    </div>
</div>


            </div>
        <?php endforeach; ?>
        </div>


            <!-- PAGINATION -->
            <div class="pagination" style="text-align:center;margin-top:20px;">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php
                        $params = $_GET;
                        $params['page'] = $i;
                        $url = 'voyager.php?' . http_build_query($params);
                    ?>
                    <a href="<?= htmlspecialchars($url) ?>"
                       style="display:inline-block;margin:0 5px;padding:6px 12px;border-radius:4px;
                              background-color:<?= $i === $page ? '#666' : '#444' ?>;
                              color:white;text-decoration:none;">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
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