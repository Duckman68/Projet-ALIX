<?php
if (
    isset($_GET['transaction']) &&
    isset($_GET['status']) &&
    isset($_GET['montant']) &&
    isset($_GET['vendeur']) &&
    isset($_GET['control'])
) {
    $transaction_id = $_GET['transaction'];
    $status = $_GET['status'];
    $montant = $_GET['montant'];
    $vendeur = $_GET['vendeur'];
    $control_recu = $_GET['control'];

    function getAPIKey($vendeur) {
        return substr(md5($vendeur), 1, 15);
    }

    $api_key = getAPIKey($vendeur);
    $control_calcule = md5($api_key . "#" . $transaction_id . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

    if ($control_calcule !== $control_recu) {
        echo "Erreur de vérification du contrôle. Les données sont corrompues.";
        exit();
    }

    if ($status === "accepted") {
        header("Location: index.php");
    } elseif ($status === "declined") {
        echo "Paiement refusé pour la transaction : $transaction_id";
    } else {
        echo "Statut inconnu pour la transaction : $transaction_id";
    }
} else {
    echo "Paramètres de retour incomplets.";
}
?>
