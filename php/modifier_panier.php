<?php
session_start();

if (isset($_POST['index']) && isset($_SESSION['panier'][$_POST['index']])) {
    // Modification depuis le panier
    $index = (int) $_POST['index'];
    $_SESSION['edition_index'] = $index;
    $_SESSION['edition_voyage'] = $_SESSION['panier'][$index];
    header("Location: selection_option.php?edit=1");
    exit();
}

if (isset($_POST['modifier_depuis_recap']) && isset($_SESSION['current_voyage'])) {
    // Modification depuis la page récapitulatif
    $_SESSION['edition_voyage'] = $_SESSION['current_voyage'];
    unset($_SESSION['edition_index']); // pas dans le panier donc pas besoin d’index
    header("Location: selection_option.php?edit=1");
    exit();
}

// Si aucun des cas valides
header("Location: panier.php");
exit();
