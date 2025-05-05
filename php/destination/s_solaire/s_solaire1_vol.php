
<?php
session_start();

$pp = "../../../img/default.png";
$isLoggedIn = false;
$isAdmin = false; // Nouvelle variable pour vérifier le statut admin

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../../../json/utilisateurs.json";
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
<html lang="en">
    <head>
        <title>A.L.I.X.</title>
        <meta charset="UTF-8">
        <link href="../../../css/style.css" rel="stylesheet" />
    
    </head>
<body>
	<div class="fondpage">
   <body>
	<video class="fond" autoplay loop muted>
		<source src="../../../img/video.mp4">
	</video>
	<div class="topv2">
		<div class="topleft">
			<a href="../../index.php">
				<video class="logo" autoplay muted>
					<source src="../../../img/Logo-3-[cut](site).mp4" type="video/mp4">
				</video>
			</a>
		</div>
		<ul>
			<li><a href="../aboutus.php">A propos</a></li>
			<li>|</li>
			<li><a href="../voyager.php">Voyager</a></li>
			<?php if (!$isLoggedIn): ?>
				<li>|</li>
				<li><a href="../login.php">Connexion</a></li>
				<li>|</li>
				<li><a href="../sign-up.php">Inscription</a></li>
			<?php else: ?>
				<?php if ($isAdmin): ?>
					<li>|</li>
					<li><a href="admin.php">Admin</a></li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
		<a href="../user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../../img/default.png'">
		</a>
	</div>
	<div class="option">
		<a href="s_solaire1_activite.php" class="option_bouton">Activité</a> 
		<a href="s_solaire1.php" class="option_bouton">Hébergement</a> 
		<a href="s_solaire1_vol.php" class="option_bouton">Vol</a> 
		<a href="s_solaire1_location.php" class="option_bouton">Location</a> 
	</div>
	
	<img class="imgplanete" src= "../../../img/mercure2.jpg">

	<div class="recherchev2">
		<table class="recherche">
			<tr>
				<td class="recherche">
					<label for="depart">Date de départ :</label>
					<input type="date" id="depart" name="depart">
				</td>
				<td class="recherche">
					<label for="arrivee">Date d'arrivée :</label>
					<input type="date" id="arrivee" name="arrivee">
				</td>

			</tr>
			<tr>
				<table class="nbr-passager">
					<tr>
						<td class="passager">
							<div>
								<label>Adultes :</label>
								<button onclick="changeValue('adultes', -1)">-</button>
								<span id="adultes">1</span>
								<button onclick="changeValue('adultes', 1)">+</button> 
							</div>
						</td>
						<td class="passager">
							<div class="passager">
								<label>Enfants :</label>
								<button onclick="changeValue('enfants', -1)">-</button>
								<span id="enfants">0</span>
								<button onclick="changeValue('enfants', 1)">+</button> 
							</div>
						</td>
						<td class="passager">
							<div class="passager">
								<label>Bébés :</label>
								<button onclick="changeValue('bebes', -1)">-</button>
								<span id="bebes">0</span>
								<button onclick="changeValue('bebes', 1)">+</button> 
							</div>
						</td>
					</tr>
				</table>
			</tr>
		</table>
	</div>
	<h1>Mercure</h1>
	
	<div class="logement-container">
		<label class="selection-logement">
			<input type="radio" name="selection" value="option1" checked>
			<div class="button-content">
				<img src="../../img/s_m_logement1.jpg" alt="Option 1">
				<span>Option 1</span>
			</div>
		</label>
		
		<label class="selection-logement">
			<input type="radio" name="selection" value="option2">
			<div class="button-content">
				<img src="../../img/s_m_logement2.jpg" alt="Option 2">
				<span>Option 2</span>
			</div>
		</label>
		
		<label class="selection-logement">
			<input type="radio" name="selection" value="option3">
			<div class="button-content">
				<img src="../../img/s_m_logement3.jpg" alt="Option 3">
				<span>Option 3</span>
			</div>
		</label>
	</div>

	<button type="submit" class="btn-envoyer">Envoyer</button>










    <div class="bottom">
		<h1>Crédits</h1>
		<div class="textebot">
			<h2>Nassim</h2>
			<h2>Atahan</h2>
			<h2>Romain</h2>
			<h2>Gabin</h2>
		</div>
	</div>
	</div>
	



</body>
</html>
