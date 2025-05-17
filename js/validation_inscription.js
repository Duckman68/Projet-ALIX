document.addEventListener("DOMContentLoaded", () => {
    const formulaire = document.getElementById("form-inscription");
    const champs = {
        nom: document.getElementById("nom"),
        prenom: document.getElementById("prenom"),
        email: document.getElementById("email"),
        motdepasse: document.getElementById("mot_de_passe"),
        confirmation: document.getElementById("confirmation_mot_de_passe")
    };

    const erreurs = document.getElementById("erreurs");
    const compteur = document.getElementById("compteur-mdp");

    // Boutons œil
    document.querySelectorAll(".oeil-bouton").forEach(bouton => {
        bouton.addEventListener("click", () => {
            const cibleId = bouton.dataset.cible;
            const champ = document.getElementById(cibleId);

            if (champ.type === "password") {
                champ.type = "text";
                bouton.textContent = "🙈";
            } else {
                champ.type = "password";
                bouton.textContent = "👁";
            }
        });
    });

    // Compteur pour le mot de passe
    champs.motdepasse.addEventListener("input", () => {
        compteur.textContent = `${champs.motdepasse.value.length} caractères`;
    });

    // Validation formulaire
    formulaire.addEventListener("submit", (e) => {
        e.preventDefault();
        erreurs.innerHTML = "";
        let valide = true;

        for (let cle in champs) {
            if (champs[cle].value.trim() === "") {
                valide = false;
                erreurs.innerHTML += `<p>Le champ ${cle} est obligatoire.</p>`;
            }
        }

        if (champs.motdepasse.value !== champs.confirmation.value) {
            valide = false;
            erreurs.innerHTML += `<p>Les mots de passe ne correspondent pas.</p>`;
        }

        if (valide) {
            formulaire.submit();
        }
    });
});
