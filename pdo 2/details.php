<?php 
session_start(); 
require_once 'data.php';
include 'log.php';

if (!isset($_GET['id'])) {
    echo "ID non fourni.";
    exit(); 
}

if (!isLoggedIn()) {
    header("Location: auth.php");
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


$homePage = isAdmin() ? "index-admin.php" : "index-user.php";
$studentListPage = isAdmin() ? "etudiant.php" : "user.php";
$returnPage = $studentListPage;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Détails de l'étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> 
</head>
<body class="p-4">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <span class="navbar-brand">Students Management System</span>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?php echo $homePage; ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo $studentListPage; ?>">Liste des étudiants</a></li>
          <li class="nav-item"><a class="nav-link" href="section.php">Liste des sections</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
    <div class="container mt-5 pt-5"> 
        <h3 class="mb-4">Détails de l'étudiant</h3>
        <div class="card p-4 shadow-sm">
            <p class="mb-2"><strong>Nom :</strong> <?= htmlspecialchars($etudiant['name']) ?></p>
            <p class="mb-2"><strong>Date de naissance :</strong> <?= htmlspecialchars($etudiant['birthday']) ?></p>
            <p class="mb-2"><strong>Section :</strong> <?= htmlspecialchars($etudiant['section']) ?></p>
            <p class="mb-4"><strong>Image :</strong><br>
                <img src="data:image/jpeg;base64,<?= base64_encode($etudiant['image']) ?>" width="150" class="img-thumbnail">
            </p>
            <a href="<?php echo $returnPage; ?>" class="btn btn-secondary">⬅ Retour</a>
        </div>
    </div>
</body>
</html>