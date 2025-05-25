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
        <section class="innuendo-zone">
          <svg id="SolarSystem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1627 433">
            <image href="images/stars.jpg" x="0" y="0" width="1627" height="433" preserveAspectRatio="xMidYMid slice"/> 
          <defs>
              <style>
                .cls-1 {
                  fill: #9e005d;
                }

                .cls-2 {
                  fill: red;
                }

                .cls-2, .cls-3 {
                  stroke: red;
                  stroke-miterlimit: 10;
                }

                .cls-4 {
                  fill: aqua;
                }

                .cls-5 {
                  fill: #c1272d;
                }

                .cls-6 {
                  fill: #4d4d4d;
                }

                .cls-7 {
                  fill: blue;
                }

                .cls-3 {
                  fill: none;
                }

                .cls-8 {
                  fill: #f7931e;
                }

                .cls-9 {
                  fill: #736357;
                }

                .cls-10 {
                  fill: lime;
                }

                .cls-11 {
                  fill: #fcee21;
                }
                .cls-ring {
                    fill: none;
                    stroke: red;
                    stroke-width: 2;
                }
              </style>
                <pattern id="sunPattern" patternUnits="userSpaceOnUse" width="432" height="432" patternTransform="translate(25 410)">
                    <image href="images/Sun1.png" width="432" height="432" />
                </pattern>
                <pattern id="solidaysPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(486 198)">
                    <image href="images/saturn without rings.png" width="36" height="36" />
                </pattern>
                <pattern id="welovegreenPattern" patternUnits="userSpaceOnUse" width="20" height="20" patternTransform="translate(566 206)">
                    <image href="images/Mercure.png" width="20" height="20" />
                </pattern>
                <pattern id="hellfestPattern" patternUnits="userSpaceOnUse" width="106" height="106" patternTransform="translate(661 162)">
                    <image href="images/Venus.png" width="106" height="106" />
                </pattern>
                <pattern id="ardentePattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(832 197.97)">
                    <image href="images/Terre.png" width="36" height="36" />
                </pattern>
                <pattern id="tomorrowlandPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(928.76 197.97)">
                    <image href="images/Mars.png" width="36" height="36" />
                </pattern>
                <pattern id="deltaPattern" patternUnits="userSpaceOnUse" width="20" height="20" patternTransform="translate(1044 205)">
                    <image href="images/Jupiter.png" width="20" height="20" />
                </pattern>
                <pattern id="lhumaPattern" patternUnits="userSpaceOnUse" width="72" height="72" patternTransform="translate(1147 180)">
                    <image href="images/Uranus.png" width="72" height="72" />
                </pattern>
                <pattern id="lollapaloozaPattern" patternUnits="userSpaceOnUse" width="72" height="72" patternTransform="translate(1361.5 180)">
                    <image href="images/Neptune.png" width="72" height="72" />
                </pattern>
                <pattern id="viellecharuePattern" patternUnits="userSpaceOnUse" width="54.5" height="54.5" patternTransform="translate(1537.5 188.75)">
                    <image href="images/Neptune.png" width="54.5" height="54.5" />
                </pattern>
                
                <!-- Solidays - Lune -->
                <pattern id="solidaysMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(513 234)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Welovegreen - Lunes -->
                <pattern id="welovegreenMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(557 186.39)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="welovegreenMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(575.5 195.39)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Hellfest - Lunes -->
                <pattern id="hellfestMoon1Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(742.67 128.28)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="hellfestMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(733.67 148.5)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="hellfestMoon3Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(758 283.72)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                
                <!-- Ardente - Lunes -->
                <pattern id="ardenteMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(868 197.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="ardenteMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(859 233.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="ardenteMoon3Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(850 261)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Tomorrowland - Lunes -->
                <pattern id="tomorrowlanMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(955.76 233.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Lhuma - Lunes -->
                <pattern id="lhumaMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1208 126)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="lhumaMoon2Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1271 225)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="lhumaMoon3Pattern" patternUnits="userSpaceOnUse" width="27" height="27" patternTransform="translate(1262 261)">
                    <image href="images/Lune.png" width="27" height="27" />
                </pattern>
                
                <!-- Lollapalooza - Lunes -->
                <pattern id="lollapaloozaMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1460 252)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Veillecharue - Lunes -->
                <pattern id="veillecharueMoon3Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1564 252)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="veillecharueMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1618 225)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="veillecharueMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1582 171)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
            </defs>
            <g id="VeillecharueGroup">
              <circle id="Veillecharue" class="cls-4" cx="1564.75" cy="216" r="27.25" fill="url(#viellecharuePattern)" style="fill: url(#viellecharuePattern);"/>
              <circle id="VeillecharueMoon3" class="Moon VeillecharueMoon" style="--i: 0" cx="1573" cy="261" r="9" fill="url(#veillecharueMoon3Pattern)" style="fill: url(#veillecharueMoon3Pattern);"/>
              <circle id="VeillecharueMoon2" class="Moon VeillecharueMoon" style="--i: 1" cx="1622.5" cy="229.5" r="4.5" fill="url(#veillecharueMoon2Pattern)" style="fill: url(#veillecharueMoon2Pattern);"/>
              <circle id="VeillecharueMoon1" class="Moon VeillecharueMoon" style="--i: 2" cx="1586.5" cy="175.5" r="4.5" fill="url(#veillecharueMoon1Pattern)" style="fill: url(#veillecharueMoon1Pattern);"/>
            </g>
            <g id="LollapaloozaGroup">
              <circle id="Lollapalooza" class="cls-9" cx="1397.5" cy="216" r="36" fill="url(#lollapaloozaPattern)" style="fill: url(#lollapaloozaPattern);"/>
              <circle id="LollapaloozaMoon4" class="Moon LollapaloozaMoon" style="--i: 0" cx="1464.5" cy="256.5" r="4.5" fill="url(#lollapaloozaMoonPattern)" style="fill: url(#lollapaloozaMoonPattern);"/>
            </g>
            <g id="LhumaGroup">
              <circle id="Lhuma" class="cls-8" cx="1183" cy="216" r="36" fill="url(#lhumaPattern)" style="fill: url(#lhumaPattern);"/>
              <circle id="LhumaMoon5" class="Moon LhumaMoon" style="--i: 0" cx="1266.5" cy="265.5" r="4.5" fill="url(#lhumaMoon1Pattern)" style="fill: url(#lhumaMoon1Pattern);"/>
              <circle id="LhumaMoon4" class="Moon LhumaMoon" style="--i: 1" cx="1280" cy="234" r="9" fill="url(#lhumaMoon2Pattern)" style="fill: url(#lhumaMoon2Pattern);"/>
              <circle id="LhumaMoon2" class="Moon LhumaMoon" style="--i: 2" cx="1221.5" cy="139.5" r="13.5" fill="url(#lhumaMoon3Pattern)" style="fill: url(#lhumaMoon3Pattern);"/>
            </g>
            <circle id="Delta" class="cls-11" cx="1054" cy="215" r="10" fill="url(#deltaPattern)" style="fill: url(#deltaPattern);"/>
            <g id="TomorrowlandGroup">
              <circle id="Tomorrowland" class="cls-1" cx="946.76" cy="215.97" r="18" fill="url(#tomorrowlandPattern)" style="fill: url(#tomorrowlandPattern);"/>
              <circle id="MoonTomorrowland2" class="Moon TomorrowlandMoon" style="--i: 0" cx="960.26" cy="238.47" r="4.5" fill="url(#tomorrowlanMoon1Pattern)" style="fill: url(#tomorrowlanMoon1Pattern);"/>
            </g>
            <g id="ArdenteGroup">
              <circle id="Ardente" class="cls-1" cx="850" cy="215.97" r="18" fill="url(#ardentePattern)" style="fill: url(#ardentePattern);"/>
              <circle id="MoonArdente3" class="Moon ArdenteMoon" style="--i: 0" cx="854.5" cy="265.5" r="4.5" fill="url(#ardenteMoon1Pattern)" style="fill: url(#ardenteMoon1Pattern);"/>
              <circle id="MoonArdente2" class="Moon ArdenteMoon" style="--i: 1" cx="863.5" cy="238.47" r="4.5" fill="url(#ardenteMoon2Pattern)" style="fill: url(#ardenteMoon2Pattern);"/>
              <circle id="MoonArdente1" class="Moon ArdenteMoon" style="--i: 2" cx="872.5" cy="202.47" r="4.5" fill="url(#ardenteMoon3Pattern)" style="fill: url(#ardenteMoon3Pattern);"/>
            </g>
            <g id="HellfestGroup">
              <circle id="Hellfest" class="cls-7" cx="714" cy="215" r="53" fill="url(#hellfestPattern)" style="fill: url(#hellfestPattern);"/>
              <circle id="HellfestMoon3" class="Moon HellfestMoon" style="--i: 0" cx="767" cy="292.72" r="9" fill="url(#hellfestMoon3Pattern)" style="fill: url(#hellfestMoon3Pattern);"/>
              <circle id="HellfestMoon2" class="Moon HellfestMoon" style="--i: 1" cx="738.17" cy="153" r="4.5" fill="url(#hellfestMoon2Pattern)" style="fill: url(#hellfestMoon2Pattern);"/>
              <circle id="HellfestMoon1" class="Moon HellfestMoon" style="--i: 2" cx="751.67" cy="137.28" r="9" fill="url(#hellfestMoon1Pattern)" style="fill: url(#hellfestMoon1Pattern);"/>
            </g>
            <g id="We_Love_GreenGroup">
              <circle id="We_Love_Green" class="cls-5" cx="576" cy="216" r="10" fill="url(#welovegreenPattern)" style="fill: url(#welovegreenPattern);"/>
              <circle id="We_Love_GreenMoon2" class="Moon WelovegreenMoon" style="--i: 0" cx="580" cy="199.89" r="4.5" fill="url(#welovegreenMoon2Pattern)" style="fill: url(#welovegreenMoon2Pattern);"/>
              <circle id="We_Love_GreenMoon1" class="Moon WelovegreenMoon" style="--i: 1" cx="561.5" cy="190.89" r="4.5" fill="url(#welovegreenMoon1Pattern)" style="fill: url(#welovegreenMoon1Pattern);"/>
            </g>
            <g id="SolidaysGroup">
              <circle id="Solidays" class="cls-10" cx="504" cy="216" r="18" fill="url(#solidaysPattern)" style="fill: url(#solidaysPattern);"/>
              <circle id="SollidaysMoon" class="Moon SolidaysMoon" style="--i: 0" cx="517.5" cy="238.5" r="4.5" fill="url(#solidaysMoonPattern)" style="fill: url(#solidaysMoonPattern);"/>
            </g>
            <g id="SunGroup">
              <circle id="Sun" class="cls-2" cx="215.5" cy="215.5" r="162" fill="url(#sunPattern)" style="fill: url(#sunPattern); stroke: none;"/>
              <circle id="InnuendoRing1" class="cls-ring innuendo-ring innuendo-ring-1" cx="216.5" cy="216.5" r="165"/>
              <circle id="InnuendoRing2" class="cls-ring innuendo-ring innuendo-ring-2" cx="216.5" cy="216.5" r="165"/>
              <circle id="InnuendoRing3" class="cls-ring innuendo-ring innuendo-ring-3" cx="216.5" cy="216.5" r="165"/>
            </g>
          </svg>
        </section>
        
        <section class="toudoum-zone">
                <svg id="ToudoumSystem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1659.5 433">
                    <image href="images/stars.jpg" x="0" y="0" width="1659.5" height="433" preserveAspectRatio="xMidYMid slice"/> 
                <defs>
                    <style>
                    .cls-1 {
                        fill: #9e005d;
                    }

                    .cls-2 {
                        fill: red;
                    }

                    .cls-2, .cls-3 {
                        stroke: red;
                        stroke-miterlimit: 10;
                    }

                    .cls-4 {
                        fill: aqua;
                    }

                    .cls-5 {
                        fill: #c1272d;
                    }

                    .cls-6 {
                        fill: #4d4d4d;
                    }

                    .cls-7 {
                        fill: blue;
                    }

                    .cls-3 {
                        fill: none;
                    }

                    .cls-8 {
                        fill: #f7931e;
                    }

                    .cls-9 {
                        fill: #736357;
                    }

                    .cls-10 {
                        fill: lime;
                    }

                    .cls-11 {
                        fill: #fcee21;
                    }
                    .cls-ring {
                        fill: none;
                        stroke: red;
                        stroke-width: 2;
                    }
                    </style>
                <pattern id="sun1Pattern" patternUnits="userSpaceOnUse" width="432" height="432" patternTransform="translate(25 410)">
                    <image href="images/Sun1.png" width="432" height="432" />
                </pattern>
                <pattern id="scofieldPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(486 198)">
                    <image href="images/saturn without rings.png" width="36" height="36" />
                </pattern>
                <pattern id="tatooinePattern" patternUnits="userSpaceOnUse" width="20" height="20" patternTransform="translate(566 206)">
                    <image href="images/Mercure.png" width="20" height="20" />
                </pattern>
                <pattern id="spockPattern" patternUnits="userSpaceOnUse" width="106" height="106" patternTransform="translate(661 162)">
                    <image href="images/Venus.png" width="106" height="106" />
                </pattern>
                <pattern id="gazorpazorpPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(832 197.97)">
                    <image href="images/Terre.png" width="36" height="36" />
                </pattern>
                <pattern id="croutardPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(928.76 197.97)">
                    <image href="images/Mars.png" width="36" height="36" />
                </pattern>
                <pattern id="starkPattern" patternUnits="userSpaceOnUse" width="20" height="20" patternTransform="translate(1012 205)">
                    <image href="images/Jupiter.png" width="20" height="20" />
                </pattern>
                <pattern id="elevenPattern" patternUnits="userSpaceOnUse" width="72" height="72" patternTransform="translate(1115 180)">
                    <image href="images/Uranus.png" width="72" height="72" />
                </pattern>
                <pattern id="ragnarPattern" patternUnits="userSpaceOnUse" width="72" height="72" patternTransform="translate(1329.5 180)">
                    <image href="images/Neptune.png" width="72" height="72" />
                </pattern>
                <pattern id="spinjitsuPattern" patternUnits="userSpaceOnUse" width="54.5" height="54.5" patternTransform="translate(1505.5 188.75)">
                    <image href="images/Neptune.png" width="54.5" height="54.5" />
                </pattern>
                <pattern id="razmoPattern" patternUnits="userSpaceOnUse" width="54.5" height="54.5" patternTransform="translate(1623.5 189.98)">
                    <image href="images/Neptune.png" width="54.5" height="54.5" />
                </pattern>

                <!-- Scofield - Lune -->
                <pattern id="scofieldMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate()">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- tatooine - Lunes -->
                <pattern id="tatooineMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(557 186.39)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="tatooineMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(575.5 195.39)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="tatooineMoon3Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(584.5 226)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Spock - Lunes -->
                <pattern id="spockMoon3Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(758 283.72)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="spockMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(733.67 148.5)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="spockMoon1Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(742.67 128.28)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                
                <!-- Gazorpazorp - Lunes -->
                <pattern id="gazorpazorpMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(850 261)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="gazorpazorpMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(859 233.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="gazorpazorpMoon3Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(868 197.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Croutard - Lunes -->
                <pattern id="croutardMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(955.76 233.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Eleven - Lunes -->
                <pattern id="elevenMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1230 261)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="elevenMoon2Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1239 225)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="elevenMoon3Pattern" patternUnits="userSpaceOnUse" width="27" height="27" patternTransform="translate(1176 126)">
                    <image href="images/Lune.png" width="27" height="27" />
                </pattern>
                
                <!-- Ragnar - Lunes -->
                <pattern id="ragnarMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1428 252)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Spinjitsu - Lunes -->
                <pattern id="spinjitsuMoon3Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1532 252)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="spinjitsuMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1586 225)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="spinjitsuMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1550 171)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Razmo - Lunes -->
                <pattern id="razmoMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1650.5 233.98)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                </defs>
                <g id="RazmoGroup">
                    <circle id="Razmo" class="cls-1" cx="1641.5" cy="215.98" r="18" fill="url(#razmoPattern)" style="fill: url(#razmoPattern);"/>
                    <circle id="MoonRazmo2" class="cls-6" cx="1655" cy="238.48" r="4.5" fill="url(#razmoMoonPattern)" style="fill: url(#razmoMoonPattern);"/>
                </g>
                <g id="SpinjitsuGroup">
                    <circle id="Spinjitsu" class="cls-4" cx="1532.75" cy="216" r="27.25" fill="url(#spinjitsuPattern)" style="fill: url(#spinjitsuPattern);"/>
                    <circle id="SpinjitsuMoon3" class="cls-6" cx="1541" cy="261" r="9" fill="url(#spinjitsuMoon3Pattern)" style="fill: url(#spinjitsuMoon3Pattern);"/>
                    <circle id="SpinjitsuMoon2" class="cls-6" cx="1590.5" cy="229.5" r="4.5" fill="url(#spinjitsuMoon2Pattern)" style="fill: url(#spinjitsuMoon2Pattern);"/>
                    <circle id="SpinjitsuMoon1" class="cls-6" cx="1554.5" cy="175.5" r="4.5" fill="url(#spinjitsuMoon1Pattern)" style="fill: url(#spinjitsuMoon1Pattern);"/>
                </g>
                <g id="RagnarGroup">
                    <circle id="Ragnar" class="cls-9" cx="1365.5" cy="216" r="36" fill="url(#ragnarPattern)" style="fill: url(#ragnarPattern);"/>
                    <circle id="RagnarMoon4" class="cls-6" cx="1432.5" cy="256.5" r="4.5" fill="url(#ragnarMoonPattern)" style="fill: url(#ragnarMoonPattern);"/>
                </g>
                <g id="ElevenGroup">
                    <circle id="Eleven" class="cls-8" cx="1151" cy="216" r="36" fill="url(#elevenPattern)" style="fill: url(#elevenPattern);"/>
                    <circle id="ElevenMoon5" class="cls-6" cx="1234.5" cy="265.5" r="4.5" fill="url(#elevenMoon1Pattern)" style="fill: url(#elevenMoon1Pattern);"/>
                    <circle id="ElevenMoon4" class="cls-6" cx="1248" cy="234" r="9" fill="url(#elevenMoon2Pattern)" style="fill: url(#elevenMoon2Pattern);"/>
                    <circle id="ElevenMoon2" class="cls-6" cx="1189.5" cy="139.5" r="13.5" fill="url(#elevenMoon3Pattern)" style="fill: url(#elevenMoon3Pattern);"/>
                </g>
                <circle id="Stark" class="cls-11" cx="1022" cy="215" r="10" fill="url(#starkPattern)" style="fill: url(#starkPattern);"/>
                <g id="CroutardGroup">
                    <circle id="Croutard" class="cls-1" cx="946.76" cy="215.97" r="18" fill="url(#croutardPattern)" style="fill: url(#croutardPattern);"/>
                    <circle id="MoonCroutard2" class="cls-6" cx="960.26" cy="238.47" r="4.5" fill="url(#croutardMoonPattern)" style="fill: url(#croutardMoonPattern);"/>
                </g>
                <g id="GazorpazorpGroup">
                    <circle id="Gazorpazorp" class="cls-1" cx="850" cy="215.97" r="18" fill="url(#gazorpazorpPattern)" style="fill: url(#gazorpazorpPattern);"/>
                    <circle id="MoonGazorpazorp3" class="cls-6" cx="854.5" cy="265.5" r="4.5" fill="url(#gazorpazorpMoon1Pattern)" style="fill: url(#gazorpazorpMoon1Pattern);"/>
                    <circle id="MoonGazorpazorp2" class="cls-6" cx="863.5" cy="238.47" r="4.5" fill="url(#gazorpazorpMoon2Pattern)" style="fill: url(#gazorpazorpMoon2Pattern);"/>
                    <circle id="MoonGazorpazorp1" class="cls-6" cx="872.5" cy="202.47" r="4.5" fill="url(#gazorpazorpMoon3Pattern)" style="fill: url(#gazorpazorpMoon3Pattern);"/>
                </g>
                <g id="SpockGroup">
                    <circle id="Spock" class="cls-7" cx="714" cy="215" r="53" fill="url(#spockPattern)" style="fill: url(#spockPattern);"/>
                    <circle id="SpockMoon3" class="cls-6" cx="767" cy="292.72" r="9" fill="url(#spockMoon3Pattern)" style="fill: url(#spockMoon3Pattern);"/>
                    <circle id="SpockMoon2" class="cls-6" cx="738.17" cy="153" r="4.5" fill="url(#spockMoon2Pattern)" style="fill: url(#spockMoon2Pattern);"/>
                    <circle id="SpockMoon1" class="cls-6" cx="751.67" cy="137.28" r="9" fill="url(#spockMoon1Pattern)" style="fill: url(#spockMoon1Pattern);"/>
                </g>
                <g id="TatooineGroup">
                    <circle id="Tatooine" class="cls-5" cx="576" cy="216" r="10" fill="url(#tatooinePattern)" style="fill: url(#tatooinePattern);"/>
                    <circle id="TatooineMoon3" class="cls-6" cx="589" cy="230.5" r="4.5" fill="url(#tatooineMoon3Pattern)" style="fill: url(#tatooineMoon3Pattern);"/>
                    <circle id="TatooineMoon2" class="cls-6" cx="580" cy="199.89" r="4.5" fill="url(#tatooineMoon2Pattern)" style="fill: url(#tatooineMoon2Pattern);"/>
                    <circle id="TatooineMoon1" class="cls-6" cx="561.5" cy="190.89" r="4.5" fill="url(#tatooineMoon1Pattern)" style="fill: url(#tatooineMoon1Pattern);"/>
                </g>
                <g id="ScofieldGroup">
                    <circle id="Scofield" class="cls-10" cx="504" cy="216" r="18" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                    <circle id="ScofieldMoon" class="cls-6" cx="517.5" cy="238.5" r="4.5" fill="url(#scofieldMoonPattern)" style="fill: url(#scofieldMoonPattern);"/>
                </g>
                <g id="SunGroup">
                    <circle id="Sun" class="cls-3" cx="216.5" cy="216.5" r="162" fill="url(#sun1Pattern)" style="fill: url(#sun1Pattern); stroke: none;"/>
                    <circle id="InnuendoRing1" class="cls-ring innuendo-ring innuendo-ring-1" cx="216.5" cy="216.5" r="165"/>
                    <circle id="InnuendoRing2" class="cls-ring innuendo-ring innuendo-ring-2" cx="216.5" cy="216.5" r="165"/>
                    <circle id="InnuendoRing3" class="cls-ring innuendo-ring innuendo-ring-3" cx="216.5" cy="216.5" r="165"/>
                </g>
                </svg>
        </section>

        <section class="ikea-zone">
            <svg id="IkeaSystem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1655.25 433">
                <image href="images/stars.jpg" x="0" y="0" width="1655.25" height="433" preserveAspectRatio="xMidYMid slice"/> 
            <defs>
                <style>
                .cls-1 {
                    fill: #9e005d;
                }

                .cls-2 {
                    fill: red;
                }

                .cls-2, .cls-3 {
                    stroke: red;
                    stroke-miterlimit: 10;
                }

                .cls-4 {
                    fill: aqua;
                }

                .cls-5 {
                    fill: #c1272d;
                }

                .cls-6 {
                    fill: #4d4d4d;
                }

                .cls-7 {
                    fill: blue;
                }

                .cls-3 {
                    fill: none;
                }

                .cls-8 {
                    fill: #f7931e;
                }

                .cls-9 {
                    fill: #736357;
                }

                .cls-10 {
                    fill: lime;
                }

                .cls-11 {
                    fill: #fcee21;
                }
                <pattern id="malmPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(486 198)">
                    <image href="images/saturn without rings.png" width="36" height="36" />
                </pattern>
                <pattern id="tatooinePattern" patternUnits="userSpaceOnUse" width="20" height="20" patternTransform="translate(566 206)">
                    <image href="images/Mercure.png" width="20" height="20" />
                </pattern>
                <pattern id="spockPattern" patternUnits="userSpaceOnUse" width="106" height="106" patternTransform="translate(661 162)">
                    <image href="images/Venus.png" width="106" height="106" />
                </pattern>
                <pattern id="gazorpazorpPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(832 197.97)">
                    <image href="images/Terre.png" width="36" height="36" />
                </pattern>
                <pattern id="croutardPattern" patternUnits="userSpaceOnUse" width="36" height="36" patternTransform="translate(928.76 197.97)">
                    <image href="images/Mars.png" width="36" height="36" />
                </pattern>
                <pattern id="starkPattern" patternUnits="userSpaceOnUse" width="20" height="20" patternTransform="translate(1012 205)">
                    <image href="images/Jupiter.png" width="20" height="20" />
                </pattern>
                <pattern id="elevenPattern" patternUnits="userSpaceOnUse" width="72" height="72" patternTransform="translate(1115 180)">
                    <image href="images/Uranus.png" width="72" height="72" />
                </pattern>
                <pattern id="ragnarPattern" patternUnits="userSpaceOnUse" width="72" height="72" patternTransform="translate(1329.5 180)">
                    <image href="images/Neptune.png" width="72" height="72" />
                </pattern>
                <pattern id="spinjitsuPattern" patternUnits="userSpaceOnUse" width="54.5" height="54.5" patternTransform="translate(1505.5 188.75)">
                    <image href="images/Neptune.png" width="54.5" height="54.5" />
                </pattern>
                <pattern id="razmoPattern" patternUnits="userSpaceOnUse" width="54.5" height="54.5" patternTransform="translate(1623.5 189.98)">
                    <image href="images/Neptune.png" width="54.5" height="54.5" />
                </pattern>

                <!-- Scofield - Lune -->
                <pattern id="scofieldMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate()">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- tatooine - Lunes -->
                <pattern id="tatooineMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(557 186.39)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="tatooineMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(575.5 195.39)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="tatooineMoon3Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(584.5 226)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                
                <!-- Spock - Lunes -->
                <pattern id="spockMoon3Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(758 283.72)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="spockMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(733.67 148.5)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="spockMoon1Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(742.67 128.28)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                
                <!-- Gazorpazorp - Lunes -->
                <pattern id="gazorpazorpMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(850 261)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="gazorpazorpMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(859 233.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="gazorpazorpMoon3Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(868 197.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Croutard - Lunes -->
                <pattern id="croutardMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(955.76 233.97)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Eleven - Lunes -->
                <pattern id="elevenMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1230 261)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="elevenMoon2Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1239 225)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="elevenMoon3Pattern" patternUnits="userSpaceOnUse" width="27" height="27" patternTransform="translate(1176 126)">
                    <image href="images/Lune.png" width="27" height="27" />
                </pattern>
                
                <!-- Ragnar - Lunes -->
                <pattern id="ragnarMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1428 252)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Spinjitsu - Lunes -->
                <pattern id="spinjitsuMoon3Pattern" patternUnits="userSpaceOnUse" width="18" height="18" patternTransform="translate(1532 252)">
                    <image href="images/Lune.png" width="18" height="18" />
                </pattern>
                <pattern id="spinjitsuMoon2Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1586 225)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
                <pattern id="spinjitsuMoon1Pattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1550 171)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>

                <!-- Razmo - Lunes -->
                <pattern id="razmoMoonPattern" patternUnits="userSpaceOnUse" width="9" height="9" patternTransform="translate(1650.5 233.98)">
                    <image href="images/Lune.png" width="9" height="9" />
                </pattern>
            </defs>
            <g id="AkernejlikaGroup">
                <circle id="Akernejlika" class="cls-5" cx="1637.75" cy="216" r="10" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="AkernejlikaMoon3" class="cls-6" cx="1650.75" cy="230.5" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="AkernejlikaMoon2" class="cls-6" cx="1641.75" cy="199.89" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="AkernejlikaMoon1" class="cls-6" cx="1623.25" cy="190.89" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            </g>
            <g id="SlattikaGroup">
                <circle id="Slattika" class="cls-1" cx="1571.5" cy="215.98" r="18" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="MoonSlattika2" class="cls-6" cx="1585" cy="238.48" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            </g>
            <g id="TuvkornelGroup">
                <circle id="Tuvkornel" class="cls-4" cx="1462.75" cy="216" r="27.25" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="TuvkornelMoon3" class="cls-6" cx="1471" cy="261" r="9" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="TuvkornelMoon2" class="cls-6" cx="1520.5" cy="229.5" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="TuvkornelMoon1" class="cls-6" cx="1484.5" cy="175.5" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            </g>
            <g id="LjungsbroGroup">
                <circle id="Ljungsbro" class="cls-9" cx="1318.5" cy="216" r="36" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="LjungsbroMoon4" class="cls-6" cx="1385.5" cy="256.5" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            </g>
            <g id="RamseleGroup">
                <circle id="Ramsele" class="cls-8" cx="1104" cy="216" r="36" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="RamseleMoon5" class="cls-6" cx="1187.5" cy="265.5" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="RamseleMoon4" class="cls-6" cx="1201" cy="234" r="9" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="RamseleMoon2" class="cls-6" cx="1142.5" cy="139.5" r="13.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            </g>
            <circle id="Skogssvingel" class="cls-11" cx="1000" cy="215" r="10" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            <g id="LappdunortGroup">
                <circle id="Lappdunort" class="cls-1" cx="924.76" cy="215.97" r="18" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="MoonLappdunort2" class="cls-6" cx="938.26" cy="238.47" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            </g>
            <g id="TåsjönGroup">
                <circle id="Tåsjön" class="cls-1" cx="828" cy="215.97" r="18" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="MoonTåsjön3" class="cls-6" cx="832.5" cy="265.5" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="MoonTåsjön2" class="cls-6" cx="841.5" cy="238.47" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="MoonTåsjön1" class="cls-6" cx="850.5" cy="202.47" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            </g>
            <g id="KnoxhultGroup">
                <circle id="Knoxhult" class="cls-7" cx="692" cy="215" r="53" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="KnoxhultMoon3" class="cls-6" cx="745" cy="292.72" r="9" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="KnoxhultMoon2" class="cls-6" cx="716.17" cy="153" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="KnoxhultMoon1" class="cls-6" cx="729.67" cy="137.28" r="9" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
            </g>
            <g id="FrihetenGroup">
                <circle id="Friheten" class="cls-5" cx="563" cy="216" r="10" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="FrihetenMoon3" class="cls-6" cx="576" cy="230.5" r="4.5" fill="url(#scofieldPattern)" style="fill: url(#scofieldPattern);"/>
                <circle id="FrihetenMoon2" class="cls-6" cx="567" cy="199.89" r="4.5" fill="url(#frihetenMoon2Pattern)" style="fill: url(#frihetenMoon2Pattern);"/>
                <circle id="FrihetenMoon1" class="cls-6" cx="548.5" cy="190.89" r="4.5" fill="url(#frihetenMoon1Pattern)" style="fill: url(#frihetenMoon1Pattern);"/>
            </g>
            <g id="MalmGroup">
                <circle id="Malm" class="cls-10" cx="491" cy="216" r="18" fill="url(#malmPattern)" style="fill: url(#malmPattern);"/>
                <circle id="MalmMoon" class="cls-6" cx="504.5" cy="238.5" r="4.5" fill="url(#malmMoonPattern)" style="fill: url(#malmMoonPattern);"/>
            </g>
            <g id="SunGroup">
                <circle id="Sun" class="cls-3" cx="216.5" cy="216.5" r="162" fill="url(#sun1Pattern)" style="fill: url(#sun1Pattern); stroke: none;"/>
                <circle id="InnuendoRing1" class="cls-ring innuendo-ring innuendo-ring-1" cx="216.5" cy="216.5" r="165"/>
                <circle id="InnuendoRing2" class="cls-ring innuendo-ring innuendo-ring-2" cx="216.5" cy="216.5" r="165"/>
                <circle id="InnuendoRing3" class="cls-ring innuendo-ring innuendo-ring-3" cx="216.5" cy="216.5" r="165"/>
            </g>
            </svg>
        </section>

               

