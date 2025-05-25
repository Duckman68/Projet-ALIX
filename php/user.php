<?php
session_start();
$isLoggedIn = isset($_SESSION['email']);

// Déconnexion
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

// Chargement des données
$json_file = "../json/utilisateurs.json";
$data = json_decode(file_get_contents($json_file), true);
if ($data === null) die("Erreur JSON");

// Initialisation
$email_session = $_SESSION['email'];
$isAdmin = false;
$pp = "../img/default.png";
$utilisateur = null;

// Recherche de l'utilisateur
foreach ($data["admin"] as &$admin) {
    if ($admin["email"] === $email_session) {
        $utilisateur = &$admin;
        $isAdmin = true;
        break;
    }
}
if (!$utilisateur) {
    foreach ($data["user"] as &$user) {
        if ($user["email"] === $email_session) {
            $utilisateur = &$user;
            break;
        }
    }
}

// Si aucun utilisateur trouvé
if (!$utilisateur) {
    die("Utilisateur introuvable.");
}

// Initialisation des valeurs
$nom = $utilisateur["nom"] ?? "";
$prenom = $utilisateur["prenom"] ?? "";
$email = $utilisateur["email"] ?? "";
$phone = $utilisateur["phone"] ?? "";
$address = $utilisateur["address"] ?? "";
$pp = $utilisateur["pp"] ?? $pp;

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'] ?? $nom;
    $prenom = $_POST['prenom'] ?? $prenom;
    $email = $_POST['email'] ?? $email;
    $phone = $_POST['phone'] ?? $phone;
    $address = $_POST['address'] ?? $address;

    $utilisateur["nom"] = $nom;
    $utilisateur["prenom"] = $prenom;
    $utilisateur["email"] = $email;
    $utilisateur["phone"] = $phone;
    $utilisateur["address"] = $address;

    $_SESSION['email'] = $email;

    file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: user.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>  
    <meta charset="UTF-8">
    <title>A.L.I.X.</title>
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" /><!---->
	<script src="../js/theme.js" defer></script><!---->
    <script src="../js/modification_profil.js" defer></script>
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

    <div class="espace-profil">
        <section class="profil-form-login">
            <input type="image" src="<?php echo htmlspecialchars($pp); ?>" class="profil-img">
            <h2>Mon Profil</h2>
            
            <form method="POST" action="user.php" id="form-profil">
                <div class="form-group champ-modifiable">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" disabled required>
                    <button type="button" class="btn-editer" data-champ="nom">✏️</button>
                    <button type="button" class="btn-valider" data-champ="nom" style="display: none;">✅</button>
                    <button type="button" class="btn-annuler" data-champ="nom" style="display: none;">❌</button>
                </div>

                <div class="form-group champ-modifiable">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" disabled required>
                    <button type="button" class="btn-editer" data-champ="prenom">✏️</button>
                    <button type="button" class="btn-valider" data-champ="prenom" style="display: none;">✅</button>
                    <button type="button" class="btn-annuler" data-champ="prenom" style="display: none;">❌</button>
                </div>

                <div class="form-group champ-modifiable">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" disabled required>
                    <button type="button" class="btn-editer" data-champ="email">✏️</button>
                    <button type="button" class="btn-valider" data-champ="email" style="display: none;">✅</button>
                    <button type="button" class="btn-annuler" data-champ="email" style="display: none;">❌</button>
                </div>

                <div class="form-group champ-modifiable">
                    <label for="phone">Tél :</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" disabled>
                    <button type="button" class="btn-editer" data-champ="phone">✏️</button>
                    <button type="button" class="btn-valider" data-champ="phone" style="display: none;">✅</button>
                    <button type="button" class="btn-annuler" data-champ="phone" style="display: none;">❌</button>
                </div>

                <div class="form-group champ-modifiable">
                    <label for="address">Adresse :</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" disabled>
                    <button type="button" class="btn-editer" data-champ="address">✏️</button>
                    <button type="button" class="btn-valider" data-champ="address" style="display: none;">✅</button>
                    <button type="button" class="btn-annuler" data-champ="address" style="display: none;">❌</button>
                </div>

                <button type="submit" class="btn-submit" id="bouton-soumettre" style="display: none;">Soumettre les modifications</button>
                <a href="?logout=1" class="btn-logout">Se déconnecter</a>
            </form>
        </section>
    </div>

    <div class="historique-achat">
        <h2>Voyages achetés</h2>
        <table>
            <tr>
                <th>Destination</th>
                <th>Étapes</th>
                <th>Prix</th>
                <th>Détail</th>
            </tr>
            <?php if (!empty($utilisateur['voyage']['achetes'])): ?>
                <?php foreach ($utilisateur['voyage']['achetes'] as $v): ?>
                    <tr>
                        <td><?= htmlspecialchars($v['titre']) ?></td>
                        <td>
                            <?php
                            $etapes = array_map(function($opt) {
                                return htmlspecialchars($opt['etape']);
                            }, $v['options'] ?? []);
                            echo implode(", ", $etapes);
                            ?>
                        </td>
                        <td>
                            <?php
                            $base = $v['prix'] * $v['passagers']['adultes'] + $v['prix'] * 0.7 * $v['passagers']['enfants'];
                            $total_options = 0;
                            foreach ($v['options'] ?? [] as $opt) {
                                $total_options += $opt['prix'] * $v['passagers']['adultes'] + $opt['prix'] * 0.7 * $v['passagers']['enfants'];
                            }
                            echo number_format($base + $total_options, 2, '.', '') . " €";
                            ?>
                        </td>
                        <td>
                            <a href="details_voyage.php?id=<?= urlencode($v['voyage_id']) ?>">Voir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">Aucun voyage acheté.</td></tr>
            <?php endif; ?>
        </table>
    </div>


    <div class="espace-bottom-login"></div>
	<footer class="site-footer">
		<div class="footer-grid">
			<div class="footer-links">
				<h3>Liens rapides</h3>
				<ul>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="voyager.php">Voyager</a></li>
					<li><a href="aboutus.php">À propos</a></li>
					<li><a href="Panier.php">Panier</a></li>
				</ul>
				<div class="footer-social">
					<a href="https://www.linkedin.com/in/alix-exp%C3%A9rience-60b037367/" target="_blank" rel="noopener">
					<img src="../img/link.png" alt="LinkedIn">
					</a>
					<a href="https://www.instagram.com/alix_experience?igsh=MTV4dDV2YWpsczdqNQ==" target="_blank" rel="noopener">
					<img src="../img/insta.jpeg" alt="Instagram">
					</a>
					<a href="https://www.facebook.com/profile.php?id=61576688187239" target="_blank" rel="noopener">
					<img src="../img/facebook.png" alt="Facebook">
					</a>
					<a href="https://x.com/alix_experience" target="_blank" rel="noopener">
					<img src="../img/X.jpeg" alt="X">
					</a>
				</div>
			</div>

			<div class="footer-contact">
				<h3>Contact</h3>
				<p>
					<strong>Mail :</strong>
					<a href="mailto:contact@alix.com">contact@alix.com</a>
				</p>
				<p><strong>Téléphone :</strong> +33 1 23 45 67 89</p>
				<p>
					<strong>Adresse :</strong><br>
					<a
					href="https://www.google.com/maps/search/?api=1&query=Avenue+des+Champs-%C3%89lys%C3%A9es,+75008+Paris"
					target="_blank"
					rel="noopener"
					>
					Avenue des Champs-Élysées, 75008 Paris
					</a>
				</p>
			</div>

			<div class="footer-newsletter">
				<h3>Newsletter</h3>
				<p>Inscrivez-vous pour recevoir nos offres exclusives :</p>
				<form class="newsletter-form" action="#" method="post">
					<input
					type="email"
					name="email"
					placeholder="Votre email"
					required
					>
					<button type="submit">S’abonner</button>
				</form>
			</div>
		</div>

		<div class="footer-bottom">
			<p class="footer-credits">Nassim | Atahan | Romain | Gabin</p>
			<p>© <?= date('Y') ?> A.L.I.X. — Tous droits réservés.</p>
			<button
			class="back-to-top"
			aria-label="Retour en haut"
			onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
			></button>
		</div>
	</footer>
</body>
</html>


