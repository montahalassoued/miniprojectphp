<?php
include 'data.php'; // ta connexion MySQL

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $requete = "SELECT image, type_image FROM etudiant WHERE id = $id";
    $resultat = $mysqli->query($requete);
    
    if ($resultat && $row = $resultat->fetch_assoc()) {
        header("Content-Type: " . $row['type_image']); // exemple : image/jpeg
        echo $row['image']; // contenu binaire
        exit;
    }
}
?>