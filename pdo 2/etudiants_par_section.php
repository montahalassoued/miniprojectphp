<?php
include 'data.php';  // Connexion à la base de données

// Récupérer la designation depuis l'URL
if (isset($_GET['designation'])) {
    $section = $_GET['designation'];
} else {
    die('Aucune section spécifiée.');
}

// Préparer la requête pour récupérer les étudiants de cette section
$stmt = $conn->prepare("SELECT * FROM etudiant WHERE section = ?");
if (!$stmt) {
    die("Erreur de préparation de la requête : " . $conn->error);
}

// Lier la désignation de la section à la requête
$stmt->bind_param("s", $section);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Étudiants de la section <?= htmlspecialchars($section) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Étudiants de la section : <?= htmlspecialchars($section) ?></h2>

  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Date de naissance</th>
        <th>Image</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['birthday'] ?></td>
            <td>
              <?php
              $imageData = base64_encode($row['image']);
              $src = 'data:image/jpeg;base64,' . $imageData;
              ?>
              <img src="<?= $src ?>" width="50" height="50">
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4">Aucun étudiant dans cette section.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <a href="section.php" class="btn btn-secondary mt-3">← Retour aux sections</a>
</div>
</body>
</html>
