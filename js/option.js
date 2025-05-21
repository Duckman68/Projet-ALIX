document.addEventListener('DOMContentLoaded', () => {
    const counters = {
        adultes: { count: 1, min: 1 },
        enfants: { count: 0, min: 0 },
        bebe:    { count: 0, min: 0 }
    };

    const prixBase = parseFloat(document.body.dataset.prixBase || 0);

    function updateDisplay() {
        document.getElementById('adultes').textContent = counters.adultes.count;
        document.getElementById('enfants').textContent = counters.enfants.count;
        document.getElementById('bebe').textContent = counters.bebe.count;

        document.getElementById('adultes-input').value = counters.adultes.count;
        document.getElementById('enfants-input').value = counters.enfants.count;
        document.getElementById('bebes-input').value = counters.bebe.count;

        document.getElementById('resume').textContent =
            `${counters.adultes.count} Adulte${counters.adultes.count > 1 ? 's' : ''} · ` +
            `${counters.enfants.count} Enfant${counters.enfants.count > 1 ? 's' : ''} · ` +
            `${counters.bebe.count} Bébé${counters.bebe.count > 1 ? 's' : ''}`;

        updateTotal();
    }

    function updateTotal() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="options"]');
    
        const nbAdultes = counters.adultes.count;
        const nbEnfants = counters.enfants.count;
        const nbBebes = counters.bebe.count;

        const coefEnfant = 0.7;
        const coefBebe = 0;


        let total = 0;
        total += prixBase * nbAdultes;
        total += prixBase * nbEnfants * coefEnfant;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                const card = cb.closest('.option-card');
                const prixElem = card.querySelector('p:last-of-type');
                if (prixElem) {
                    const prixStr = prixElem.textContent.match(/([\d,.]+)/);
                    if (prixStr) {
                        const prix = parseFloat(prixStr[1].replace(',', '.'));
                        if (!isNaN(prix)) {
                            total += prix * nbAdultes;
                            total += prix * nbEnfants * coefEnfant;
                        }
                    }
                }
            }
    });

    const prixSpan = document.getElementById('prix-valeur');
    if (prixSpan) {
        prixSpan.textContent = total.toFixed(2);
    }
}


    ['adultes', 'enfants', 'bebe'].forEach(type => {
        document.getElementById(`${type}-plus`).addEventListener('click', () => {
            counters[type].count++;
            updateDisplay();
        });

        document.getElementById(`${type}-moins`).addEventListener('click', () => {
            if (counters[type].count > counters[type].min) {
                counters[type].count--;
                updateDisplay();
            }
        });
    });

    document.querySelectorAll('input[type="checkbox"][name^="options"]').forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    updateDisplay();

    const boutonSelecteur = document.querySelector('.selecteur-bouton');
    const menuSelecteur = document.getElementById('menu-selecteur');

    if (boutonSelecteur && menuSelecteur) {
        boutonSelecteur.addEventListener('click', () => {
            menuSelecteur.classList.toggle('visible');
        });

        document.getElementById('terminer-btn').addEventListener('click', () => {
            menuSelecteur.classList.remove('visible');
        });
    }
});
