document.addEventListener("DOMContentLoaded", () => {
    const formulaire = document.getElementById("form-connexion");
    const email = document.getElementById("email");
    const motdepasse = document.getElementById("mot_de_passe");
    const erreurs = document.getElementById("erreurs");
    const compteur = document.getElementById("compteur-mdp");

    const bouton = document.querySelector(".oeil-bouton");
    bouton.addEventListener("click", () => {
        if (motdepasse.type === "password") {
            motdepasse.type = "text";
            bouton.textContent = "🙈";
        } else {
            motdepasse.type = "password";
            bouton.textContent = "👁";
        }
    });

    if (motdepasse && compteur) {
        motdepasse.addEventListener("input", () => {
            compteur.textContent = motdepasse.value.length;
        });
    }

    formulaire.addEventListener("submit", (e) => {
        e.preventDefault();
        erreurs.innerHTML = "";
        let valide = true;

        if (email.value.trim() === "") {
            erreurs.innerHTML += "<p>L’adresse email est obligatoire.</p>";
            valide = false;
        }

        if (motdepasse.value.trim() === "") {
            erreurs.innerHTML += "<p>Le mot de passe est obligatoire.</p>";
            valide = false;
        }

        if (valide) {
            formulaire.submit();
        }
    });
});
