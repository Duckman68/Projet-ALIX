<?php
session_start();

$pp = "../../img/default.png";
$isLoggedIn = false;
$isAdmin = false;

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../../json/utilisateurs.json";
    $data = json_decode(file_get_contents($json_file), true) ?: [];

    foreach ($data['admin'] ?? [] as $admin) {
        if ($admin['email'] === $_SESSION['email']) {
            $isAdmin = true;
            if (!empty($admin['pp'])) {
                $pp = $admin['pp'];
            }
            break;
        }
    }
    if (!$isAdmin) {
        foreach ($data['user'] ?? [] as $user) {
            if ($user['email'] === $_SESSION['email']) {
                if (!empty($user['pp'])) {
                    $pp = $user['pp'];
                }
                break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>T-shirt A.L.I.X.</title>
    <link id="theme-style" href="../../css/style_nuit.css" rel="stylesheet">
    <script src="../../js/theme.js" defer></script>
</head>
<body>

<div class="top">
    <div class="topleft">
        <a href="../index.php">
            <video class="logo" autoplay muted>
                <source src="../../img/Logo-3-[cut](site).mp4" type="video/mp4">
            </video>
        </a>
    </div>
    <ul>
        <li><a href="../aboutus.php">À propos</a></li><li>|</li>
        <li><a href="../voyager.php">Voyager</a></li>
        <?php if (!$isLoggedIn): ?>
            <li>|</li><li><a href="../login.php">Connexion</a></li><li>|</li>
            <li><a href="../sign-up.php">Inscription</a></li>
        <?php else: ?>
            <?php if ($isAdmin): ?>
                <li>|</li><li><a href="../admin.php">Admin</a></li>
            <?php endif; ?>
        <?php endif; ?>
        <li>|</li>
        <li><a href="../panier.php" title="Panier">🛒</a></li>
        <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
    </ul>
    <a href="../user.php">
        <img src="<?= htmlspecialchars($pp) ?>" alt="Profil" class="pfp" onerror="this.src='../../img/default.png'">
    </a>
</div>

<div class="en-tete"></div>
    <div class="container">
        <img src="/img/produit3.jpg" alt="T-shirt A.L.I.X.">
        <div class="details">
            <h1>T-shirt A.L.I.X.</h1>
            <div class="price">Prix : 24,99 €</div>
            <p>
                Affirme ton style interstellaire avec le T-shirt A.L.I.X. Confortable, léger et résistant, il est conçu pour accompagner tes explorations sur Terre ou dans les étoiles. Brodé avec le logo du projet, c’est le vêtement idéal pour les voyageurs de demain.
            </p>
            <a href="../boutique.php" class="btn-retour">← Retour à la boutique</a>
        </div>
    </div>
</body>
</html>