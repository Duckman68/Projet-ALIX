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
                    <button type="button" class="oeil-bouton" data-cible="mot_de_passe">👁</button>
                </div>
            </div>

            <div class="form-group">
                <div class="champ-mdp">
                    <input type="password" name="confirmation_mot_de_passe" id="confirmation_mot_de_passe" placeholder="Confirmation du mot de passe" required>
                    <button type="button" class="oeil-bouton" data-cible="confirmation_mot_de_passe">👁</button>
                </div>
            </div>

            <button type="submit" class="submit">S'inscrire</button>
        </form>
            
        <div class="dejainscrit">
            <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
        </div>
    </section>
    <div class="espace-bottom-singup"></div>
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
