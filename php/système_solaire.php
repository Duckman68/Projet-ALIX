<?php
session_start();

$pp = "../img/default.png"; // Image par défaut
$isLoggedIn = false;
$isAdmin = false;

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
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Système Solaire</title>
        <link id="theme-style" rel="stylesheet" href="../css/style_nuit.css">
        <script src="../js/theme.js" defer></script>
    </head>
    <body>
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
        <section class="solar-section">
            <svg id="SolarSystem" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1674 954.05">
                <image href="images/stars.jpg" x="0" y="0" width="1674" height="954.05" preserveAspectRatio="xMidYMid slice"/>   
            <defs>
                <style>
                .cls-1 {
                    fill: #9e005d;
                }

                .cls-2 {
                    fill: red;
                }

                .cls-2, .cls-3, .cls-4 {
                    stroke-miterlimit: 10;
                }

                .cls-2, .cls-4 {
                    stroke: red;
                }

                .cls-5 {
                    fill: aqua;
                }

                .cls-3 {
                    stroke: gray;
                }

                .cls-3, .cls-4 {
                    fill: none;
                }

                .cls-6 {
                    fill: #c1272d;
                }

                .cls-7 {
                    fill: #4d4d4d;
                }

                .cls-8 {
                    fill: blue;
                }

                .cls-9 {
                    fill: #f7931e;
                }

                .cls-10 {
                    fill: #736357;
                }

                .cls-11 {
                    fill: lime;
                }

                .cls-12 {
                    fill: #93867c;
                }

                .cls-13 {
                    fill: url(#Dégradé_sans_nom_461);
                }

                .cls-14 {
                    fill: #fcee21;
                }
                </style>
                <linearGradient id="Dégradé_sans_nom_461" data-name="Dégradé sans nom 461" x1="1131.62" y1="475.38" x2="1252.98" y2="475.38" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#000"/>
                <stop offset=".23" stop-color="#534741"/>
                <stop offset=".42" stop-color="#a67c52"/>
                <stop offset=".6" stop-color="#8c6239"/>
                <stop offset=".78" stop-color="#603813"/>
                <stop offset="1" stop-color="#000"/>
                </linearGradient>

                <pattern id="sunPattern" patternUnits="userSpaceOnUse" width="324" height="324" patternTransform="translate(53.5 310.05)">
                    <image href="images/Sun1.png" width="324" height="330" />
                </pattern>
                <pattern id="saturnPattern" patternUnits="userSpaceOnUse" width="72" height="72" patternTransform="translate(1154 436.55)">
                    <image href="images/saturn without rings.png" width="72" height="72" />
                </pattern>
                <pattern id="mercurePattern" patternUnits="userSpaceOnUse" width="20" height="20" patternTransform="translate(694 462.55)">
                    <image href="images/Mercure.png" width="20" height="20" />
                </pattern>
                <pattern id="venusPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(558 454.55)">
                    <image href="images/Venus.png" width="36" height="36" />
                </pattern>
                <pattern id="terrePattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(630 454.55)">
                    <image href="images/Terre.png" width="36" height="36" />
                </pattern>
                <pattern id="marsPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(702 454.55)">
                    <image href="images/Mars.png" width="36" height="36" />
                </pattern>
                <pattern id="jupiterPattern" patternUnits="userSpaceOnUse" width="106" height="106" patternTransform="translate(877 419.55)">
                    <image href="images/Jupiter.png" width="106" height="106" />
                </pattern>
                <pattern id="uranusPattern" patternUnits="userSpaceOnUse" width="72" height="72" patternTransform="translate(1368.5 436.55)">
                    <image href="images/Uranus.png" width="72" height="72" />
                </pattern>
                <pattern id="neptunePattern" patternUnits="userSpaceOnUse" width="54" height="54" patternTransform="translate(1584.5 445.3)">
                    <image href="images/Neptune.png" width="54" height="54" />
                </pattern>

                <!-- Terre - Lune -->
                <pattern id="earthMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(657 490.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Mars - Lunes -->
                <pattern id="marsMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(729 490.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="marsMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(738 454.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Jupiter - Lunes -->
                <pattern id="jupiterMoon1Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(936 391.55)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="jupiterMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1035 508.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="jupiterMoon3Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1008 472.55)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="jupiterMoon4Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1044 436.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Saturne - Lunes -->
                <pattern id="saturnMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1125 418.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="saturnMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1188 562.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="saturnMoon3Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1233 553.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="saturnMoon4Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1269 517.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="saturnMoon5Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1278 481.55)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="saturnMoon6Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1305 454.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="saturnMoon7Pattern" patternUnits="userSpaceOnUse" width="27" height="27" patternTransform="translate(1215 382.55)">
                    <image href="images/Lune.png" width="27" height="27" />
                </pattern>
                <pattern id="saturnMoon8Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1197 382.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Uranus - Lunes -->
                <pattern id="uranusMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1467 508.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="uranusMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1440 490.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="uranusMoon3Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1458 463.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="uranusMoon4Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1440 436.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Neptune - Lunes -->
                <pattern id="neptuneMoon1Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1611 508.55)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="neptuneMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1665 481.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="neptuneMoon3Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1629 427.55)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
            </defs>
            <g id="NeptuneGroup">
                <circle id="Neptune" class="cls-5" cx="1611.75" cy="472.55" r="27.25" fill="url(#neptunePattern)" style="fill: url(#neptunePattern);"/>
                <circle class="Moon NeptuneMoon" style="--i: 0" cx="1620" cy="517.55" r="9" fill="url(#neptuneMoon1Pattern)" style="fill: url(#neptuneMoon1Pattern);"/>
                <circle class="Moon NeptuneMoon" style="--i: 1" cx="1669.5" cy="486.05" r="4.5" fill="url(#neptuneMoon2Pattern)" style="fill: url(#neptuneMoon2Pattern);"/>
                <circle class="Moon NeptuneMoon" style="--i: 2" cx="1633.5" cy="432.05" r="4.5" fill="url(#neptuneMoon3Pattern)" style="fill: url(#neptuneMoon3Pattern);"/>
              </g>
            <g id="UranusGroup">
                <circle id="Uranus" class="cls-10" cx="1404.5" cy="472.55" r="36" fill="url(#uranusPattern)" style="fill: url(#uranusPattern);"/>
                <circle class="Moon UranusMoon" style="--i: 0" cx="1471.5" cy="513.05" r="4.5" fill="url(#uranusMoon1Pattern)" style="fill: url(#uranusMoon1Pattern);"/>
                <circle class="Moon UranusMoon" style="--i: 1" cx="1444.5" cy="495.05" r="4.5" fill="url(#uranusMoon2Pattern)" style="fill: url(#uranusMoon2Pattern);"/>
                <circle class="Moon UranusMoon" style="--i: 2" cx="1462.5" cy="468.05" r="4.5" fill="url(#uranusMoon3Pattern)" style="fill: url(#uranusMoon3Pattern);"/>
                <circle class="Moon UranusMoon" style="--i: 3" cx="1444.5" cy="441.05" r="4.5" fill="url(#uranusMoon4Pattern)" style="fill: url(#uranusMoon4Pattern);"/>
            </g>
            <g id="SaturnGroup">
                <circle id="Saturne" class="cls-9" cx="1190" cy="472.55" r="36" fill="url(#saturnPattern)" style="fill: url(#saturnPattern);"/>
                <g id="SaturnRings">
                <path id="GigaTrait" class="cls-13" d="m1252.81,459.67c-1.57-4.68-13.64-6.03-30.66-4.24.03.06.05.13.08.19.74.78,1.18,1.81,1.31,2.9.24.5.45,1.01.62,1.52,6.11-.34,10.04.21,10.57,1.79,1.25,3.73-16.88,11.73-40.53,17.87-23.63,6.13-43.8,8.09-45.05,4.36-.45-1.32,1.55-3.17,5.33-5.29-.17-.67-.25-1.37-.32-2.06-.21-.63-.33-1.3-.38-1.99-.12-.4-.2-.81-.23-1.24-14.57,6.44-23.28,13.07-21.75,17.61,2.5,7.46,31.62,6.47,65.04-2.21,33.42-8.67,58.48-21.75,55.98-29.21Z"/>
                <g id="SmallTrait">
                    <path class="cls-12" d="m1153.84,477.2c-1.73,1.24-3.54,2.4-5.18,3.75-1.14.94-2.15,2.11-2.3,3.63-.38,4.06,4.88,3.62,7.56,3.71,9.35.32,18.69-.93,27.82-2.87,9.21-1.95,18.32-4.49,27.32-7.23,8.48-2.59,17.53-5.34,24.91-10.41,1.46-1,2.89-2.21,3.63-3.85.62-1.38.73-3.25-.61-4.25-1.55-1.16-4.12-1.41-5.99-1.65-2.42-.31-4.86-.26-7.28.07-.19.03-.11.32.08.29,3.92-.55,8.23-.37,11.97,1.02,2.86,1.07,2.12,4.11.53,5.97-1.23,1.45-2.92,2.48-4.53,3.44-6.81,4.05-14.57,6.55-22.11,8.88s-15.45,4.52-23.27,6.38-16.09,3.37-24.29,3.83c-2.24.13-4.49.17-6.73.14-1.12-.02-2.25-.06-3.37-.13s-2.4-.03-3.48-.38c-3.16-1.02-1.69-4.55.06-6.1s3.62-2.67,5.43-3.96c.16-.11,0-.37-.15-.26h0Z"/>
                </g>
                <g id="MidTrait">
                    <path class="cls-12" d="m1153.61,475.52c-3.45,2.33-8.07,3.89-9.54,8.2-.55,1.62-.49,3.44.54,4.86s2.79,2.07,4.47,2.37c2.36.41,4.82.31,7.2.25,2.72-.06,5.43-.23,8.14-.49,5.44-.53,10.83-1.42,16.18-2.52,10.64-2.2,21.23-4.98,31.65-8.06,9.38-2.77,19.26-6.22,27.04-12.34,1.55-1.22,3.23-2.91,3.34-5,.1-1.86-1.17-3.29-2.71-4.14-2.17-1.2-4.82-1.65-7.25-1.94-2.96-.37-5.94-.3-8.89.14-.19.03-.11.32.08.29,4.74-.7,9.97-.53,14.5,1.15,2.19.81,4.48,2.52,3.86,5.17-.52,2.23-2.64,3.81-4.41,5.05-7.38,5.13-15.84,8.38-24.39,10.97-8.98,2.72-18.12,5.08-27.26,7.19-9.66,2.24-19.48,3.97-29.41,4.23-3.92.1-12.42.94-12.74-4.85s6.01-7.74,9.74-10.25c.16-.11,0-.37-.15-.26h0Z"/>
                </g>
                <g id="BigTrait">
                    <path class="cls-12" d="m1153.4,474.25c-5.29,2.19-10.25,5.29-14.41,9.24-1.65,1.57-3.48,3.7-3.35,6.14.1,1.88,1.42,3.24,3.07,3.95,2.15.92,4.57.92,6.86.96,3.33.07,6.66.01,9.98-.14,6.34-.3,12.67-1,18.94-2,13.12-2.1,26-5.53,38.63-9.63,6.03-1.95,12.03-4.02,17.86-6.51,5.15-2.2,10.82-4.57,14.99-8.41,1.72-1.59,4.19-4.35,3.93-6.9-.25-2.45-3.27-3.05-5.2-3.52-7.07-1.74-14.4-2.21-21.64-1.45-.19.02-.19.32,0,.3,5.95-.62,11.97-.42,17.86.65,1.4.25,2.78.56,4.16.91s2.88.66,3.85,1.69c2.11,2.25-1.11,6.1-2.76,7.72-3.73,3.66-8.92,5.91-13.63,8.01-5.47,2.43-11.11,4.44-16.79,6.33-22.38,7.44-45.75,13.02-69.47,12.67-2.63-.04-5.6.08-8-1.21-1.42-.77-2.4-2.13-2.36-3.79.05-1.67,1.08-3.19,2.14-4.4,4.02-4.59,9.82-8.01,15.41-10.32.18-.07.1-.36-.08-.29h0Z"/>
                </g>
                </g>
                <circle class="Moon SaturnMoon" style="--i: 0" cx="1129.5" cy="423.05" r="4.5" fill="url(#saturnMoon1Pattern)" style="fill: url(#saturnMoon1Pattern);"/>
                <circle class="Moon SaturnMoon" style="--i: 1" cx="1192.5" cy="567.05" r="4.5" fill="url(#saturnMoon2Pattern)" style="fill: url(#saturnMoon2Pattern);"/>
                <circle class="Moon SaturnMoon" style="--i: 2" cx="1237.5" cy="558.05" r="4.5" fill="url(#saturnMoon3Pattern)" style="fill: url(#saturnMoon3Pattern);"/>
                <circle class="Moon SaturnMoon" style="--i: 3" cx="1273.5" cy="522.05" r="4.5" fill="url(#saturnMoon4Pattern)" style="fill: url(#saturnMoon4Pattern);"/>
                <circle class="Moon SaturnMoon" style="--i: 4" cx="1287" cy="490.55" r="9" fill="url(#saturnMoon5Pattern)" style="fill: url(#saturnMoon5Pattern);"/>
                <circle class="Moon SaturnMoon" style="--i: 5" cx="1309.5" cy="459.05" r="4.5" fill="url(#saturnMoon6Pattern)" style="fill: url(#saturnMoon6Pattern);"/>
                <circle class="Moon SaturnMoon" style="--i: 6" cx="1228.5" cy="396.05" r="13.5" fill="url(#saturnMoon7Pattern)" style="fill: url(#saturnMoon7Pattern);"/>
                <circle class="Moon SaturnMoon" style="--i: 7" cx="1201.5" cy="387.05" r="4.5" fill="url(#saturnMoon8Pattern)" style="fill: url(#saturnMoon8Pattern);"/>
            </g>
            <g id="JupiterGroup">
                <circle id="Jupiter" class="cls-14" cx="930" cy="472.55" r="53" fill="url(#jupiterPattern)" style="fill: url(#jupiterPattern);"/>
                <circle class="Moon JupiterMoon" style="--i: 0" cx="945" cy="400.55" r="9" fill="url(#jupiterMoon1Pattern)" style="fill: url(#jupiterMoon1Pattern);"/>
                <circle class="Moon JupiterMoon" style="--i: 1" cx="1039.5" cy="513.05" r="4.5" fill="url(#jupiterMoon2Pattern)" style="fill: url(#jupiterMoon2Pattern);"/>
                <circle class="Moon JupiterMoon" style="--i: 2" cx="1017" cy="481.55" r="9" fill="url(#jupiterMoon3Pattern)" style="fill: url(#jupiterMoon3Pattern);"/>
                <circle class="Moon JupiterMoon" style="--i: 3" cx="1048.5" cy="441.05" r="4.5" fill="url(#jupiterMoon4Pattern)" style="fill: url(#jupiterMoon4Pattern);"/>
            </g>
            <g id="MarsGroup">
                <circle id="Mars" class="cls-1" cx="720" cy="472.55" r="18" fill="url(#marsPattern)" style="fill: url(#marsPattern);"/>
                <circle class="Moon MarsMoon" style="--i: 0" cx="733.5" cy="495.05" r="4.5" fill="url(#marsMoon1Pattern)" style="fill: url(#marsMoon1Pattern);"/>
                <circle class="Moon MarsMoon" style="--i: 1" cx="742.5" cy="459.05" r="4.5" fill="url(#marsMoon2Pattern)" style="fill: url(#marsMoon2Pattern);"/>
            </g>              
            <g id="TerreGroup">
                <circle id="Terre" class="cls-8" cx="648" cy="472.55" r="18" fill="url(#terrePattern)" style="fill: url(#terrePattern);"/>
                <circle class="Moon EarthMoon" style="--i: 0" cx="661.5" cy="495.05" r="4.5" fill="url(#earthMoonPattern)" style="fill: url(#earthMoonPattern);"/>
            </g>              
            <circle id="Venus" class="cls-6" cx="576" cy="472.55" r="18" fill="url(#venusPattern)" style="fill: url(#venusPattern);"/>
            <circle id="Mercure" class="cls-11" cx="504" cy="472.55" r="10" fill="url(#mercurePattern)" style="fill: url(#mercurePattern);"/>
            <g id="SunGroup">
                <circle id="Sun" class="cls-2" cx="215.5" cy="472.05" r="162" fill="url(#sunPattern)" style="fill: url(#sunPattern);"/>
                <circle id="SunRing1" class="cls-4 SunRing1" cx="216.5" cy="473.05" r="216"/>
                <circle id="SunRing1_2" class="cls-4 SunRing1_2" cx="216.5" cy="473.05" r="216"/>
                <circle id="SunRing1_3" class="cls-4 SunRing1_3" cx="216.5" cy="473.05" r="216"/>
                <g id="AsteroidBelt" transform="translate(0,0)">
                    <path id="SunRing2" class="SunRing2" d="M216,4.55c304.93-38.24,564.59,200.04,567,468,2.44,270.9-258.55,515.4-567,477" />
                </g>
            </g>
            </svg>

            <div class="sidebar">
                <h2>Système Solaire</h2>
                <ul class="planet-list">
                    <li data-planet="soleil">Soleil</li>
                    <li data-planet="mercure">Mercure</li>
                    <li data-planet="venus">Vénus</li>
                    <li data-planet="terre">Terre</li>
                    <li data-planet="mars">Mars</li>
                    <li data-planet="jupiter">Jupiter</li>
                    <li data-planet="saturne">Saturne</li>
                    <li data-planet="uranus">Uranus</li>
                    <li data-planet="neptune">Neptune</li>
                </ul>
            </div>
            
            <!-- Popup d'information -->
            <div class="overlay"></div>
            
            <div class="popup" id="popup">
                <button class="popup-close">&times;</button>
                <h3 id="popup-title">Planète</h3>
                <div id="popup-content"></div>
            </div>
        </section>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const planetItems = document.querySelectorAll(".planet-list li");
                const popup = document.getElementById("popup");
                const popupTitle = document.getElementById("popup-title");
                const popupContent = document.getElementById("popup-content");
                const overlay = document.querySelector(".overlay");
                const closeBtn = document.querySelector(".popup-close");
                const allSvgElements = Array.from(document.querySelectorAll('[class^="cls-"], .Moon'));

                const planetsData = {
                    soleil: {
                        nom: "Soleil",
                        svgClass: ["cls-2", "cls-4"],
                        description: "L'étoile centrale de notre système solaire.",
                        diametre: "1 392 700 km",
                        distance: "Centre",
                        temperature: "5 500 °C",
                        composition: "Hydrogène, Hélium",
                        color: "#FFA500",
                        image: "images/sun.jpg"
                    },
                    mercure: {
                        nom: "Mercure",
                        svgClass: ["cls-11"],
                        description: "La plus proche du Soleil.",
                        diametre: "4 879 km",
                        distance: "57,9M km",
                        temperature: "-173°C à 427°C",
                        composition: "Fer, Roche",
                        color: "#A9A9A9",
                        image: "images/mercury.jpg"
                    },
                    venus: {
                        nom: "Vénus",
                        svgClass: ["cls-6"],
                        description: "Planète chaude à l'atmosphère dense.",
                        diametre: "12 104 km",
                        distance: "108M km",
                        temperature: "462°C",
                        composition: "CO2",
                        color: "#E6B87F",
                        image: "images/venus.jpg"
                    },
                    terre: {
                        nom: "Terre",
                        svgClass: ["cls-8"],
                        description: "Notre planète bleue.",
                        diametre: "12 742 km",
                        distance: "149,6M km",
                        temperature: "-88°C à 58°C",
                        composition: "Eau, Roche, Oxygène",
                        color: "#4B92DB",
                        image: "images/Terre.png"
                    },
                    mars: {
                        nom: "Mars",
                        svgClass: ["cls-1"],
                        description: "La planète rouge.",
                        diametre: "6 779 km",
                        distance: "227M km",
                        temperature: "-153°C à 20°C",
                        composition: "Fer, Roche",
                        color: "#E27B58",
                        image: "images/mars.jpg"
                    },
                    jupiter: {
                        nom: "Jupiter",
                        svgClass: ["cls-14"],
                        description: "La plus grande.",
                        diametre: "139 820 km",
                        distance: "778M km",
                        temperature: "-145°C",
                        composition: "Gaz",
                        color: "#E4BE7E",
                        image: "images/jupiter.jpg"
                    },
                    saturne: {
                        nom: "Saturne",
                        svgClass: ["cls-9", "cls-12", "cls-13"],
                        description: "Avec ses anneaux iconiques.",
                        diametre: "116 460 km",
                        distance: "1,4B km",
                        temperature: "-178°C",
                        composition: "Gaz, Glace",
                        color: "#EAC782",
                        image: "images/saturn.jpg"
                    },
                    uranus: {
                        nom: "Uranus",
                        svgClass: ["cls-10"],
                        description: "Planète inclinée.",
                        diametre: "50 724 km",
                        distance: "2,9B km",
                        temperature: "-224°C",
                        composition: "Glace, Méthane",
                        color: "#ADD8E6",
                        image: "images/uranus.jpg"
                    },
                    neptune: {
                        nom: "Neptune",
                        svgClass: ["cls-5"],
                        description: "Froide et bleue.",
                        diametre: "49 244 km",
                        distance: "4,5B km",
                        temperature: "-218°C",
                        composition: "Glace, Gaz",
                        color: "#2A52BE",
                        image: "images/neptune.jpg"
                    }
                };


                // Ajouter data-planet dans le SVG
                Object.entries(planetsData).forEach(([key, planet]) => {
                    planet.svgClass.forEach(cls => {
                        document.querySelectorAll(`.${cls}`).forEach(el => {
                            el.setAttribute("data-planet", key);
                        });
                    });
                });

                function highlightPlanet(name) {
                const p = planetsData[name];
                allSvgElements.forEach(el => {
                    el.classList.add("planet-dimmed");
                    el.classList.remove("planet-highlight");
                });
                
                if (!p) return;
                p.svgClass.forEach(cls => {
                    document.querySelectorAll(`.${cls}`).forEach(el => {
                        el.classList.add("planet-highlight");
                        el.classList.remove("planet-dimmed");
                    });
                });
                }

                function resetPlanets() {
                    allSvgElements.forEach(el => {
                        el.classList.remove("planet-highlight", "planet-dimmed");
                    });
                }

                function showPopup(name) {
                    const p = planetsData[name];
                    if (!p) return;
                    popupTitle.textContent = p.nom;
                    popupContent.innerHTML = `
                        <div class="popup-content-wrapper">
                            <div class="popup-planet-visual">
                                <div class="popup-planet-icon" style="background-color:${p.color}; background-image: url('${p.image}'); box-shadow: 0 0 20px ${p.color};"></div>
                            </div>
                            <div class="popup-info">
                                <p><strong>Description:</strong> ${p.description}</p>
                                <p><strong>Diamètre:</strong> ${p.diametre}</p>
                                <p><strong>Distance:</strong> ${p.distance}</p>
                                <p><strong>Température:</strong> ${p.temperature}</p>
                                <p><strong>Composition:</strong> ${p.composition}</p>
                                ${p.nom.toLowerCase().includes("soleil") ? "" : `<p><button class="popup-go" onclick="window.location.href='voyager.php?planete=${encodeURIComponent(p.nom)}'">Voir les voyages</button></p>`}
                            </div>
                        </div>`;
                    popup.style.display = "block";
                    overlay.style.display = "block";
                    highlightPlanet(name);
                }

                planetItems.forEach(item => {
                    item.addEventListener("mouseenter", () => highlightPlanet(item.dataset.planet));
                    item.addEventListener("mouseleave", resetPlanets);
                    item.addEventListener("click", () => showPopup(item.dataset.planet));
                });

                allSvgElements.forEach(el => {
                    if (el.dataset.planet) {
                        el.addEventListener("mouseenter", () => highlightPlanet(el.dataset.planet));
                        el.addEventListener("mouseleave", resetPlanets);
                        el.addEventListener("click", () => showPopup(el.dataset.planet));
                    }
                });

                closeBtn.addEventListener("click", () => {
                    popup.style.display = "none";
                    overlay.style.display = "none";
                    resetPlanets();
                });

                overlay.addEventListener("click", () => {
                    popup.style.display = "none";
                    overlay.style.display = "none";
                    resetPlanets();
                });
            });
        </script>
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