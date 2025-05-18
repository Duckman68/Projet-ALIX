<?php
session_start();

$pp = "../img/default.png";
$isLoggedIn = false;
$isAdmin = false; // Nouvelle variable pour vérifier le statut admin

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);

    if ($data !== null) {
        $email = $_SESSION['email'];
        
        // Vérification dans la section admin
        foreach ($data["admin"] as $admin) {
            if ($admin["email"] === $email) {
                $isAdmin = true;
                if (!empty($admin["pp"])) {
                    $pp = $admin["pp"];
                }
                break;
            }
        }
        
        // Si pas admin, vérification dans la section user
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
				<video id="logo-video" class="logo" autoplay muted>
					<source src="../img/Logo-3-[cut](site).mp4" type="video/mp4">
				</video>
			</a>
		</div>
		<ul>
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
	<div class="espace-about"></div>
	<section class="about">
		<h1>A propos</h1>
	
		<h2>A.L.I.X. - Astral Light Intergalactic Expeditions</h2>
		<p>Fondée en 2399 par la scientifique Elara Nyx, A.L.I.X. a révolutionné les voyages intergalactiques grâce à la découverte de l'Astralise, une technologie permettant de voyager plus vite que la lumière. L'agence offre des expéditions vers des mondes lointains, des civilisations oubliées et des destinations inexplorées à travers la galaxie.
	
			Les vaisseaux de A.L.I.X. utilisent des moteurs "Astral Light" pour propulser des navires à des vitesses incroyables, garantissant des voyages sûrs et rapides. Basée dans l'Astral Nexus, une station orbitale, l'agence est dirigée par des capitaines expérimentés et des experts en exploration, qui accompagnent les voyageurs dans des aventures uniques, de la découverte de nouvelles formes de vie à des croisières spatiales luxueuses.
	
			A.L.I.X. ne se contente pas de proposer des voyages, mais incite les voyageurs à explorer les mystères de l'univers, forgeant des liens avec d'autres civilisations et repoussant sans cesse les limites de la connaissance humaine. Son slogan : "Le cosmos vous attend. Embarquez avec A.L.I.X. et voyagez là où aucun autre n'ose aller."
	
			L'agence est un symbole de l'exploration et de la découverte pacifique, attirant des voyageurs de tous horizons, tout en affrontant des rivaux et des dangers cosmiques.
		</p>
		
	</section>
	<div class="espace-bottom-about"></div>
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
