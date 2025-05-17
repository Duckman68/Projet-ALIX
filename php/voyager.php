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

$voyages_data = json_decode(file_get_contents("../json/voyage.json"), true);
$voyages_all = $voyages_data['voyages'] ?? [];

$searchQuery = strtolower($_GET['search'] ?? '');
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$voyagesParPage = 10;

$voyagesFiltres = array_filter($voyages_all, function ($voyage) use ($searchQuery) {
    return $searchQuery === '' || stripos($voyage['titre'], $searchQuery) !== false;
});

$totalVoyages = count($voyagesFiltres);
$totalPages = max(1, ceil($totalVoyages / $voyagesParPage));
$debut = ($page - 1) * $voyagesParPage;
$voyages = array_slice($voyagesFiltres, $debut, $voyagesParPage);
?>

<!DOCTYPE html>
<html>
<head>
    <title>A.L.I.X.</title>
    <meta charset="UTF-8">
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" />
    <script src="../js/theme.js" defer></script>
    <script src="../js/voyager.js"></script>
</head>
<body>
    <video class="fond" autoplay loop muted>
        <source src="../img/video2.mp4">
    </video>
    <div class="top">
        <div class="topleft">
            <a href="index.php">
                <video class="logo" autoplay muted>
                    <source src="../img/Logo-3-[cut](site).mp4" type="video/mp4">
                </video>
            </a>
        </div>
        <ul>
            <li><a href="aboutus.php">A propos</a></li>
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
            <button id="theme-switch">Mode jour/nuit</button>
        </ul>
        <a href="user.php">
            <img src="<?= htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>
    
    <div class="en-tete"></div>
    <div class="espace-voyager"></div>

    <section class="flight">
        <form method="get" action="voyager.php" class="search-bar">
            <input type="text" name="search" placeholder="Rechercher une destination..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">Rechercher</button>
        </form>    

        <form id="voyage-form" action="selection_option.php" method="POST">
            <div class="flight-inputs">
                <label for="voyage-select">Sélectionner un voyage :</label>
                <select name="voyage-id" id="voyage-select" required>
                    <option value="">Choisir un voyage</option>
                    <?php foreach ($voyages_data['voyages'] as $voyage): ?>
                        <option value="<?= htmlspecialchars($voyage['id']); ?>">
                            <?= htmlspecialchars($voyage['titre']); ?> (<?= htmlspecialchars($voyage['prix']); ?>€)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Date de départ :
                    <input type="date" name="date-voyage" required>
                </label>
                <label>Date d'arrivée :
                    <input type="date" name="date-arrivee" required>
                </label>

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
            </div>

            <input type="checkbox" id="no-escale" name="no-escale">
            <label for="no-escale">Sans escale</label> 

            <div class="flight-class">
                <button type="button" class="class-btn active" data-class="economy">Economy Class</button>
                <button type="button" class="class-btn" data-class="business">Business Class</button>
                <button type="button" class="class-btn" data-class="first">First Class</button>
                <input type="hidden" name="flight-class" id="flight-class" value="economy">
            </div>

            <input type="hidden" name="adultes" id="adultes-input" value="1">
            <input type="hidden" name="enfants" id="enfants-input" value="0">
            <input type="hidden" name="bebes" id="bebes-input" value="0">

            <button type="submit" class="submit">Choisir les options</button>
        </form>
    </section>

    <div class="results-container">
        <h2>Voyages disponibles</h2>
        <?php if (empty($voyages)): ?>
            <p class="no-result">Aucune destination ne correspond à votre recherche.</p>
        <?php else: ?>
            <?php foreach ($voyages as $voyage): ?>
                <?php
                    $imagePath = "../php/map/images/" . strtolower(str_replace(' ', '_', $voyage['titre'])) . ".png";
                    if (!file_exists($imagePath)) {
                        $imagePath = "../php/map/images/Mars.png";
                    }
                ?>
                <div class="result">
                    <img src="<?= $imagePath ?>" alt="planète" class="carte-planete">
                    <h3><?= htmlspecialchars($voyage['titre']) ?></h3>
                    <p><?= nl2br(htmlspecialchars(substr($voyage['contenu_complet'], 0, 400))) ?>...</p>
                    <form method="post" action="selection_option.php">
                        <input type="hidden" name="voyage-id" value="<?= htmlspecialchars($voyage['id']) ?>">
                        <input type="hidden" name="date-voyage" value="<?= date('Y-m-d') ?>">
                        <input type="hidden" name="date-arrivee" value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                        <input type="hidden" name="adultes" value="1">
                        <input type="hidden" name="enfants" value="0">
                        <input type="hidden" name="bebes" value="0">
                        <input type="hidden" name="flight-class" value="economy">
                        <button type="submit" class="search-btn">Voir ce voyage</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <!-- PAGINATION -->
            <div class="pagination" style="text-align:center;margin-top:20px;">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php
                        $params = $_GET;
                        $params['page'] = $i;
                        $url = 'voyager.php?' . http_build_query($params);
                    ?>
                    <a href="<?= htmlspecialchars($url) ?>"
                       style="display:inline-block;margin:0 5px;padding:6px 12px;border-radius:4px;
                              background-color:<?= $i === $page ? '#666' : '#444' ?>;
                              color:white;text-decoration:none;">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="espace-bottom-voyager"></div>
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
