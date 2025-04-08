<?php
include 'data.php';  // Connexion à la base de données
include 'etudiant.php';  // Inclusion de la classe Etudiant

include 'section.php';   // Inclusion de la classe Section
// Créer une instance de la classe Etudiant pour récupérer les étudiants
$etudiant = new Etudiant($conn);

// Préparer la requête pour récupérer les étudiants de cette section
$stmt = $conn->prepare("SELECT * FROM etudiant WHERE section = ?");
$stmt->bind_param("s", $designation);  // Lier la désignation de la section à la requête
$stmt->execute();
$result = $stmt->get_result();
 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Étudiants de la section <?= htmlspecialchars($section['designation']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Étudiants de la section : <?= htmlspecialchars($section['designation']) ?></h2>
  <p><?= htmlspecialchars($section['description']) ?></p>

  <!-- Tableau pour afficher les étudiants -->
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
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['birthday']) ?></td>
            <td>
              <?php
              // Vérifier si l'étudiant a une image
              if (!empty($row['image'])) {
                  $imageData = base64_encode($row['image']);
                  $src = 'data:image/jpeg;base64,' . $imageData;
                  echo '<img src="' . $src . '" width="50" height="50">';
              } 
              ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4">Aucun étudiant dans cette section.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Bouton pour revenir à la liste des sections -->
  <a href="section.php" class="btn btn-secondary mt-3">← Retour aux sections</a>
</div>
</body>
</html>
