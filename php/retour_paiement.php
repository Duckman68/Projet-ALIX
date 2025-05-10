<?php
// Vérifier les paramètres retournés par la plateforme de paiement
if (isset($_GET['transaction']) && isset($_GET['status'])) {
    $transaction_id = $_GET['transaction'];
    $status = $_GET['status']; // Le statut peut être "success", "failed", etc.
    
    // Vérifier si la transaction est réussie
    if ($status == 'success') {
        // Mettre à jour la base de données, marquer le paiement comme effectué
        // Exemple : updateOrderStatus($transaction_id, 'paid');
        echo "Paiement réussi pour la transaction : " . $transaction_id;
    } else {
        // En cas d'échec
        echo "Le paiement a échoué pour la transaction : " . $transaction_id;
    }
} else {
    echo "Aucune donnée de paiement reçue.";
}
?>
