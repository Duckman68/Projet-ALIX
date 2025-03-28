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
	<link href="../css/style.css" rel="stylesheet" />
</head>
<body>
    <video class="fond" autoplay loop muted>
		<source src="../img/video.mp4">
	</video>
	<div class="top">
		<div class="topleft">
			<a href="index.html">
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
			<li><a href="login.php">Connexion</a></li>
			<li>|</li>
			<li><a href="sign-up.php">Inscription</a></li>
		</ul>
		<a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
		</a>
	</div>
	<div class="en-tete"></div>

    <div class="admin-container">
        <h2>Liste des Utilisateurs</h2>
        <div class="bouton-recherche">
            <button>Tous</button> <button>VIP</button> <button>Membre</button> <button>Banni</button>
        </div>
    </br>
        <div class="admin-recherche">
            <input type="text" id="searchInput" placeholder="Recherche des membres">
			<button onclick="search()">🔍</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Luke Skywalker</td>
                    <td>luke.skywalker@example.com</td>
                    <td>VIP</td>
                    <td><button>Modifier</button></td>
					<td><button>Supprimer</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Spock</td>
                    <td>spock@example.com</td>
                    <td>Membre</td>
                    <td><button>Modifier</button></td>
					<td><button>Supprimer</button></td>
                </tr>
				<tr>
                    <td>3</td>
                    <td>Obi-Wan Kenobi</td>
                    <td>obibikenobi@example.com</td>
                    <td>Banni</td>
                    <td><button>Modifier</button></td>
					<td><button>Supprimer</button></td>
                </tr>
            </tbody>
        </table>
    </div>
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
