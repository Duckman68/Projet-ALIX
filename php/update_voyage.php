<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération des données envoyées depuis le formulaire
    $voyageId = $_POST['voyage-id'] ?? '';
    $_SESSION['selected_voyage'] = $voyageId; // On stocke le voyage sélectionné

    $dateDebut = $_POST['date-voyage'] ?? '';
    $dateFin = $_POST['date-arrivée'] ?? '';
    $duree = '';

    // Calcul de la durée si les deux dates sont fournies
    if (!empty($dateDebut) && !empty($dateFin)) {
        $duree = (new DateTime($dateDebut))->diff(new DateTime($dateFin))->days;
    }

    // Chargement du fichier voyage.json
    $voyages_file = '../json/voyage.json';
    $voyages_json = file_get_contents($voyages_file);
    $voyages_data = json_decode($voyages_json, true);

    // Mise à jour des dates dans le voyage sélectionné
    foreach ($voyages_data['voyages'] as &$voyage) {
        if ($voyage['id'] === $voyageId) {
            $voyage['dates']['debut'] = $dateDebut;
            $voyage['dates']['fin'] = $dateFin;
            $voyage['dates']['duree_jours'] = $duree;
            break;
        }
    }

    // Sauvegarde du fichier JSON mis à jour
    file_put_contents($voyages_file, json_encode($voyages_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo "Les dates du voyage ont été mises à jour avec succès!";
} else {
    echo "Méthode non autorisée.";
}
?>
