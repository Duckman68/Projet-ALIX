<?php
session_start();

$pp = "../img/default.png";
$isLoggedIn = false;
$isAdmin = false; // Nouvelle variable pour vérifier le statut admin

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../json/utilisateurs.json";
    $json = file_get_contents($json_file);
    $data = json_decode($json, true);

    if ($data !== null) {
        $email = $_SESSION['email'];
        
        // Vérification dans la section admin
        foreach ($data["admin"] as $admin) {
            if ($admin["email"] === $email) {
                $isAdmin = true;
                if (!empty($admin["pp"])) {
                    $pp = $admin["pp"];
                }
                break;
            }
        }
        
        // Si pas admin, vérification dans la section user
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
<html>
<head>
    <title>Voyager</title>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet" />

</head>
<body>
	<video class="fond" autoplay loop muted>
		<source src="../img/video2.mp4">
	</video>
	<div class="top">
		<div class="topleft">
			<a href="index.php">
				<video class="logo" autoplay muted>
					<source src="../img/Logo-3-[cut](site).mp4" type="video/mp4">
				</video>
			</a>
		</div>
		<ul>
			<li><a href="aboutus.php">A propos</a></li>
			<?php if (!$isLoggedIn): ?>
				<li>|</li>
				<li><a href="login.php">Connexion</a></li>
				<li>|</li>
				<li><a href="sign-up.php">Inscription</a></li>
			<?php else: ?>
				<?php if ($isAdmin): ?>
					<li>|</li>
					<li><a href="admin.php">Admin</a></li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
		<a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
		</a>
	</div>
	<div class="en-tete"></div>
    <div class="espace-voyager"></div>
	<section class="flight">    
        
        <div class="flight-inputs">
            <!--<select name="depart" id="depart">
    		<option value="#">Départ de</option>
    
    		<optgroup label="Système Solaire">
                	<option value="mercure">Mercure</option>
                	<option value="venus">Vénus</option>
                	<option value="terre">Terre</option>
        		<option value="mars">Mars</option>
        		<option value="jupiter">Jupiter</option>
        		<option value="saturne">Saturne</option>
        		<option value="uranus">Uranus</option>
        		<option value="neptune">Neptune</option>
    		</optgroup>
    
    		<optgroup label="Système innuendo">
        		<option value="solidays">Solidays</option>
        		<option value="we love green">We Love Green</option>
        		<option value="hellfest">Hellfest</option>
        		<option value="ardente">Ardente</option>
        		<option value="tomorrowland">Tomorrowland</option>
        		<option value="delta">Delta</option>
        		<option value="ihuma">Ihuma</option>
        		<option value="lollapalooza">Lollapalooza</option>
        		<option value="veillecharue">Veillecharue</option>
    		</optgroup>
    
    		<optgroup label="Système tou-doom">
        		<option value="scofield">Scofield</option>
        		<option value="tatooine">Tatooine</option>
        		<option value="spock">Spock</option>
        		<option value="gazorpazorp">Gazorpazorp</option>
        		<option value="croutard">Croutard</option>
        		<option value="star">Star</option>
        		<option value="eleven">Eleven</option>
        		<option value="ragnar">Ragnar</option>
        		<option value="spinjitsu">Spinjitsu</option>
        		<option value="razmo">Razmo</option>
    		</optgroup>
    
    		<optgroup label="Système IKEA">
        		<option value="malm">Malm</option>
              		<option value="friheten">Friheten</option>
              		<option value="knoxhult">Knoxhult</option>
              		<option value="tasjön">Tasjön</option>
              		<option value="lappdunort">Lappdunort</option>
              		<option value="skogssvingel">Skogssvingel</option>
              		<option value="ramsele">Ramsele</option>
              		<option value="ljungsbro">Ljungsbro</option>
              		<option value="tuvkornel">Tuvkornel</option>
              		<option value="slattika">Slattika</option>
              		<option value="akernejlika">Akernejlika</option>
            	</optgroup>
            </select>-->

            <select name="arrivee" id="arrivee">
                <option value="#">destination</option>
                
                <optgroup label="Système Solaire">
                	<option value="mercure">Mercure</option>
                	<option value="venus">Vénus</option>
                	<option value="terre">Terre</option>
        		<option value="mars">Mars</option>
        		<option value="jupiter">Jupiter</option>
        		<option value="saturne">Saturne</option>
        		<option value="uranus">Uranus</option>
        		<option value="neptune">Neptune</option>
    			</optgroup>
    
    		<optgroup label="Système Innuendo">
        		<option value="solidays">Solidays</option>
        		<option value="we love green">We Love Green</option>
        		<option value="hellfest">Hellfest</option>
        		<option value="ardente">Ardente</option>
        		<option value="tomorrowland">Tomorrowland</option>
        		<option value="delta">Delta</option>
        		<option value="ihuma">Ihuma</option>
        		<option value="lollapalooza">Lollapalooza</option>
        		<option value="veillecharue">Veillecharue</option>
    		</optgroup>
    
    		<optgroup label="Système Tou-Doom">
        		<option value="scofield">Scofield</option>
        		<option value="tatooine">Tatooine</option>
        		<option value="spock">Spock</option>
        		<option value="gazorpazorp">Gazorpazorp</option>
        		<option value="croutard">Croutard</option>
        		<option value="star">Star</option>
        		<option value="eleven">Eleven</option>
        		<option value="ragnar">Ragnar</option>
        		<option value="spinjitsu">Spinjitsu</option>
        		<option value="razmo">Razmo</option>
    		</optgroup>
    
    		<optgroup label="Système IKEA">
        		<option value="malm">Malm</option>
              		<option value="friheten">Friheten</option>
              		<option value="knoxhult">Knoxhult</option>
              		<option value="tasjön">Tasjön</option>
              		<option value="lappdunort">Lappdunort</option>
              		<option value="skogssvingel">Skogssvingel</option>
              		<option value="ramsele">Ramsele</option>
              		<option value="ljungsbro">Ljungsbro</option>
              		<option value="tuvkornel">Tuvkornel</option>
              		<option value="slattika">Slattika</option>
              		<option value="akernejlika">Akernejlika</option>
            	</optgroup>
            </select>
            
            <label for="date-voyage">Date de départ :</label>
			<input type="date" id="date-voyage" name="date-voyage">
			<label for="date-voyage">Date d'arrivée :</label>
			<input type="date" id="date-arrivée" name="date-arrivée">

			<table class="nbr-passager">
				<tr>
					<td class="passager">
						<div>
							<label>Adultes :</label>
							<button onclick="changeValue('adultes', -1)">-</button>
							<span id="adultes">1</span>
							<button onclick="changeValue('adultes', 1)">+</button> 
						</div>
					</td>
					<td class="passager">
						<div class="passager">
							<label>Enfants :</label>
							<button onclick="changeValue('enfants', -1)">-</button>
							<span id="enfants">0</span>
							<button onclick="changeValue('enfants', 1)">+</button> 
						</div>
					</td>
					<td class="passager">
						<div class="passager">
							<label>Bébés :</label>
							<button onclick="changeValue('bebes', -1)">-</button>
							<span id="bebes">0</span>
							<button onclick="changeValue('bebes', 1)">+</button> 
						</div>
					</td>
				</tr>
			</table>
			</div>
		<input type="checkbox" id="no-escale">
		<label for="no-escale">Sans escale</label> 
		<div class="flight-class">
            <button class="class-btn">Economy Class</button>
            <button class="class-btn">Business Class</button>
            <button class="class-btn">First Class</button>
        </div>
            <button class="search-btn">Rechercher</button>
    </section>
	<div class="espace-bottom-voyager"></div>
	<div class="systemes">
		<table class="systemes">
			<tr>
				<td class="voy-solaire"><a href="#"><h1>Système Solaire</h1></a></td>
				<td class="voy-innuendo"><a href="#"><h1>Système Innuendo</h1></a></td>
				<td class="voy-tou-doom"><a href="#"><h1>Système Tou-Doom</h1></a></td>
				<td class="voy-ikea"><a href="#"><h1>Système IKEA</h1></a></td>
			</tr>
		</table>
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