<?php
session_start();

//mettre les infos du compte appeler

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['address'] = $_POST['address'];
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
            <li><a href="login_form.html">Connexion</a></li>
            <li>|</li>
            <li><a href="sign-up.html">Inscription</a></li>
            <li>|</li>
            <li><a href="admin.html">Bouton admin temporaire</a></li>
        </ul>
        <a href="user.php">
            <img src="../img/icon.png" alt="Profil" class="pfp">
        </a>
    </div>
    <div class="en-tete"></div>

    <div class="espace-profil">
        <section class="profil-form-login">
            <input type="image" src="../img/icon.jpg" class="profil-img">
            <h2>Mon Profil</h2>
            
            <form method="POST" action="user.php">
                <div class="form-group">
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="user" value="<?php echo htmlspecialchars($_SESSION['user']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Tél :</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($_SESSION['phone']); ?>">
                </div>
                <div class="form-group">
                    <label for="address">Adresse :</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['address']); ?>">
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


