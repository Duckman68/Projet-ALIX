<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $voyageId = $_POST['voyage-id'] ?? '';
    $dateDebut = $_POST['date-voyage'] ?? '';
    $dateFin = $_POST['date-arrivée'] ?? '';
    $duree = '';

    if (!empty($dateDebut) && !empty($dateFin)) {
        $duree = (new DateTime($dateDebut))->diff(new DateTime($dateFin))->days;
    }

    $voyages_file = '../json/voyage.json';
    $voyages_json = file_get_contents($voyages_file);
    $voyages_data = json_decode($voyages_json, true);

   
    foreach ($voyages_data['voyages'] as &$voyage) {
        if ($voyage['id'] === $voyageId) {
            $voyage['dates']['debut'] = $dateDebut;
            $voyage['dates']['fin'] = $dateFin;
            $voyage['dates']['duree_jours'] = $duree;
            break;
        }
    }


    file_put_contents($voyages_file, json_encode($voyages_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo "Les dates du voyage ont été mises à jour avec succès!";
} else {
    echo "Méthode non autorisée.";
}
?>
