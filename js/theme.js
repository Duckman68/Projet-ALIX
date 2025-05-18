// Fonction pour créer un cookie
function definirCookie(nom, valeur, jours) {
    const date = new Date();
    date.setTime(date.getTime() + (jours * 24 * 60 * 60 * 1000)); // durée en ms
    document.cookie = nom + "=" + valeur + ";expires=" + date.toUTCString() + ";path=/";
}

// Fonction pour lire un cookie
function lireCookie(nom) {
    let correspondance = document.cookie.match("(^|;)\\s*" + nom + "\\s*=\\s*([^;]+)");
    return correspondance ? correspondance[2] : null;
}

/*
document.addEventListener("DOMContentLoaded", () => {
    const boutonTheme = document.getElementById("theme-switch");
    const lienStyle = document.getElementById("theme-style");

    // Au chargement, on applique le thème enregistré s'il existe
    const themeEnregistre = lireCookie("theme");

    if (themeEnregistre === "jour") {
        lienStyle.setAttribute("href", "../css/style_jour.css");
    } else {
        lienStyle.setAttribute("href", "../css/style_nuit.css");
    }

    // Lors du clic, on bascule et on enregistre le choix
    boutonTheme.addEventListener("click", () => {
        const cheminActuel = lienStyle.getAttribute("href");

        if (cheminActuel.includes("style_nuit.css")) {
            lienStyle.setAttribute("href", "../css/style_jour.css");
            definirCookie("theme", "jour", 30);
        } else {
            lienStyle.setAttribute("href", "../css/style_nuit.css");
            definirCookie("theme", "nuit", 30);
        }
    });
});
*/
document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("theme-toggle");
    const themeLink = document.getElementById("theme-style");
    const videoElement = document.getElementById("logo-video");

    function changerVideoLogo(theme) {
        if (!videoElement) return;
        const source = videoElement.querySelector("source");

        if (theme === "jour") {
            source.setAttribute("src", "../img/Logo-3-[remix]white.mp4");
        } else {
            source.setAttribute("src", "../img/Logo-3-[cut](site).mp4");
        }

        videoElement.load();
    }

    const savedTheme = localStorage.getItem("theme") || "nuit";
    themeLink.setAttribute("href", "../css/style_" + savedTheme + ".css");
    toggle.textContent = savedTheme === "jour" ? "☀️" : "🌙";
    changerVideoLogo(savedTheme);

    toggle.addEventListener("click", () => {
        const newTheme = themeLink.getAttribute("href").includes("nuit") ? "jour" : "nuit";

        themeLink.setAttribute("href", "../css/style_" + newTheme + ".css");
        localStorage.setItem("theme", newTheme);
        toggle.textContent = newTheme === "jour" ? "☀️" : "🌙";
        changerVideoLogo(newTheme);
    });
});

