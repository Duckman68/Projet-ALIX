<?php
session_start();


$json_file = "../json/utilisateurs.json";
$json = file_get_contents($json_file);
$data = json_decode($json, true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    foreach ($data["user"] as $user) {
        if ($user["email"] === $email && $user["mot_de_passe"] === $password) {
            $_SESSION['email'] = $email;
            header("Location: user.php");
            exit();
        }
    }

	foreach ($data["admin"] as $admin) {
        if ($admin["email"] === $email && $admin["mot_de_passe"] === $password) {
            $_SESSION['email'] = $email;
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