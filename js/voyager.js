document.addEventListener('DOMContentLoaded', function () {
    const menu = document.getElementById('menu-selecteur');
    const bouton = document.querySelector('.selecteur-bouton');
    const terminer = document.getElementById('terminer-btn');

    // Ouvrir ou fermer le menu
    bouton.addEventListener('click', () => {
        const isVisible = menu.style.display === 'block';
        menu.style.display = isVisible ? 'none' : 'block';
    });

    // Fermer avec le bouton "Terminer"
    terminer.addEventListener('click', () => {
        menu.style.display = 'none';
    });

    // Gérer les boutons + et -
    ['adultes', 'enfants', 'bebe'].forEach(type => {
        const plusBtn = document.getElementById(`${type}-plus`);
        const moinsBtn = document.getElementById(`${type}-moins`);

        if (plusBtn && moinsBtn) {
            plusBtn.addEventListener('click', () => change(type, 1));
            moinsBtn.addEventListener('click', () => change(type, -1));
        }
    });

    // Changer les quantités
    function change(type, delta) {
        const span = document.getElementById(type);
        let value = parseInt(span.textContent) + delta;

        if (type === 'adultes' && value < 1) value = 1;
        else if (value < 0) value = 0;

        span.textContent = value;
        updateResume();
    }

    // Mettre à jour le résumé
    function updateResume() {
        const adultes = parseInt(document.getElementById('adultes').textContent);
        const enfants = parseInt(document.getElementById('enfants').textContent);
        const bebe = parseInt(document.getElementById('bebe').textContent);

        const resumeText =
            `${adultes} Adulte${adultes > 1 ? 's' : ''} · ` +
            `${enfants} Enfant${enfants > 1 ? 's' : ''} · ` +
            `${bebe} Bébé${bebe > 1 ? 's' : ''}`;

        document.getElementById('resume').textContent = resumeText;
    }

    // Initialisation au chargement
    updateResume();
});
