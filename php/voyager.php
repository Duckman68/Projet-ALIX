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
?>

<!DOCTYPE html>
<html>
<head>
    <title>A.L.I.X.</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" />
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
        </ul>
        <a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
        </a>
    </div>
    
    <div class="en-tete"></div>
    <div class="espace-voyager"></div>
    
    <section class="flight">    
        <form id="voyage-form" action="selection_option.php" method="POST">
            <div class="flight-inputs">
                <label for="voyage-select">Sélectionner un voyage :</label>
                <select name="voyage-id" id="voyage-select" required>
                    <option value="">Choisir un voyage</option>
                    <?php foreach ($voyages_data['voyages'] as $voyage): ?>
                        <option value="<?php echo htmlspecialchars($voyage['id']); ?>">
                            <?php echo htmlspecialchars($voyage['titre']); ?> (<?php echo htmlspecialchars($voyage['prix']); ?>€)
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
            
            <button type="submit" class="submit">Choisir les options</button>
        </form>
    </section>
    <div class="espace-bottom-voyager"></div>
    <div class="systemes">
        <table class="systemes">
            <tr>
                <td class="voy-solaire"><a href="#"><h1>Système Solaire</h1></a></td>
                <td class="voy-innuendo"><a href="#"><h1>Système Innuendo</h1></a></td>
                <td class="voy-tou-doom"><a href="#"><h1>Système Tou-Doom</h1></a></td>
                <td class="voy-ikea"><a href="#"><h1>Système IKEA</h1></a></td>
            </tr>
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