<div class="innuendo-popup" id="popup">
    <button class="innuendo-popup-close" id="popup-close">×</button>
    <h3 id="popup-title">Nom de la planète</h3>
    <div class="innuendo-popup-content" id="popup-content">
        <!-- Infos injectées ici dynamiquement -->
    </div>
</div>
<div class="innuendo-overlay"></div>
<script>
// Script JavaScript interactif pour innuendo

const systemPlanetData = {
  innuendo: {
    map: {
      "solidays": "Solidays",
      "we-love-green": "We_Love_Green",
      "hellfest": "Hellfest",
      "ardente": "Ardente",
      "tomorrowland": "Tomorrowland",
      "delta": "Delta",
      "lhuma": "Lhuma",
      "lollapalooza": "Lollapalooza",
      "veillecharue": "Veillecharue"
    },
    svgId: "SolarSystem",
    listClass: ".innuendo-list"
  },
  toudoum: {
    map: {
      "scofield": "Scofield",
      "tatooine": "Tatooine",
      "spock": "Spock",
      "gazorpazorp": "Gazorpazorp",
      "croutard": "Croutard",
      "stark": "Stark",
      "eleven": "Eleven",
      "ragnar": "Ragnar",
      "spinjitsu": "Spinjitsu",
      "razmo": "Razmo"
    },
    svgId: "ToudoumSystem",
    listClass: ".toudoum-list"
  },
  ikea: {
    map: {
      "malm": "Malm",
      "friheten": "Friheten",
      "knoxhult": "Knoxhult",
      "tåsjön": "Tåsjön",
      "lappdunort": "Lappdunort",
      "skogssvingel": "Skogssvingel",
      "ramsele": "Ramsele",
      "ljungsbro": "Ljungsbro",
      "tuvkornel": "Tuvkornel",
      "slattika": "Slattika",
      "akernejlika": "Akernejlika"
    },
    svgId: "IkeaSystem", // ⚠️ Tu dois renommer ce `id="SolarSystem"` en `id="IkeaSystem"`
    listClass: ".ikea-list"
  }
};

