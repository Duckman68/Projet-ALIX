<?php
session_start();

// Gestion de la déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Redirection si non connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$json_file = "../json/utilisateurs.json";
$json = file_get_contents($json_file);
$data = json_decode($json, true);

if ($data === null) {
    die("Erreur lors de la lecture du JSON");
}

// Initialisation avec valeurs par défaut
$nom = $prenom = $phone = $address = "";
$email = $_SESSION['email'];
$pp = "../img/default.png";
$isAdmin = false;
$isLoggedIn = true;

// Recherche dans les admins d'abord
foreach ($data["admin"] as $admin) {
    if ($admin["email"] === $email) {
        $nom = $admin["nom"];
        $prenom = $admin["prenom"];
        $phone = $admin["phone"];
        $address = $admin["address"];
        $pp = $admin["pp"];
        $isAdmin = true;
        break;
    }
}

// Si pas admin, recherche dans les users
if (empty($nom)) {
    foreach ($data["user"] as $user) {
        if ($user["email"] === $email) {
            $nom = $user["nom"];
            $prenom = $user["prenom"];
            $phone = $user["phone"];
            $address = $user["address"];
            $pp = $user["pp"] ?? $pp;
            break;
        }
    }
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_complet = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $nomPrenom = explode(' ', trim($nom_complet), 2);
    $nom = $nomPrenom[0];
    $prenom = $nomPrenom[1];

    foreach ($data["user"] as &$user) {
        if ($user["email"] === $_SESSION['email']) {
            $user["nom"] = $nom;
            $user["prenom"] = $prenom;
            $user["phone"] = $phone;
            $user["address"] = $address;
            $user["email"] = $email;
            $_SESSION['email'] = $email;
            break;
        }
    }
    
    if ($isAdmin) {
        foreach ($data["admin"] as &$admin) {
            if ($admin["email"] === $_SESSION['email']) {
                $admin["nom"] = $nom;
                $admin["prenom"] = $prenom;
                $admin["phone"] = $phone;
                $admin["address"] = $address;
                $admin["email"] = $email;
                break;
            }
        }
    }

    file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: user.php");
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
			<button id="theme-switch">Mode jour/nuit</button><!---->
        </ul>
        <a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
		</a>
    </div>
    <div class="en-tete"></div>

    <div class="espace-profil">
        <section class="profil-form-login">
            <input type="image" src="<?php echo htmlspecialchars($pp); ?>" class="profil-img">
            <h2>Mon Profil</h2>
            
            <form method="POST" action="user.php">
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($nom . ' ' . $prenom); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Tél :</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
                <div class="form-group">
                    <label for="address">Adresse :</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">
                </div>
                <button type="submit" class="btn-submit">Mettre à jour</button>
                <a href="?logout=1" class="btn-logout">Se déconnecter</a>
            </form>
        </section>
    </div>

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


