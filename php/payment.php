<?php
session_start();

if (!isset($_SESSION['current_voyage'])) {
    header("Location: voyager.php");
    exit();
}

$voyage_data = $_SESSION['current_voyage'];

$titre = htmlspecialchars($voyage_data['titre']);
$date_depart = date('d/m/Y', strtotime($voyage_data['dates']['depart']));
$date_retour = date('d/m/Y', strtotime($voyage_data['dates']['arrivee']));
$duree = $voyage_data['duree'];
$classe = htmlspecialchars(ucfirst($voyage_data['classe']));
$sans_escale = $voyage_data['sans_escale'] ? 'Oui' : 'Non';

// Calcul du prix total
$adultes = $voyage_data['passagers']['adultes'];
$enfants = $voyage_data['passagers']['enfants'];
$bebes = $voyage_data['passagers']['bebes'];
$prix_base = $voyage_data['prix'];

$prix_total = ($prix_base * $adultes) + ($prix_base * 0.7 * $enfants);

foreach ($voyage_data['options'] as $option) {
    $prix_total += ($option['prix'] * $adultes) + ($option['prix'] * $enfants * 0.7);
}

// Génération de l'identifiant de transaction
$transaction_id = strtoupper(bin2hex(random_bytes(5))); // Identifiant unique
$vendeur = "MI-2_J"; 
$retour = "http://localhost:1234/php/retour_paiement.php?status=accepted&montant={$montant_formate}&transaction={$transaction_id}&vendeur={$vendeur}&control={$control}";

// Fonction pour récupérer la clé API
function getAPIKey($vendeur)
{
	if(in_array($vendeur, array('MI-1_A', 'MI-1_B', 'MI-1_C', 'MI-1_D', 'MI-1_E', 'MI-1_F', 'MI-1_G', 'MI-1_H', 'MI-1_I', 'MI-1_J', 'MI-2_A', 'MI-2_B', 'MI-2_C', 'MI-2_D', 'MI-2_E', 'MI-2_F', 'MI-2_G', 'MI-2_H', 'MI-2_I', 'MI-2_J', 'MI-3_A', 'MI-3_B', 'MI-3_C', 'MI-3_D', 'MI-3_E', 'MI-3_F', 'MI-3_G', 'MI-3_H', 'MI-3_I', 'MI-3_J', 'MI-4_A', 'MI-4_B', 'MI-4_C', 'MI-4_D', 'MI-4_E', 'MI-4_F', 'MI-4_G', 'MI-4_H', 'MI-4_I', 'MI-4_J', 'MI-5_A', 'MI-5_B', 'MI-5_C', 'MI-5_D', 'MI-5_E', 'MI-5_F', 'MI-5_G', 'MI-5_H', 'MI-5_I', 'MI-5_J', 'MEF-1_A', 'MEF-1_B', 'MEF-1_C', 'MEF-1_D', 'MEF-1_E', 'MEF-1_F', 'MEF-1_G', 'MEF-1_H', 'MEF-1_I', 'MEF-1_J', 'MEF-2_A', 'MEF-2_B', 'MEF-2_C', 'MEF-2_D', 'MEF-2_E', 'MEF-2_F', 'MEF-2_G', 'MEF-2_H', 'MEF-2_I', 'MEF-2_J', 'MIM_A', 'MIM_B', 'MIM_C', 'MIM_D', 'MIM_E', 'MIM_F', 'MIM_G', 'MIM_H', 'MIM_I', 'MIM_J', 'SUPMECA_A', 'SUPMECA_B', 'SUPMECA_C', 'SUPMECA_D', 'SUPMECA_E', 'SUPMECA_F', 'SUPMECA_G', 'SUPMECA_H', 'SUPMECA_I', 'SUPMECA_J', 'TEST'))) {
		return substr(md5($vendeur), 1, 15);
	}
	return "zzzz";
}

$api_key = getAPIKey($vendeur);

// Format du montant
$montant_formate = number_format($prix_total, 2, '.', '');

// Calcul de la valeur de contrôle
$control = md5($api_key . "#" . $transaction_id . "#" . $montant_formate . "#" . $vendeur . "#" . $retour . "#");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>A.L.I.X. - Paiement</title>
    <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet" /><!---->
	<script src="../js/theme.js" defer></script><!---->
</head>
<body>
    <video class="fond" autoplay loop muted>
        <source src="../img/video.mp4" type="video/mp4">
    </video>

    <div class="top">
        <div class="topleft">
            <a href="index.php">
                <video id="logo-video" class="logo" autoplay muted>
                    <source src="../img/Logo-3-[cut](site).mp4" type="video/mp4">
                </video>
            </a>
        </div>
        <ul>
            <li><a href="aboutus.php">A propos</a></li>
            <li>|</li>
            <li><a href="voyager.php">Voyager</a></li>
            <li>|</li>
			<button id="theme-switch">Mode jour/nuit</button><!---->
        </ul>
    </div>

    <div class="en-tete"></div>

    <div class="flight">
        <h2 style="color:#00ffff;">Informations de votre voyage</h2>
        <p><strong>Destination :</strong> <?php echo $titre; ?></p>
        <p><strong>Départ :</strong> <?php echo $date_depart; ?></p>
        <p><strong>Retour :</strong> <?php echo $date_retour; ?></p>
        <p><strong>Durée :</strong> <?php echo $duree; ?> jours</p>
        <p><strong>Classe :</strong> <?php echo $classe; ?> Class</p>
        <p><strong>Sans escale :</strong> <?php echo $sans_escale; ?></p>
        <p><strong>Total à payer :</strong> <span style="color:#00ffff;font-size:20px;"><?php echo $prix_total; ?> €</span></p>
    </div>

    <div class="flight" style="margin-top: 30px;">
        <h2 style="color:#00ffff;">Informations de paiement</h2>
        <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
            <!-- Paramètres cachés pour le paiement -->
            <input type="hidden" name="transaction" value="<?php echo $transaction_id; ?>">
            <input type="hidden" name="montant" value="<?php echo $montant_formate; ?>">
            <input type="hidden" name="vendeur" value="<?php echo $vendeur; ?>">
            <input type="hidden" name="retour" value="<?php echo $retour; ?>">
            <input type="hidden" name="control" value="<?php echo $control; ?>">

            <button type="submit" class="class-btn">Payer <?= $montant_formate ?> €</button>
        </form>
    </div>

    <div class="bottom">
        <h1>Crédits</h1>
        <div class="textebot">
            <h2>Nassim</h2>
            <h2>Atahan</h2>
            <h2>Romain</h2>
            <h2>Gabin</h2>
        </div>
    </div>
</body>
</html>
