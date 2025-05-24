<?php
session_start();

$pp = "../img/default.png"; // Valeur par défaut

if (isset($_SESSION['email'])) {
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);

    if ($data !== null) {
        $email = $_SESSION['email'];
        
        // Chercher dans les users
        foreach ($data["user"] as $user) {
            if ($user["email"] === $email) {
                if (!empty($user["pp"])) {
                    $pp = $user["pp"];
                }
                break;
            }
        }
        
        // Chercher dans les admins
        foreach ($data["admin"] as $admin) {
            if ($admin["email"] === $email) {
                if (!empty($admin["pp"])) {
                    $pp = $admin["pp"];
                }
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8">
	<title>A.L.I.X.</title>
	<link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" /><!---->
	<script src="../js/theme.js" defer></script><!---->
    <script src="../js/validation_inscription.js" defer></script>
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
			<li>|</li>
			<li><a href="login.php">Connexion</a></li>
            <li>|</li>
            <li>
                <a href="panier.php" title="Voir le panier" class="panier-icon">🛒</a>
            </li>
			<button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
		</ul>
		<a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
		</a>
	</div>
	<div class="en-tete"></div>
    <div class="espace-singup"></div>
    <section class="singup">
        <h1>Inscription</h1>
        
        <?php if (isset($_SESSION['inscription_error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_SESSION['inscription_error']); ?>
                <?php unset($_SESSION['inscription_error']); ?>
            </div>
        <?php endif; ?>
        
       <form id="form-inscription" action="inscription.php" method="POST">
            <div id="erreurs" class="error-message"></div>

            <div class="form-group">
                <input type="text" name="nom" id="nom" placeholder="Nom" required value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <input type="text" name="prenom" id="prenom" placeholder="Prénom" required value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Adresse e-mail" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <div class="champ-mdp">
                    <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Mot de passe" required>
					<span class="compteur-mdp" id="compteur-mdp">0</span>
                    <button type="button" class="oeil-bouton" data-cible="mot_de_passe">👁</button>
                </div>
            </div>

            <div class="form-group">
                <div class="champ-mdp">
					<input type="password" name="confirmation_mot_de_passe" id="confirmation_mot_de_passe" placeholder="Confirmation du mot de passe" required>
					<span class="compteur-mdp" id="compteur-confirmation">0</span>
					<button type="button" class="oeil-bouton" data-cible="confirmation_mot_de_passe">👁</button>
				</div>
			</div>

			<div class="form-group">
				<input type="tel" name="tel" id="tel" placeholder="Téléphone" value="<?php echo htmlspecialchars($_POST['tel'] ?? ''); ?>">
			</div>

			<div class="form-group">
				<input type="text" name="adresse" id="adresse" placeholder="Adresse" value="<?php echo htmlspecialchars($_POST['adresse'] ?? ''); ?>">
			</div>
            </div>

            <button type="submit" class="submit">S'inscrire</button>
        </form>
            
        <div class="dejainscrit">
            <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
        </div>
    </section>
    <div class="espace-bottom-singup"></div>
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
