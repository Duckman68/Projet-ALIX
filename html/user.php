<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$json_file = "../json/utilisateurs.json";

$json = file_get_contents($json_file);
$data = json_decode($json, true);

if ($data === null) {
    die("Erreur lors de la lecture du JSON");
}

$nom = $prenom = $email = $phone = $address = "";
$email = $_SESSION['email'];

foreach ($data["user"] as $user) {
    if ($user["email"] === $email) {
        $nom = $user["nom"];
        $prenom = $user["prenom"];
        $phone = $user["phone"];
        $address = $user["address"];
        $pp = $user["pp"];
        break;
    }
}

foreach ($data["admin"] as $admin) {
    if ($admin["email"] === $email) {
        $nom = $admin["nom"];
        $prenom = $admin["prenom"];
        $phone = $admin["phone"];
        $address = $admin["address"];
        $pp = $admin["pp"];
        break;
    }
}

if (empty($pp)) {
    $pp = "../img/default.png"; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['name'];
    $prenom = $_POST['name'];
    $email = $_POST['email'];
    $phone= $_POST['phone'];
    $address = $_POST['address'];

}

?>

<!DOCTYPE html>
<html>
<head>  
    <meta charset="UTF-8">
    <title>A.L.I.X.</title>
    <link href="../css/style.css" rel="stylesheet" />
</head>
<body>
    <video class="fond" autoplay loop muted>
        <source src="../img/video.mp4">
    </video>
    <div class="top">
        <div class="topleft">
            <img class="logo" src="../img/logo.png">
            <a href="index.html"><h1>A.L.I.X.</h1></a>
        </div>
        <ul>
            <li><a href="aboutus.html">A propos</a></li>
            <li>|</li>
            <li><a href="voyager.html">Voyager</a></li>
            <li>|</li>
            <li><a href="login.php">Connexion</a></li>
            <li>|</li>
            <li><a href="sign-up.php">Inscription</a></li>
            <li>|</li>
            <li><a href="admin.html">Bouton admin temporaire</a></li>
        </ul>
        <a href="user.php">
            <img src="<?php echo htmlspecialchars($pp); ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
		</a>
    </div>
    <div class="en-tete"></div>

    <div class="espace-profil">
        <section class="profil-form-login">
            <input type="image" src="<?php echo htmlspecialchars($pp); ?>" class="profil-img">
            <h2>Mon Profil</h2>
            
            <form method="POST" action="user.php">
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($nom . ' ' . $prenom); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Tél :</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                </div>
                <div class="form-group">
                    <label for="address">Adresse :</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">
                </div>
                <button type="submit" class="btn-submit">Mettre à jour</button>
            </form>
        </section>
    </div>

    <div class="espace-bottom-login"></div>
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