// Infos des popups (exemple réduit — tu peux compléter)
const popupData = {
  // 🌱 Innuendo
  "solidays": {
    nom: "Solidays",
    description: "Planète de la solidarité musicale.",
    couleur: "#10B981",
    image: "images/solidays.png"
  },
  "we-love-green": {
    nom: "We Love Green",
    description: "Planète éco-responsable et engagée.",
    couleur: "#C1272D",
    image: "images/welovegreen.png"
  },
  "hellfest": {
    nom: "Hellfest",
    description: "Planète du métal et de l'enfer sonore.",
    couleur: "#3B82F6",
    image: "images/hellfest.png"
  },
  "ardente": {
    nom: "Ardente",
    description: "Planète flamboyante des sons électrisants.",
    couleur: "#9E005D",
    image: "images/ardente.png"
  },
  "tomorrowland": {
    nom: "Tomorrowland",
    description: "Planète de la fête futuriste.",
    couleur: "#9E005D",
    image: "images/tomorrowland.png"
  },
  "delta": {
    nom: "Delta",
    description: "Planète des flux sonores multiples.",
    couleur: "#FCEE21",
    image: "images/delta.png"
  },
  "lhuma": {
    nom: "Lhuma",
    description: "Planète de la nature et des sens.",
    couleur: "#F7931E",
    image: "images/lhuma.png"
  },
  "lollapalooza": {
    nom: "Lollapalooza",
    description: "Planète de l'éclectisme sonore global.",
    couleur: "#736357",
    image: "images/lollapalooza.png"
  },
  "veillecharue": {
    nom: "Veillecharue",
    description: "Planète ancestrale des voix rurales.",
    couleur: "#00FFFF",
    image: "images/veillecharue.png"
  },

  // ⚔️ Tou-Doom
  "scofield": {
    nom: "Scofield",
    description: "Planète carcérale du groove tactique.",
    couleur: "#10B981",
    image: "images/scofield.png"
  },
  "tatooine": {
    nom: "Tatooine",
    description: "Planète aride aux deux soleils, berceau des rebelles.",
    couleur: "#C084FC",
    image: "images/tatooine.png"
  },
  "spock": {
    nom: "Spock",
    description: "Planète logique et stratégique de l'esprit calme.",
    couleur: "#3B82F6",
    image: "images/spock.png"
  },
  "gazorpazorp": {
    nom: "Gazorpazorp",
    description: "Planète explosive où la folie règne.",
    couleur: "#EF4444",
    image: "images/gazorpazorp.png"
  },
  "croutard": {
    nom: "Croutard",
    description: "Planète féline aux instincts rusés.",
    couleur: "#A3A3A3",
    image: "images/croutard.png"
  },
  "stark": {
    nom: "Stark",
    description: "Planète glaciale du devoir et des loups.",
    couleur: "#FCEE21",
    image: "images/stark.png"
  },
  "eleven": {
    nom: "Eleven",
    description: "Planète psychique de l'ombre et des gaufres.",
    couleur: "#F59E0B",
    image: "images/eleven.png"
  },
  "ragnar": {
    nom: "Ragnar",
    description: "Planète des guerriers vikings intrépides.",
    couleur: "#4B5563",
    image: "images/ragnar.png"
  },
  "spinjitsu": {
    nom: "Spinjitsu",
    description: "Planète des ninjas en rotation continue.",
    couleur: "#00FFFF",
    image: "images/spinjitsu.png"
  },
  "razmo": {
    nom: "Razmo",
    description: "Planète du bricolage spatial déjanté.",
    couleur: "#EF4444",
    image: "images/razmo.png"
  },

  // 🧊 IKEA
  "malm": {
    nom: "Malm",
    description: "Planète du rangement intergalactique.",
    couleur: "#F59E0B",
    image: "images/malm.png"
  },
  "friheten": {
    nom: "Friheten",
    description: "Planète du confort modulable et des siestes cosmiques.",
    couleur: "#10B981",
    image: "images/friheten.png"
  },
  "knoxhult": {
    nom: "Knoxhult",
    description: "Planète compacte au design minimaliste.",
    couleur: "#3B82F6",
    image: "images/knoxhult.png"
  },
  "tåsjön": {
    nom: "Tåsjön",
    description: "Planète aquatique d’origine suédoise.",
    couleur: "#9E005D",
    image: "images/tasjon.png"
  },
  "lappdunort": {
    nom: "Lappdunort",
    description: "Planète froide au cœur douillet.",
    couleur: "#9E005D",
    image: "images/lappdunort.png"
  },
  "skogssvingel": {
    nom: "Skogssvingel",
    description: "Planète végétale et apaisante.",
    couleur: "#FCEE21",
    image: "images/skogssvingel.png"
  },
  "ramsele": {
    nom: "Ramsele",
    description: "Planète lumineuse aux ondes douces.",
    couleur: "#F7931E",
    image: "images/ramsele.png"
  },
  "ljungsbro": {
    nom: "Ljungsbro",
    description: "Planète chocolatée au nom suédois.",
    couleur: "#736357",
    image: "images/ljungsbro.png"
  },
  "tuvkornel": {
    nom: "Tuvkornel",
    description: "Planète fleurie des douceurs cosmiques.",
    couleur: "#00FFFF",
    image: "images/tuvkornel.png"
  },
  "slattika": {
    nom: "Slattika",
    description: "Planète discrète aux mystères plats.",
    couleur: "#EF4444",
    image: "images/slattika.png"
  },
  "akernejlika": {
    nom: "Akernejlika",
    description: "Planète des rangements secrets et noms imprononçables.",
    couleur: "#3B82F6",
    image: "images/akernejlika.png"
  }
};


