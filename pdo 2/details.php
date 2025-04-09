<?php
session_start();
require_once 'data.php';




if (!isset($_GET['id'])) {
    echo "ID non fourni.";
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM etudiant WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$etudiant = $result->fetch_assoc();

if (!$etudiant) {
    echo "Étudiant introuvable.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Détails de l'étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h3>Détails de l'étudiant</h3>
        <p><strong>Nom :</strong> <?= htmlspecialchars($etudiant['name']) ?></p>
        <p><strong>Date de naissance :</strong> <?= htmlspecialchars($etudiant['birthday']) ?></p>
        <p><strong>Section :</strong> <?= htmlspecialchars($etudiant['section']) ?></p>
        <p><strong>Image :</strong><br>
            <img src="data:image/jpeg;base64,<?= base64_encode($etudiant['image']) ?>" width="100">
        </p>
        <a href="Home.php" class="btn btn-secondary">⬅ Retour</a>
    </div>
</body>
</html>
