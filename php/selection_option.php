
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['voyage-id'])) {
    header("Location: voyager.php");
    exit();
}

$voyagesData = json_decode(file_get_contents('../json/voyage.json'), true);
$etapesData = json_decode(file_get_contents('../json/etapes.json'), true);
$optionsData = json_decode(file_get_contents('../json/options.json'), true);

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

if (isset($_POST['options'])) {
    $_SESSION['current_voyage'] = [
        'voyage_id' => $voyage_id,
        'titre' => $voyage['titre'],
        'dates' => [
            'depart' => $_POST['date-voyage'],
            'arrivee' => $_POST['date-arrivee'],
            'duree' => (new DateTime($_POST['date-voyage']))->diff(new DateTime($_POST['date-arrivee']))->days
        ],
        'passagers' => [
            'adultes' => $_POST['adultes'] ?? 1,
            'enfants' => $_POST['enfants'] ?? 0,
            'bebes' => $_POST['bebes'] ?? 0
        ],
        'classe' => $_POST['flight-class'] ?? 'economy',
        'sans_escale' => isset($_POST['no-escale']),
        'prix' => $voyage['prix'],
        'options' => []
    ];

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
</head>
<body>
    <div class="fondpage">
        <video class="fond" autoplay loop muted>
            <source src="../../../img/video.mp4">
        </video>

        <div class="top">
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
			    <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
            </ul>
            <a href="../user.php"><img src="<?= htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../../img/default.png'"></a>
        </div>

        <h1><?= htmlspecialchars($voyage['titre']) ?></h1>

        <form method="POST">
            <input type="hidden" name="voyage-id" value="<?= htmlspecialchars($voyage_id); ?>">
            <input type="hidden" name="date-voyage" value="<?= htmlspecialchars($_POST['date-voyage']); ?>">
            <input type="hidden" name="date-arrivee" value="<?= htmlspecialchars($_POST['date-arrivee']); ?>">
            <input type="hidden" name="adultes" value="<?= htmlspecialchars($_POST['adultes'] ?? 1); ?>">
            <input type="hidden" name="enfants" value="<?= htmlspecialchars($_POST['enfants'] ?? 0); ?>">
            <input type="hidden" name="bebes" value="<?= htmlspecialchars($_POST['bebes'] ?? 0); ?>">
            <input type="hidden" name="flight-class" value="<?= htmlspecialchars($_POST['flight-class'] ?? 'economy'); ?>">
            <input type="hidden" name="no-escale" value="<?= isset($_POST['no-escale']) ? '1' : '0'; ?>">

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
                <button type="submit" class="btn-envoyer">Voir le récapitulatif</button>
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
