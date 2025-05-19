<?php
session_start();

$isLoggedIn = false;
$isAdmin = false;
$pp = "../img/default.png";

// Connexion active
if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);
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
            if ($user["email"] === $email && !empty($user["pp"])) {
                $pp = $user["pp"];
                break;
            }
        }
    }
}

// Initialisation du panier
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}
$panier = $_SESSION['panier'];

// Suppression d’un élément
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    $index = (int) $_POST['index'];
    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
        $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer
    }
    header("Location: panier.php");
    exit();
}

// Paiement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'payer') {
    if ($isLoggedIn && isset($panier[0])) {
        $_SESSION['current_voyage'] = $panier[0];
        header("Location: recapitulatif.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link id="theme-style" rel="stylesheet" href="../css/style_nuit.css">
    <script src="../js/theme.js" defer></script>
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
            <li><a href="panier.php" title="Voir le panier" class="panier-icon">🛒</a></li>
            <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
        </ul>
        <a href="user.php">
            <img src="<?= htmlspecialchars($pp) ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>

    <div class="en-tete"></div>
    <div class="espace"></div>
    <div class="espace-voyager"></div>

    <section class="panier">
        <h2>Mon Panier</h2>

        <?php if (empty($panier)) : ?>
            <div class="panier-vide">🛒 Votre panier est vide.</div>
        <?php else: ?>
            <?php $prix_total = 0; ?>
            <?php foreach ($panier as $index => $voyage): ?>
                <?php
                    $prix_total += $voyage['prix'];
                    if (!empty($voyage['options'])) {
                        foreach ($voyage['options'] as $opt) {
                            $prix_total += $opt['prix'];
                        }
                    }
                ?>
                <div class="panier-item">
                    <h3><?= htmlspecialchars($voyage['titre']) ?></h3>
                    <p>📅 Dates : <?= htmlspecialchars($voyage['dates']['depart']) ?> → <?= htmlspecialchars($voyage['dates']['arrivee']) ?></p>
                    <p>🧳 Classe : <?= htmlspecialchars($voyage['classe']) ?> <?= $voyage['sans_escale'] ? '(Sans escale)' : '' ?></p>
                    <p>👨‍👩‍👧 Passagers : Adultes <?= $voyage['passagers']['adultes'] ?>, Enfants <?= $voyage['passagers']['enfants'] ?>, Bébés <?= $voyage['passagers']['bebes'] ?></p>

                    <?php if (!empty($voyage['options'])): ?>
                        <p>🔧 Options :</p>
                        <ul>
                            <?php foreach ($voyage['options'] as $opt): ?>
                                <li><?= $opt['etape'] ?> : <?= $opt['nom'] ?> (+<?= $opt['prix'] ?>€)</li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <form method="POST" action="panier.php">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <input type="hidden" name="action" value="supprimer">
                        <button type="submit" class="btn-supprimer">🗑 Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <div class="panier-total">
                <h3>Total : <?= $prix_total ?> €</h3>
                <form method="POST" action="panier.php">
                    <input type="hidden" name="action" value="payer">
                    <button class="btn-ajouter-panier">💳 Payer</button>
                </form>
            </div>
        <?php endif; ?>
    </section>

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
