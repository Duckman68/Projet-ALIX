<?php
session_start();

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

        // Vérifie que les données de session sont bien présentes
        if (isset($_SESSION['email']) && isset($_SESSION['current_voyage'])) {
            $email = $_SESSION['email'];
            $voyage = $_SESSION['current_voyage'];

            $fichier_utilisateurs = '../json/utilisateurs.json';
            $utilisateurs = json_decode(file_get_contents($fichier_utilisateurs), true);

            $trouve = false;

            // Cherche dans les admins
            foreach ($utilisateurs['admin'] as &$admin) {
                if (isset($admin['email']) && $admin['email'] === $email) {
                    if (!isset($admin['voyage']['achetes'])) {
                        $admin['voyage']['achetes'] = [];
                    }
                    $admin['voyage']['achetes'][] = $voyage;
                    $trouve = true;
                    break;
                }
            }

            // Cherche dans les users si non trouvé chez les admins
            if (!$trouve) {
                foreach ($utilisateurs['user'] as &$user) {
                    if (isset($user['email']) && $user['email'] === $email) {
                        if (!isset($user['voyage']['achetes'])) {
                            $user['voyage']['achetes'] = [];
                        }
                        $user['voyage']['achetes'][] = $voyage;
                        break;
                    }
                }
            }

            file_put_contents($fichier_utilisateurs, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Nettoie la session si nécessaire
            unset($_SESSION['current_voyage']);
        } else {
            echo "Erreur : utilisateur non connecté ou voyage non défini.";
            exit(); // Empêche la redirection
        }

        // Aucune sortie avant cette ligne sinon header() échoue
        header("Location: index.php");
        exit();

    } elseif ($status === "declined") {
        echo "Paiement refusé pour la transaction : $transaction_id";
    } else {
        echo "Statut inconnu pour la transaction : $transaction_id";
    }
} else {
    echo "Paramètres de retour incomplets.";
}
?>
