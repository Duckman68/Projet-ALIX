<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$voyagesData = json_decode(file_get_contents('../json/voyage.json'), true);
$etapesData = json_decode(file_get_contents('../json/etapes.json'), true);
$optionsData = json_decode(file_get_contents('../json/options.json'), true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['voyage-id'])) {
    header("Location: voyager.php");
    exit();
}

$voyage_id = $_POST['voyage-id'];
$voyage = null;
foreach ($voyagesData['voyages'] as $v) {
    if ($v['id'] === $voyage_id) {
        $voyage = $v;
        break;
    }
}
if (!$voyage) {
    echo "<p>Voyage non trouvé.</p>";
    exit();
}

if (isset($_POST['adultes'])) {
    $_SESSION['current_voyage'] = [
        'voyage_id' => $voyage_id,
        'titre' => $voyage['titre'],
        'dates' => [
            'depart' => $_POST['date-voyage'],
            'arrivee' => $_POST['date-arrivee'],
            'duree' => (new DateTime($_POST['date-voyage']))->diff(new DateTime($_POST['date-arrivee']))->days
        ],
        'passagers' => [
            'adultes' => $_POST['adultes'],
            'enfants' => $_POST['enfants'],
            'bebes' => $_POST['bebes']
        ],
        'classe' => $_POST['flight-class'] ?? 'economy',
        'sans_escale' => isset($_POST['no-escale']),
        'prix' => $voyage['prix'],
        'options' => []
    ];

    if (isset($_POST['options'])) {
        foreach ($_POST['options'] as $etape_id => $option_id) {
            foreach ($etapesData['etapes'] as $etape) {
                if ($etape['id'] === $etape_id) {
                    foreach ($optionsData['options'] as $opt) {
                        if ($opt['id'] === $option_id) {
                            $_SESSION['current_voyage']['options'][] = [
                                'etape' => $etape['titre'],
                                'nom' => implode(', ', $opt['activités']),
                                'prix' => $opt['prix_par_personne']
                            ];
                            break;
                        }
                    }
                    break;
                }
            }
        }
    }

    $_SESSION['panier'][] = $_SESSION['current_voyage'];
    header("Location: recapitulatif.php");
    exit();
}

$pp = "../../img/default.png";
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>A.L.I.X. - Options</title>
    <meta charset="UTF-8">
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" /><!---->
	<script src="../js/theme.js" defer></script><!---->
    <script src="../js/option.js" defer></script>
</head>
<body data-prix-base="<?= htmlspecialchars($voyage['prix']) ?>">
    <div class="fondpage">

        <div class="topv2">
            <div class="topleft">
                <a href="index.php">
                    <video id="logo-video" class="logo" autoplay muted><source src="../../../img/Logo-3-[cut](site).mp4" type="video/mp4"></video>
                </a>
            </div>
            <ul>
                <li><a href="aboutus.php">A propos</a></li>
                <li>|</li>
                <li><a href="voyager.php">Voyager</a></li>
                <?php if (!$isLoggedIn): ?>
                    <li>|</li><li><a href="login.php">Connexion</a></li><li>|</li><li><a href="sign-up.php">Inscription</a></li>
                <?php else: ?>
                    <?php if ($isAdmin): ?><li>|</li><li><a href="admin.php">Admin</a></li><?php endif; ?>
                <?php endif; ?>
                <li>|</li>
                <li>
                    <a href="panier.php" title="Voir le panier" class="panier-icon">🛒</a>
                </li>
			    <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
            </ul>
            <a href="../user.php"><img src="<?= htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../../img/default.png'"></a>
        </div>

        <h1 style="font-size: 50px;"><?= htmlspecialchars($voyage['titre']) ?></h1>

        <form method="POST">
                <div class="selecteur-container">
                    <button class="selecteur-bouton" type="button">
                        <span id="resume">1 Adulte · 0 Enfants · 0 Bébés</span>
                    </button>
                    <div class="menu-selecteur" id="menu-selecteur">
                        <div class="ligne">
                            <label>Adultes</label>
                            <div class="controle">
                                <button type="button" id="adultes-moins">−</button>
                                <span id="adultes">1</span>
                                <button type="button" id="adultes-plus">+</button>
                            </div>
                        </div>
                        <div class="ligne">
                            <label>Enfants</label>
                            <div class="controle">
                                <button type="button" id="enfants-moins">−</button>
                                <span id="enfants">0</span>
                                <button type="button" id="enfants-plus">+</button>
                            </div>
                        </div>
                        <div class="ligne">
                            <label>Bébé</label>
                            <div class="controle">
                                <button type="button" id="bebe-moins">−</button>
                                <span id="bebe">0</span>
                                <button type="button" id="bebe-plus">+</button>
                            </div>
                        </div>
                        <button type="button" id="terminer-btn">Terminer</button>
                    </div>
                </div>


            <input type="hidden" name="voyage-id" value="<?= htmlspecialchars($voyage_id); ?>">
            <input type="hidden" name="date-voyage" value="<?= htmlspecialchars($_POST['date-voyage']); ?>">
            <input type="hidden" name="date-arrivee" value="<?= htmlspecialchars($_POST['date-arrivee']); ?>">
            <input type="hidden" name="adultes" id="adultes-input" value="1">
            <input type="hidden" name="enfants" id="enfants-input" value="0">
            <input type="hidden" name="bebes" id="bebes-input" value="0">

            <?php foreach ($voyage['etapes'] as $etape_id): ?>
                <?php
                foreach ($etapesData['etapes'] as $etape) {
                    if ($etape['id'] === $etape_id):
                ?>
                <div class="etape-container">
                    <h2><?= htmlspecialchars($etape['titre']) ?></h2>
                    <div class="options-container">
                        <?php foreach ($etape['options'] as $opt_id): ?>
                            <?php
                            foreach ($optionsData['options'] as $opt) {
                                if ($opt['id'] === $opt_id): ?>
                                <label class="option-card">
                                    <input type="checkbox" name="options[<?= $etape_id ?>]" value="<?= $opt_id ?>">
                                    <div class="option-content">
                                        <h3><?= htmlspecialchars(implode(', ', $opt['activités'])) ?></h3>
                                        <p><?= htmlspecialchars(implode(',',$opt['descriptif'])) ?></p>
                                        <p><?= htmlspecialchars($opt['prix_par_personne']) ?> € / personne</p>
                                    </div>
                                </label>
                            <?php endif; } ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; } ?>
            <?php endforeach; ?>

            <div class="form-actions">
                <div id="prix-total" style="font-size: 20px; font-weight: bold; margin: 20px 0;">
                    Prix total : <span id="prix-valeur">0</span> €
                </div>
                <button type="submit" class="btn-envoyer">Ajouter au panier et voir le récapitulatif</button>
            </div>
        </form>

        <div class="bottom">
            <h1>Crédits</h1>
            <div class="textebot">
                <h2>Nassim</h2><h2>Atahan</h2><h2>Romain</h2><h2>Gabin</h2>
            </div>
        </div>
    </div>
</body>
</html>
