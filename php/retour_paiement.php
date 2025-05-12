<?php
// Vérification des paramètres retournés par la plateforme de paiement
if (isset($_GET['transaction']) && isset($_GET['status']) && isset($_GET['montant'])) {
    $transaction_id = htmlspecialchars($_GET['transaction']);
    $status = htmlspecialchars($_GET['status']);
    $montant = htmlspecialchars($_GET['montant']);
    $vendeur = htmlspecialchars($_GET['vendeur']);
    $control_reçu = htmlspecialchars($_GET['control']);

    // Vérification du montant (s'assurer que c'est un nombre valide)
    if (!is_numeric($montant) || !preg_match("/^\d+(\.\d{2})?$/", $montant)) {
        echo "Montant invalide pour la transaction : " . $transaction_id;
        exit();
    }

    // Vérification du contrôle avec la règle de hachage
    function verifyControl($transaction, $montant, $vendeur, $status) {
        $api_key = getAPIKey($vendeur);  // Récupérer la clé API
        $control_calculé = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");
        return $control_calculé;
    }

    // Vérification du contrôle
    $control_attendu = verifyControl($transaction_id, $montant, $vendeur, $status);
    if ($control_reçu !== $control_attendu) {
        echo "Erreur de vérification du contrôle. Les données sont corrompues.";
        exit();
    }

    // Traitement du paiement selon le statut
    if ($status == 'accepted') {
        echo "Paiement accepté pour la transaction : " . $transaction_id;
        // Mettre à jour la base de données ou effectuer des actions supplémentaires
    } elseif ($status == 'declined') {
        echo "Paiement refusé pour la transaction : " . $transaction_id;
    } else {
        echo "Statut de paiement inconnu pour la transaction : " . $transaction_id;
    }
} else {
    echo "Aucune donnée de paiement reçue.";
}
?>
