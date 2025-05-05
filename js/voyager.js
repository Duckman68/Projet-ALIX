document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la sélection du voyage
    const voyageSelect = document.getElementById('voyage-select');
    const voyageIdInput = document.getElementById('voyage-id');
    
    voyageSelect.addEventListener('change', function() {
        voyageIdInput.value = this.value;
    });

    // Gestion des boutons de classe
    const classButtons = document.querySelectorAll('.class-btn');
    const flightClassInput = document.getElementById('flight-class');
    
    classButtons.forEach(button => {
        button.addEventListener('click', function() {
            classButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            flightClassInput.value = this.dataset.class;
        });
    });

    // Validation des dates
    const form = document.getElementById('voyage-form');
    form.addEventListener('submit', function(e) {
        const depart = document.querySelector('input[name="date-voyage"]');
        const arrivee = document.querySelector('input[name="date-arrivee"]');
        
        if (new Date(arrivee.value) <= new Date(depart.value)) {
            alert("La date d'arrivée doit être après la date de départ");
            e.preventDefault();
        }
    });
});

function changeValue(type, delta) {
    const element = document.getElementById(type);
    let value = parseInt(element.textContent) + delta;
    
    if (value < 0) value = 0;
    if (type === 'adultes' && value < 1) value = 1;
    
    element.textContent = value;
}