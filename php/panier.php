<?php
session_start();

// Vérifier l'état de connexion
$isLoggedIn = isset($_SESSION['email']);
$isAdmin = false;
$pp = "../img/default.png";

if ($isLoggedIn) {
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);
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
            if ($user["email"] === $email && !empty($user["pp"])) {
                $pp = $user["pp"];
                break;
            }
        }
    }
}

// Charger le panier
$panier = $_SESSION['panier'] ?? [];

// Supprimer un élément
if (isset($_POST['supprimer']) && isset($_POST['index'])) {
    $index = (int) $_POST['index'];
    if (isset($panier[$index])) {
        unset($panier[$index]);
        $panier = array_values($panier);
        $_SESSION['panier'] = $panier;
    }
    header("Location: panier.php");
    exit();
}

// Aller au paiement
if (isset($_POST['payer'])) {
    if ($isLoggedIn && !empty($panier)) {
        $_SESSION['current_voyage'] = $panier[0]; // tu peux personnaliser l’index
        header("Location: recapitulatif.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <link id="theme-style" rel="stylesheet" href="../css/style_nuit.css">
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
        <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
    </ul>
    <a href="user.php">
        <img src="<?= htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
    </a>
</div>

<div class="en-tete"></div>
<div class="espace-voyager"></div>

<section class="panier">
    <h2>Mon Panier</h2>

    <?php if (empty($panier)): ?>
        <div class="panier-vide">🛒 Votre panier est vide.</div>
    <?php else: ?>
        <?php $prix_total = 0; ?>
        <?php foreach ($panier as $index => $voyage): ?>
            <?php
            $nb_adultes = $voyage['passagers']['adultes'];
            $nb_enfants = $voyage['passagers']['enfants'];
            $nb_bebes = $voyage['passagers']['bebes'];

            $total_personnes = $nb_adultes + $nb_enfants + $nb_bebes;

            $prix = $voyage['prix'] * $nb_adultes;
            $prix += $voyage['prix'] * $nb_enfants * 0.7;

            if (!empty($voyage['options'])) {
                foreach ($voyage['options'] as $opt) {
                    $prix += $opt['prix'] * $nb_adultes;
                    $prix += $opt['prix'] * $nb_enfants * 0.7;
                }
            }

            $prix_total += $prix;
            ?>
            <div class="panier-item">
                <h3><?= htmlspecialchars($voyage['titre']) ?></h3>
                <p>📅 Dates : <?= htmlspecialchars($voyage['dates']['depart']) ?> → <?= htmlspecialchars($voyage['dates']['arrivee']) ?> (<?= $voyage['dates']['duree'] ?> jours)</p>
                <p>👨‍👩‍👧‍👦 Passagers : Adultes <?= $nb_adultes ?>, Enfants <?= $nb_enfants ?>, Bébés <?= $nb_bebes ?></p>
                <?php if (!empty($voyage['options'])): ?>
                    <p>🔧 Options :</p>
                    <ul>
                        <?php foreach ($voyage['options'] as $opt): ?>
                            <li><?= htmlspecialchars($opt['etape']) ?> : <?= htmlspecialchars($opt['nom']) ?> (+<?= $opt['prix'] ?>€/pers)</li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <form method="POST" action="modifier_panier.php">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit" class="btn-ajouter-panier">✏️ Modifier</button>
                </form>
                <form method="POST" action="panier.php">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <input type="hidden" name="supprimer" value="1">
                    <button type="submit" class="btn-supprimer">🗑 Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>

        <div class="panier-total">
            <h3>Total : <?= number_format($prix_total, 2) ?> €</h3>
            <form method="POST">
                <button name="payer" class="btn-ajouter-panier">Payer</button>
            </form>
        </div>
    <?php endif; ?>
</section>

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
