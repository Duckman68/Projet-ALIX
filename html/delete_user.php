<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$json_file = "../json/utilisateurs.json";
$json = file_get_contents($json_file);
$data = json_decode($json, true);

if ($data === null) {
    die("Erreur de lecture du fichier JSON");
}

// Vérifier si l'utilisateur est admin
$isAdmin = false;
foreach ($data["admin"] as $admin) {
    if ($admin["email"] === $_SESSION['email']) {
        $isAdmin = true;
        break;
    }
}

if (!$isAdmin) {
    header("Location: index.php");
    exit();
}

// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // Supprimer l'utilisateur du tableau "user"
    foreach ($data["user"] as $key => $user) {
        if ($user["email"] === $email) {
            unset($data["user"][$key]);
            break;
        }
    }
    
    // Réindexer le tableau (pour éviter les trous dans les indices)
    $data["user"] = array_values($data["user"]);
    
    // Sauvegarder les modifications
    file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

header("Location: admin.php");
exit();
?>