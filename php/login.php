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

$json_file = "../json/utilisateurs.json";
$json = file_get_contents($json_file);
$data = json_decode($json, true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];
    $login_date = date('d-m-Y H:i');

    // Vérification pour les utilisateurs normaux
    foreach ($data["user"] as &$user) {
        if ($user["email"] === $email && $user["mot_de_passe"] === $password) {
            $_SESSION['email'] = $email;
            $user["login-date"] = $login_date;
            
            file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
            $redirectPage = $_SESSION['redirect_after_login'] ?? 'user.php';
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirectPage");
            exit();
        }
    }

    // Vérification pour les admins
    foreach ($data["admin"] as &$admin) {
        if ($admin["email"] === $email && $admin["mot_de_passe"] === $password) {
            $_SESSION['email'] = $email;
            $admin["login-date"] = $login_date;
            
            file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
            $redirectPage = $_SESSION['redirect_after_login'] ?? 'user.php';
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirectPage");
            exit();
        }
    }
    
    $_SESSION['erreur'] = "Email ou mot de passe incorrect.";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8">
	<title>A.L.I.X.</title>
	<link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" /><!---->
	<script src="../js/theme.js" defer></script><!---->
    <script src="../js/validation_connexion.js" defer></script>

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
			<li><a href="sign-up.php">Inscription</a></li>
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
    <div class="espace-login"></div>
    <section class="login">
        <h1>Connexion</h1>
		<?php
    	if (isset($_SESSION['erreur'])) {
        	echo '<div class="erreur">' . $_SESSION['erreur'] . '</div>';
        	unset($_SESSION['erreur']);
    	}
    	?>
        <form id="form-connexion" action="login.php" method="POST">
            <div id="erreurs" class="error-message"></div>

            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Adresse e-mail" required>
            </div>

            <div class="form-group">
                <div class="champ-mdp">
                    <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Mot de passe" required>
                    <button type="button" class="oeil-bouton" data-cible="mot_de_passe">👁</button>
                </div>
            </div>

            <button type="submit" class="submit">Connexion</button>
        </form>

        <div class="register-link">
            <p>Pas de compte ? <a href="sign-up.php">Inscription</a></p>
        </div>
    </section>
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