const popup = document.getElementById("popup");
const overlay = document.querySelector(".innuendo-overlay");
const popupTitle = document.getElementById("popup-title");
const popupContent = document.getElementById("popup-content");
const closeBtn = document.getElementById("popup-close");

function setupSystemInteractions(systemKey) {
  const system = systemPlanetData[systemKey];
  const { map, svgId, listClass } = system;

  const svg = document.getElementById(svgId);
  const items = document.querySelectorAll(`${listClass} li`);

  items.forEach(item => {
    const key = item.dataset.planet;
    if (!key) return;
    item.addEventListener("mouseenter", () => highlight(map[key], svg));
    item.addEventListener("mouseleave", () => reset(svg));
    item.addEventListener("click", e => {
      e.preventDefault();
      showPopup(key);
    });
  });

  Object.entries(map).forEach(([key, id]) => {
    const el = document.getElementById(id);
    if (el) {
      el.style.cursor = "pointer";
      el.addEventListener("mouseenter", () => highlight(id, svg));
      el.addEventListener("mouseleave", () => reset(svg));
      el.addEventListener("click", e => {
        e.preventDefault();
        e.stopPropagation();
        showPopup(key);
      });
    }
  });
}

function highlight(id, svg) {
  const all = svg.querySelectorAll("circle, .innuendo-ring");
  all.forEach(el => {
    el.classList.add("dim-everything");
    el.classList.remove("glow-target");
  });
  const target = document.getElementById(id);
  if (target) {
    target.classList.remove("dim-everything");
    target.classList.add("glow-target");
  }
}

