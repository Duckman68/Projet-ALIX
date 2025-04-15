document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM
    const filterButtons = document.querySelectorAll('.bouton-recherche button');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const userRows = document.querySelectorAll('tbody tr');

    // Fonction pour filtrer par rôle
    function filterByRole(role) {
        userRows.forEach(row => {
            const rowRole = row.getAttribute('data-role');
            if (role === 'all' || rowRole === role) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Fonction pour rechercher par nom/prénom
    function searchUsers() {
        const searchTerm = searchInput.value.toLowerCase();
        
        userRows.forEach(row => {
            const name = row.cells[0].textContent.toLowerCase();
            const firstName = row.cells[1].textContent.toLowerCase();
            const isVisible = name.includes(searchTerm) || firstName.includes(searchTerm);
            
            // Considère aussi le filtre actif
            const currentFilter = document.querySelector('.bouton-recherche button.active')?.dataset.filter || 'all';
            const rowRole = row.getAttribute('data-role');
            const roleMatches = currentFilter === 'all' || rowRole === currentFilter;
            
            row.style.display = isVisible && roleMatches ? '' : 'none';
        });
    }

    // Gestion des boutons de filtre
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retire la classe active de tous les boutons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Ajoute la classe active au bouton cliqué
            this.classList.add('active');
            
            // Applique le filtre
            const filter = this.dataset.filter;
            filterByRole(filter);
        });
    });

    // Gestion de la recherche
    searchButton.addEventListener('click', searchUsers);
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            searchUsers();
        }
    });

    // Active le filtre "Tous" par défaut
    document.querySelector('.bouton-recherche button[data-filter="all"]').click();
});