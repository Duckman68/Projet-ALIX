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

// Traitement de la mise à jour du rôle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['new_role'])) {
    $email = $_POST['email'];
    $new_role = $_POST['new_role'];
    
    // Mettre à jour le rôle dans le tableau "user"
    foreach ($data["user"] as &$user) {
        if ($user["email"] === $email) {
            $user["role"] = $new_role;
            break;
        }
    }
    
    // Sauvegarder les modifications
    file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

header("Location: admin.php");
exit();
?>