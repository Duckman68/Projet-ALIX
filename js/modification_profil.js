document.addEventListener("DOMContentLoaded", () => {
    const champs = document.querySelectorAll(".champ-modifiable");
    const boutonSoumettre = document.getElementById("bouton-soumettre");

    // Pour suivre si au moins une modification a été validée
    let modificationFaite = false;

    // Parcours de chaque champ modifiable
    champs.forEach((groupe) => {
        const champ = groupe.querySelector("input");
        const editer = groupe.querySelector(".btn-editer");
        const valider = groupe.querySelector(".btn-valider");
        const annuler = groupe.querySelector(".btn-annuler");

        // On sauvegarde la valeur initiale pour pouvoir annuler
        let valeurInitiale = champ.value;

        // 👉 Clic sur le bouton ✏️
        editer.addEventListener("click", () => {
            champ.disabled = false;                         // On rend le champ modifiable
            champ.focus();                                  // Focus automatique
            editer.style.display = "none";                  // On masque ✏️
            valider.style.display = "inline-block";         // On affiche ✅
            annuler.style.display = "inline-block";         // On affiche ❌
        });

        // ❌ Annulation de la modification
        annuler.addEventListener("click", () => {
            champ.value = valeurInitiale;                   // On remet la valeur d'origine
            champ.disabled = true;                          // On désactive le champ
            editer.style.display = "inline-block";
            valider.style.display = "none";
            annuler.style.display = "none";
        });

        // ✅ Validation de la modification
        valider.addEventListener("click", () => {
            valeurInitiale = champ.value;                   // On enregistre la nouvelle valeur
            champ.disabled = true;                          // On désactive le champ visuellement
            editer.style.display = "inline-block";
            valider.style.display = "none";
            annuler.style.display = "none";
            modificationFaite = true;
            boutonSoumettre.style.display = "inline-block"; // On affiche le bouton Soumettre
        });
    });

    // ✅ Avant l'envoi du formulaire, activer tous les champs pour qu'ils soient bien envoyés
    const formulaire = document.getElementById("form-profil");
    formulaire.addEventListener("submit", () => {
        formulaire.querySelectorAll("input").forEach(input => {
            input.disabled = false;
        });
    });
});
