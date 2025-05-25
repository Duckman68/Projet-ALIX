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
          <?xml version="1.0" encoding="UTF-8"?>
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
          
    <aside class="innuendo-sidebar">
        <h2>Planètes</h2>
        <ul class="innuendo-list">
            <li data-planet="solidays">Solidays</li>
            <li data-planet="we-love-green">We Love Green</li>
            <li data-planet="hellfest">Hellfest</li>
            <li data-planet="ardente">Ardente</li>
            <li data-planet="tomorrowland">Tomorrowland</li>
            <li data-planet="delta">Delta</li>
            <li data-planet="lhuma">Lhuma</li>
            <li data-planet="lollapalooza">Lollapalooza</li>
            <li data-planet="veillecharue">Veillecharue</li>
        </ul>
    </aside>

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

const planetMap = {
    "solidays": "Solidays",
    "we-love-green": "We_Love_Green",
    "hellfest": "Hellfest",
    "ardente": "Ardente",
    "tomorrowland": "Tomorrowland",
    "delta": "Delta",
    "lhuma": "Lhuma",
    "lollapalooza": "Lollapalooza",
    "veillecharue": "Veillecharue"
};

const planets = Object.keys(planetMap);

const popup = document.getElementById("popup");
const overlay = document.querySelector(".innuendo-overlay");
const popupTitle = document.getElementById("popup-title");
const popupContent = document.getElementById("popup-content");
const closeBtn = document.getElementById("popup-close");

function highlightPlanet(key) {
    const all = document.querySelectorAll("#SolarSystem circle, .innuendo-ring");
    all.forEach(el => {
        el.classList.add("dim-everything");
        el.classList.remove("glow-target");
    });
    const targetId = planetMap[key];
    const target = document.getElementById(targetId);
    if (target) {
        target.classList.remove("dim-everything");
        target.classList.add("glow-target");
    }
}

function resetHighlight() {
    document.querySelectorAll("#SolarSystem circle, .innuendo-ring").forEach(el => {
        el.classList.remove("dim-everything", "glow-target");
    });
    document.querySelectorAll(".sidebar-highlight").forEach(el => {
        el.classList.remove("sidebar-highlight");
    });
}

function showPopup(key) {
    const data = {
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
        }
    };
    if (!data[key]) return;
    popupTitle.textContent = data[key].nom;
    popupContent.innerHTML = `
        <div class="popup-planet-visual">
            <div class="popup-planet-icon" style="background-color:${data[key].couleur}; background-image: url('${data[key].image}'); background-size: cover;"></div>
        </div>
        <div class="popup-info">
            <p>${data[key].description}</p>
            <button class="popup-go" onclick="window.location.href='voyager.php?planete=${encodeURIComponent(data[key].nom)}'">Voir les voyages</button>
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
    resetHighlight();
}

document.querySelectorAll(".innuendo-list li").forEach(item => {
    const key = item.dataset.planet;
    item.addEventListener("mouseenter", () => highlightPlanet(key));
    item.addEventListener("mouseleave", resetHighlight);
    item.addEventListener("click", e => {
        e.preventDefault();
        showPopup(key);
    });
});

Object.entries(planetMap).forEach(([key, id]) => {
    const el = document.getElementById(id);
    if (el) {
        el.style.cursor = "pointer";
        el.addEventListener("mouseenter", () => highlightPlanet(key));
        el.addEventListener("mouseleave", resetHighlight);
        el.addEventListener("click", e => {
            e.preventDefault();
            e.stopPropagation();
            showPopup(key);
        });
    }
});

if (closeBtn) closeBtn.addEventListener("click", closePopup);
if (overlay) overlay.addEventListener("click", closePopup);
document.addEventListener("keydown", e => {
    if (e.key === "Escape" && popup.style.display === "block") {
        closePopup();
    }
});


</script>
</body>
</html>