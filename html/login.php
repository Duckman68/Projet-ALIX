<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8">
	<title>A.L.I.X.</title>
	<link href="../css/style.css" rel="stylesheet" />
</head>
<body>
    <video class="fond" autoplay loop muted>
		<source src="../img/video.mp4">
	</video>
	<div class="top">
		<div class="topleft">
			<img class="logo" src="../img/logo.png">
			<a href="index.html"><h1>A.L.I.X.</h1></a>
		</div>
		<ul>
			<li><a href="aboutus.html">A propos</a></li>
			<li>|</li>
			<li><a href="voyager.html">Voyager</a></li>
			<li>|</li>
			<li><a href="sign-up.php">Inscription</a></li>
			<li>|</li>
			<li><a href="admin.html">Bouton admin temporaire</a></li>
		</ul>
		<a href="user.php">
    			<img src="../img/icon.jpg" alt="Profil" class="pfp">
		</a>
	</div>
	<div class="en-tete"></div>
    <div class="espace-login"></div>
    <section class="login">
        <h1>Connexion</h1>
        <?php
        // Affiche les messages d'erreur
        if (isset($_SESSION['erreur'])) {
            echo '<div class="erreur">' . $_SESSION['erreur'] . '</div>';
            unset($_SESSION['erreur']); // Supprime le message d'erreur après l'affichage
        }
        ?>
        <form action="login_form.php" method="POST">
            <div class="input-box">
                <input type="email" name="email" placeholder="Adresse e-mail" required>
            </div>

            <div class="input-box">
                <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox"> Se souvenir de moi</label>
                <a href="#">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="login">Se connecter</button>
        </form>

        <div class="register-link">
            <p>Pas de compte ? <a href="sign-up.php">Inscription</a></p>
        </div>
    </section>
	<div class="espace-bottom-login"></div>
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