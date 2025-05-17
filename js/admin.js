document.addEventListener('DOMContentLoaded', function () {
    // Éléments du DOM
    const filterButtons = document.querySelectorAll('.bouton-recherche button');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const userRows = document.querySelectorAll('tbody tr');

    // Fonction pour filtrer par rôle
    function filtrerParRole(role) {
        userRows.forEach(ligne => {
            const roleLigne = ligne.getAttribute('data-role');
            ligne.style.display = (role === 'all' || roleLigne === role) ? '' : 'none';
        });
    }

    // Fonction de recherche
    function rechercherUtilisateurs() {
        const terme = searchInput.value.toLowerCase();
        const filtreActif = document.querySelector('.bouton-recherche button.active')?.dataset.filter || 'all';

        userRows.forEach(ligne => {
            const nom = ligne.cells[0].textContent.toLowerCase();
            const prenom = ligne.cells[1].textContent.toLowerCase();
            const role = ligne.getAttribute('data-role');

            const correspond = nom.includes(terme) || prenom.includes(terme);
            const roleOk = filtreActif === 'all' || role === filtreActif;

            ligne.style.display = correspond && roleOk ? '' : 'none';
        });
    }

    // Gestion des filtres
    filterButtons.forEach(bouton => {
        bouton.addEventListener('click', function () {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filtrerParRole(this.dataset.filter);
        });
    });

    // Gestion recherche
    searchButton.addEventListener('click', rechercherUtilisateurs);
    searchInput.addEventListener('keyup', e => {
        if (e.key === 'Enter') rechercherUtilisateurs();
    });

    // Appliquer filtre par défaut
    document.querySelector('.bouton-recherche button[data-filter="all"]').click();

    // ✅ Simulation mise à jour avec délai
    document.querySelectorAll(".select-role").forEach(select => {
        select.addEventListener("change", function (e) {
            e.preventDefault();

            const champ = this;
            const formulaire = champ.closest("form");
            const nouvelleValeur = champ.value;

            // Désactiver le champ et simuler chargement
            champ.disabled = true;
            champ.innerHTML = `<option selected>⏳ mise à jour...</option>`;

            setTimeout(() => {
                const champCache = document.createElement("input");
                champCache.type = "hidden";
                champCache.name = "new_role";
                champCache.value = nouvelleValeur;
                formulaire.appendChild(champCache);

                formulaire.submit();
            }, 2000);
        });
    });
});
