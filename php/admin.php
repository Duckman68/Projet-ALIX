<?php
session_start();

$pp = "../img/default.png";
$isLoggedIn = false;
$isAdmin = false;

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);

    if ($data !== null) {
        $email = $_SESSION['email'];
        
        foreach ($data["admin"] as $admin) {
            if ($admin["email"] === $email) {
                $isAdmin = true;
                if (!empty($admin["pp"])) {
                    $pp = $admin["pp"];
                }
                break;
            }
        }
        
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

if (!$isAdmin) {
    header("Location: index.php");
    exit();
}

$users = [];
if (isset($data["user"])) {
    $users = $data["user"];
}
?>

<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8">
	<title>A.L.I.X.</title>
	<link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" /><!---->
	<script src="../js/theme.js" defer></script><!---->
	<script src="../js/admin.js" defer></script>
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

    <div class="admin-container">
		<h2>Liste des Utilisateurs</h2>
		<div class="bouton-recherche">
			<button data-filter="all">Tous</button> 
			<button data-filter="vip">VIP</button> 
			<button data-filter="membre">Membre</button> 
			<button data-filter="banni">Banni</button>
		</div>
		<br>
		<div class="admin-recherche">
			<input type="text" id="search-input" placeholder="Recherche des membres">
			<button id="search-button">🔍</button>
		</div>

		<table>
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Email</th>
					<th>Statut</th>
					<th>Date d'inscription</th>
					<th colspan="2">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($users as $index => $user): ?>
				<tr data-role="<?php echo htmlspecialchars($user['role']); ?>">
					<td><?php echo htmlspecialchars($user['nom']); ?></td>
					<td><?php echo htmlspecialchars($user['prenom']); ?></td>
					<td><?php echo htmlspecialchars($user['email']); ?></td>
					<td>
						<form method="post" action="update_role.php" style="display:inline;">
							<input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
							<select name="new_role" class="select-role" >
								<option value="vip" <?php echo $user['role'] === 'vip' ? 'selected' : ''; ?>>VIP</option>
								<option value="membre" <?php echo $user['role'] === 'membre' ? 'selected' : ''; ?>>Membre</option>
								<option value="banni" <?php echo $user['role'] === 'banni' ? 'selected' : ''; ?>>Banni</option>
							</select>
						</form>
					</td>
					<td><?php echo htmlspecialchars($user['sign-date'] ?? 'N/A'); ?></td>
					<td>
						<form method="post" action="delete_user.php" style="display:inline;">
							<input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
							<button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	<div class="espace-admin">
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
