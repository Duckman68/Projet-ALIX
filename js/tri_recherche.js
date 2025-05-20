document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("sort-select");

    if (!select) return;

    select.addEventListener("change", function () {
        const critere = this.value;
        const container = document.querySelector(".flight ul");
        const voyages = Array.from(container.querySelectorAll(".voyage-item"));

        const compare = {
            "prix-asc": (a, b) => parseFloat(a.dataset.prix) - parseFloat(b.dataset.prix),
            "prix-desc": (a, b) => parseFloat(b.dataset.prix) - parseFloat(a.dataset.prix),
            "duree-asc": (a, b) => parseInt(a.dataset.duree) - parseInt(b.dataset.duree),
            "duree-desc": (a, b) => parseInt(b.dataset.duree) - parseInt(a.dataset.duree),
            "date-asc": (a, b) => new Date(a.dataset.date) - new Date(b.dataset.date),
            "date-desc": (a, b) => new Date(b.dataset.date) - new Date(a.dataset.date),
            "default": () => 0
        };

        voyages.sort(compare[critere]);
        voyages.forEach(voyage => container.appendChild(voyage));
    });
});
