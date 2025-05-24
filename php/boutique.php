<?php
session_start();

$pp = "../img/default.png";
$isLoggedIn = false;
$isAdmin = false;

if (isset($_SESSION['email'])) {
    $isLoggedIn = true;
    $json_file = "../json/utilisateurs.json";
    $data = json_decode(file_get_contents($json_file), true) ?: [];

    foreach ($data['admin'] ?? [] as $admin) {
        if ($admin['email'] === $_SESSION['email']) {
            $isAdmin = true;
            if (!empty($admin['pp'])) {
                $pp = $admin['pp'];
            }
            break;
        }
    }
    if (!$isAdmin) {
        foreach ($data['user'] ?? [] as $user) {
            if ($user['email'] === $_SESSION['email']) {
                if (!empty($user['pp'])) {
                    $pp = $user['pp'];
                }
                break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>A.L.I.X. — Boutique Galactique</title>
  <link id="theme-style" href="../css/style_nuit.css" rel="stylesheet">
  <script src="../js/theme.js" defer></script>
</head>
<body>

  <div class="top">
    <div class="topleft">
      <a href="index.php">
        <video class="logo" autoplay muted>
          <source src="../img/Logo-3-[cut](site).mp4" type="video/mp4">
        </video>
      </a>
    </div>
    <ul>
      <li><a href="aboutus.php">À propos</a></li><li>|</li>
      <li><a href="voyager.php">Voyager</a></li>
      <?php if (!$isLoggedIn): ?>
        <li>|</li><li><a href="login.php">Connexion</a></li><li>|</li>
        <li><a href="sign-up.php">Inscription</a></li>
      <?php else: ?>
        <?php if ($isAdmin): ?>
          <li>|</li><li><a href="admin.php">Admin</a></li>
        <?php endif; ?>
      <?php endif; ?>
      <li>|</li>
      <li><a href="panier.php" title="Panier">🛒</a></li>
      <button id="theme-toggle" class="theme-toggle" title="Changer le thème">☀️</button>
    </ul>
    <a href="user.php">
      <img src="<?= htmlspecialchars($pp) ?>" alt="Profil" class="pfp" onerror="this.src='../img/default.png'">
    </a>
  </div>

  <div class="en-tete"></div>
  <div class="boutique">
    <h1>Notre Boutique Galactique</h1>

    <div class="boutique-grid">
      <div class="produit-card">
        <img src="../img/produit1.jpg" alt="Produit 1">
        <h3>Produit 1</h3>
        <a href="produit/produit1.html" class="btn-voir">Voir</a>
      </div>
      <div class="produit-card">
        <img src="../img/produit2.jpg" alt="Produit 2">
        <h3>Produit 2</h3>
        <a href="produit/produit2.html" class="btn-voir">Voir</a>
      </div>
      <div class="produit-card">
        <img src="../img/produit3.jpg" alt="Produit 3">
        <h3>Produit 3</h3>
        <a href="produit/produit3.html" class="btn-voir">Voir</a>
      </div>
      <div class="produit-card">
        <img src="../img/produit4.jpg" alt="Produit 4">
        <h3>Produit 4</h3>
        <a href="produit/produit4.html" class="btn-voir">Voir</a>
      </div>
    </div>
  </div>

  <div class="espace-bottom-boutique"></div>

  <footer class="site-footer">
    <div class="footer-grid">
      <div class="footer-links">
        <h3>Liens rapides</h3>
        <ul>
          <li><a href="index.php">Accueil</a></li>
          <li><a href="voyager.php">Voyager</a></li>
          <li><a href="aboutus.php">À propos</a></li>
          <li><a href="panier.php">Panier</a></li>
        </ul>
        <div class="footer-social">
          <a href="https://www.linkedin.com/in/..." target="_blank"><img src="../img/link.png" alt="LinkedIn"></a>
          <a href="https://www.instagram.com/..." target="_blank"><img src="../img/insta.jpeg" alt="Instagram"></a>
          <a href="https://www.facebook.com/..." target="_blank"><img src="../img/facebook.png" alt="Facebook"></a>
          <a href="https://x.com/..." target="_blank"><img src="../img/X.jpeg" alt="X"></a>
        </div>
      </div>
      <div class="footer-contact">
        <h3>Contact</h3>
        <p><strong>Mail :</strong> <a href="mailto:contact@alix.com">contact@alix.com</a></p>
        <p><strong>Téléphone :</strong> +33 1 23 45 67 89</p>
        <p><strong>Adresse :</strong><br>
          <a href="https://www.google.com/maps/search/?api=1&amp;query=Avenue+des+Champs-%C3%89lys%C3%A9es,+75008+Paris"
             target="_blank">Avenue des Champs-Élysées, 75008 Paris</a>
        </p>
      </div>
      <div class="footer-newsletter">
        <h3>Newsletter</h3>
        <p>Inscrivez-vous pour recevoir nos offres :</p>
        <form class="newsletter-form" action="#" method="post">
          <input type="email" name="email" placeholder="Votre email" required>
          <button type="submit">S’abonner</button>
        </form>
      </div>
    </div>
    <div class="footer-bottom">
      <p class="footer-credits">Nassim | Atahan | Romain | Gabin</p>
      <p>© <?= date('Y') ?> A.L.I.X. — Tous droits réservés.</p>
      <button class="back-to-top" aria-label="Retour en haut"
              onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"></button>
    </div>
  </footer>
</body>
</html>
