<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$voyagesData = json_decode(file_get_contents('../json/voyage.json'), true);
$etapesData = json_decode(file_get_contents('../json/etapes.json'), true);
$optionsData = json_decode(file_get_contents('../json/options.json'), true);

if (
    ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['voyage-id']))
    && !isset($_GET['edit'], $_SESSION['edition_voyage'])
) {
    header("Location: voyager.php");
    exit();
}


if (isset($_GET['edit']) && isset($_SESSION['edition_voyage'])) {
    $edition = true;
    $voyage_data = $_SESSION['edition_voyage'];
    $voyage_id = $voyage_data['voyage_id']; // on récupère l'id du voyage
    $passagers = $voyage_data['passagers'];
    $options_preselectionnees = $voyage_data['options'];
    $selected_options = [];

    foreach ($options_preselectionnees as $opt) {
        $etape = $opt['etape'];
        $nom = $opt['nom'];
        $selected_options[$etape][] = $nom;
    }
} else {
    $edition = false;
    $voyage_id = $_POST['voyage-id'];
}


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

    foreach ($_POST['options'] as $etape_id => $option_ids) {
        foreach ($option_ids as $option_id) {
            foreach ($etapesData['etapes'] as $etape) {
                if ($etape['id'] === $etape_id) {
                    foreach ($optionsData['options'] as $opt) {
                        if ($opt['id'] === $option_id) {
                            $_SESSION['current_voyage']['options'][] = [
                                'etape' => $etape['titre'],
                                'nom'   => implode(', ', $opt['activités']),
                                'prix'  => $opt['prix_par_personne']
                            ];
                            break;
                        }
                    }
                    break;
                }
            }
        }
    }

    if ($edition) {
    // Vider tout le panier et ne garder que le voyage modifié
        $_SESSION['panier'] = [$_SESSION['current_voyage']];
        unset($_SESSION['edition_voyage'], $_SESSION['edition_index']);
    }
    else {
        $_SESSION['panier'][] = $_SESSION['current_voyage'];
    }
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
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <meta charset="UTF-8">
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" />
    <script src="../js/theme.js" defer></script>
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
                    <span id="resume"><?= $edition ? "{$passagers['adultes']} Adulte(s) · {$passagers['enfants']} Enfant(s) · {$passagers['bebes']} Bébé(s)" : "1 Adulte · 0 Enfant · 0 Bébé" ?></span>
                </button>
                <div class="menu-selecteur" id="menu-selecteur">
                    <div class="ligne">
                        <label>Adultes</label>
                        <div class="controle">
                            <button type="button" id="adultes-moins">−</button>
                            <span id="adultes"><?= $edition ? $passagers['adultes'] : 1 ?></span>
                            <button type="button" id="adultes-plus">+</button>
                        </div>
                    </div>
                    <div class="ligne">
                        <label>Enfants</label>
                        <div class="controle">
                            <button type="button" id="enfants-moins">−</button>
                            <span id="enfants"><?= $edition ? $passagers['enfants'] : 0 ?></span>
                            <button type="button" id="enfants-plus">+</button>
                        </div>
                    </div>
                    <div class="ligne">
                        <label>Bébé</label>
                        <div class="controle">
                            <button type="button" id="bebe-moins">−</button>
                            <span id="bebe"><?= $edition ? $passagers['bebes'] : 0 ?></span>
                            <button type="button" id="bebe-plus">+</button>
                        </div>
                    </div>
                    <button type="button" id="terminer-btn">Terminer</button>
                </div>
            </div>

            <input type="hidden" name="voyage-id" value="<?= htmlspecialchars($voyage_id); ?>">
            <input type="hidden" name="date-voyage" value="<?= htmlspecialchars($_POST['date-voyage']); ?>">
            <input type="hidden" name="date-arrivee" value="<?= htmlspecialchars($_POST['date-arrivee']); ?>">
            <input type="hidden" name="adultes" id="adultes-input" value="<?= $edition ? $passagers['adultes'] : 1 ?>">
            <input type="hidden" name="enfants" id="enfants-input" value="<?= $edition ? $passagers['enfants'] : 0 ?>">
            <input type="hidden" name="bebes" id="bebes-input" value="<?= $edition ? $passagers['bebes'] : 0 ?>">

            <?php foreach ($voyage['etapes'] as $etape_id): ?>
                <?php foreach ($etapesData['etapes'] as $etape): ?>
                    <?php if ($etape['id'] === $etape_id): ?>
                        <div class="etape-container">
                            <h2><?= htmlspecialchars($etape['titre']) ?></h2>
                            <div class="options-container">
                                <?php foreach ($etape['options'] as $opt_id): ?>
                                    <?php foreach ($optionsData['options'] as $opt): ?>
                                        <?php if ($opt['id'] === $opt_id): ?>
                                            <?php
                                            $etape_titre = $etape['titre'];
                                            $nom_opt = implode(', ', $opt['activités']);
                                            $is_checked = $edition && isset($selected_options[$etape_titre]) && in_array($nom_opt, $selected_options[$etape_titre]);
                                            ?>
                                            <label class="option-card">
                                                <input type="checkbox" name="options[<?= $etape_id ?>][]" value="<?= $opt_id ?>" <?= $is_checked ? 'checked' : '' ?>>
                                                <div class="option-content">
                                                    <h3><?= htmlspecialchars($nom_opt) ?></h3>
                                                    <p><?= htmlspecialchars(implode(',', $opt['descriptif'])) ?></p>
                                                    <p><?= htmlspecialchars($opt['prix_par_personne']) ?> € / personne</p>
                                                </div>
                                            </label>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <div class="form-actions">
                <div id="prix-total" style="font-size: 20px; font-weight: bold; margin: 20px 0;">
                    Prix total : <span id="prix-valeur">0</span> €
                </div>
                <button type="submit" class="btn-envoyer">Ajouter au panier et voir le récapitulatif</button>
            </div>
        </form>
    </div>
</body>
</html>
