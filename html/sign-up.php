<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $host = 'localhost'; // Adresse du serveur MySQL
    $dbname = 'site_web'; // Nom de la base de données
    $username = 'root'; // Nom d'utilisateur MySQL
    $password = ''; // Mot de passe MySQL

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'];

    // Validation des données
    if ($mot_de_passe !== $confirmation_mot_de_passe) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Hachage du mot de passe
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insertion des données dans la base de données
        try {
            $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':mot_de_passe' => $mot_de_passe_hash
            ]);

            $succes = "Inscription réussie !";
        } catch (PDOException $e) {
            $erreur = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
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
			<li><a href="login_form.html">Connexion</a></li>
			<li>|</li>
			<li><a href="admin.html">Bouton admin temporaire</a></li>
		</ul>
		<a href="user.html">
    			<img src="../img/icon.jpg" alt="Profil" class="pfp">
		</a>
	</div>
	<div class="en-tete"></div>
    <div class="espace-singup"></div>
    <section class="singup">
        <h1>Inscription</h1>
        <form action="inscription.php" method="POST">
            <div class="form-group">
                <input type="text" name="nom" placeholder="Nom" required>
            </div>

            <div class="form-group">
                <input type="text" name="prenom" placeholder="Prénom" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Adresse e-mail" required>
            </div>

            <div class="form-group">
                <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            </div>

            <div class="form-group">
                <input type="password" name="confirmation_mot_de_passe" placeholder="Confirmation du mot de passe" required>
            </div>

            <button type="submit" class="submit">S'inscrire</button>
        </form>
            
        <div class="dejainscrit">
            <p>Déjà un compte ? <a href="login_form.html">Se connecter</a></p>
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
