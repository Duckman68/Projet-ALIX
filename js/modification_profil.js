document.addEventListener("DOMContentLoaded", () => {
    const champs = document.querySelectorAll(".champ-modifiable");
    const boutonSoumettre = document.getElementById("bouton-soumettre");

    let modificationFaite = false;

    champs.forEach((groupe) => {
        const champ = groupe.querySelector("input");
        const editer = groupe.querySelector(".btn-editer");
        const valider = groupe.querySelector(".btn-valider");
        const annuler = groupe.querySelector(".btn-annuler");

        let valeurInitiale = champ.value;

        editer.addEventListener("click", () => {
            champ.disabled = false;
            champ.focus();
            editer.style.display = "none";
            valider.style.display = "inline-block";
            annuler.style.display = "inline-block";
        });

        annuler.addEventListener("click", () => {
            champ.value = valeurInitiale;
            champ.disabled = true;
            editer.style.display = "inline-block";
            valider.style.display = "none";
            annuler.style.display = "none";
        });

        valider.addEventListener("click", () => {
            valeurInitiale = champ.value;
            champ.disabled = true;
            editer.style.display = "inline-block";
            valider.style.display = "none";
            annuler.style.display = "none";
            modificationFaite = true;
            boutonSoumettre.style.display = "inline-block";
        });
    });

    // ✅ Activer tous les champs avant l'envoi
    const formulaire = document.getElementById("form-profil");
    formulaire.addEventListener("submit", () => {
        formulaire.querySelectorAll("input").forEach(input => {
            input.disabled = false;
        });
    });

    // 📷 Prévisualisation de la photo de profil sélectionnée
    const fileInput = document.getElementById("pp");
    const previewImage = document.getElementById("preview-image");

    if (fileInput && previewImage) {
        fileInput.addEventListener("change", (e) => {
            const [file] = e.target.files;
            if (file) {
                previewImage.src = URL.createObjectURL(file);
                boutonSoumettre.style.display = "inline-block"; // Affiche le bouton Soumettre si image changée
            }
        });
    }
});
