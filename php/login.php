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
            
            header("Location: user.php");
            exit();
        }
    }

    // Vérification pour les admins
    foreach ($data["admin"] as &$admin) {
        if ($admin["email"] === $email && $admin["mot_de_passe"] === $password) {
            $_SESSION['email'] = $email;
            $admin["login-date"] = $login_date;
            
            file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
            
            header("Location: user.php");
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
</head>
<body>
    <video class="fond" autoplay loop muted>
		<source src="../img/video.mp4">
	</video>
	<div class="top">
		<div class="topleft">
            <a href="index.php">
				<video class="logo" autoplay muted>
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
			<button id="theme-switch">Mode jour/nuit</button><!---->
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
        <form action="login.php" method="POST">
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
