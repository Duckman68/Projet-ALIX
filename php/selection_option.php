<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['voyage-id'])) {
    header("Location: voyager.php");
    exit();
}

$voyage_id = $_POST['voyage-id'];
$dates = [
    'depart' => $_POST['date-voyage'],
    'arrivee' => $_POST['date-arrivee']
];

$voyages_data = json_decode(file_get_contents('../json/voyage.json'), true);
$etapes_data = json_decode(file_get_contents('../json/etapes.json'), true);
$options_data = json_decode(file_get_contents('../json/options.json'), true);

$selected_voyage = null;
foreach ($voyages_data['voyages'] as $voyage) {
    if ($voyage['id'] === $voyage_id) {
        $selected_voyage = $voyage;
        break;
    }
}

if (!$selected_voyage) {
    die("Voyage non trouvé");
}

$pp = "../../img/default.png";
$isLoggedIn = false;
$isAdmin = false;

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);

    if ($data !== null) {
        $email = $_SESSION['email'];
        
        foreach ($data["admin"] as $admin) {
            if ($admin["email"] === $email) {
                $isAdmin = true;
                if (!empty($admin["pp"])) {
                    $pp = $admin["pp"];
                }
                break;
            }
        }
        
        if (!$isAdmin) {
            foreach ($data["user"] as $user) {
                if ($user["email"] === $email) {
                    if (!empty($user["pp"])) {
                        $pp = $user["pp"];
                    }
                    break;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>A.L.I.X. - Options de voyage</title>
    <meta charset="UTF-8">
    <link href="../../../css/style.css" rel="stylesheet" />
</head>
<body>
    <div class="fondpage">
	<video class="fond" autoplay loop muted>
            <source src="../../../img/video.mp4">
        </video>
        <div class="topv2">
            <div class="topleft">
                <a href="index.php">
                    <video class="logo" autoplay muted>
                        <source src="../../../img/Logo-3-[cut](site).mp4" type="video/mp4">
                    </video>
                </a>
            </div>
            <ul>
                <li><a href="../../aboutus.php">A propos</a></li>
                <li>|</li>
                <li><a href="../../voyager.php">Voyager</a></li>
                <?php if (!$isLoggedIn): ?>
                    <li>|</li>
                    <li><a href="../../login.php">Connexion</a></li>
                    <li>|</li>
                    <li><a href="../../sign-up.php">Inscription</a></li>
                <?php else: ?>
                    <?php if ($isAdmin): ?>
                        <li>|</li>
                        <li><a href="admin.php">Admin</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <a href="../user.php">
                <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../../img/default.png'">
            </a>
        </div>

        <img class="imgplanete" src="../../../img/mercure2.jpg">
        <h1><?php echo htmlspecialchars($selected_voyage['titre']); ?></h1>
        <p class="voyage-dates">
            Du <?php echo date('d/m/Y', strtotime($dates['depart'])); ?> 
            au <?php echo date('d/m/Y', strtotime($dates['arrivee'])); ?>
        </p>

        <form id="options-form" action="paiement.php" method="POST">
            <input type="hidden" name="voyage-id" value="<?php echo htmlspecialchars($voyage_id); ?>">
            <input type="hidden" name="date-depart" value="<?php echo htmlspecialchars($dates['depart']); ?>">
            <input type="hidden" name="date-arrivee" value="<?php echo htmlspecialchars($dates['arrivee']); ?>">

            <?php foreach ($selected_voyage['etapes'] as $etape_id): 
                $current_etape = null;
                foreach ($etapes_data['etapes'] as $etape) {
                    if ($etape['id'] === $etape_id) {
                        $current_etape = $etape;
                        break;
                    }
                }
                if (!$current_etape) continue;
            ?>
            
            <div class="etape-container">
                <h2><?php echo htmlspecialchars($current_etape['titre']); ?></h2>
                <div class="options-container">
                    <?php foreach ($current_etape['options'] as $option_id): 
                        $current_option = null;
                        foreach ($options_data['options'] as $option) {
                            if ($option['id'] === $option_id) {
                                $current_option = $option;
                                break;
                            }
                        }
                        if (!$current_option) continue;
                    ?>
                    <label class="option-card">
                        <input type="radio" name="options[<?php echo $etape_id; ?>]" value="<?php echo $option_id; ?>" required>
                        <div class="option-content">
                            <div class="option-details">
                                <h3><?php echo implode(', ', $current_option['activités']); ?></h3>
                                <p class="price"><?php echo $current_option['prix_par_personne']; ?> € / personne</p>
                            </div>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="form-actions">
                <button type="submit" class="btn-envoyer">Passer au paiement</button>
            </div>
        </form>










    <div class="bottom">
		<h1>Crédits</h1>
		<div class="textebot">
			<h2>Nassim</h2>
			<h2>Atahan</h2>
			<h2>Romain</h2>
			<h2>Gabin</h2>
		</div>
	</div>
	</div>
	



</body>
</html>