function reset(svg) {
  svg.querySelectorAll("circle, .innuendo-ring").forEach(el => {
    el.classList.remove("dim-everything", "glow-target");
  });
}

function showPopup(key) {
  if (!popupData[key]) return;
  const data = popupData[key];
  popupTitle.textContent = data.nom;
  popupContent.innerHTML = `
    <div class="popup-planet-visual">
      <div class="popup-planet-icon" style="background-color:${data.couleur}; background-image: url('${data.image}');"></div>
    </div>
    <div class="popup-info">
      <p>${data.description}</p>
      <button class="popup-go" onclick="window.location.href='voyager.php?planete=${encodeURIComponent(data.nom)}'">Voir les voyages</button>
    </div>
  `;
  popup.style.display = "block";
  overlay.style.display = "block";
  document.body.style.overflow = "hidden";
}

function closePopup() {
  popup.style.display = "none";
  overlay.style.display = "none";
  document.body.style.overflow = "auto";
}

if (closeBtn) closeBtn.addEventListener("click", closePopup);
if (overlay) overlay.addEventListener("click", closePopup);
document.addEventListener("keydown", e => {
  if (e.key === "Escape" && popup.style.display === "block") {
    closePopup();
  }
});

// ⚙️ Initialisation pour tous les systèmes
Object.keys(systemPlanetData).forEach(setupSystemInteractions);
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