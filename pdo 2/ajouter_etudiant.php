<?php
session_start();
include("data.php");
include("log.php");

if (!isLoggedIn() || !isAdmin()) {
    header("Location: auth.php");
    exit();
}

// Connexion à la base de données
$mysqli = new mysqli("localhost", "root", "", "newdata");

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Récupérer toutes les sections pour le menu déroulant
$sectionsQuery = $mysqli->query("SELECT * FROM section");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ajouter un étudiant</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Students Management System</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-3">
          <li class="nav-item"><a class="nav-link active" href="index-admin.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="etudiant.php">Liste des étudiants</a></li>
          <li class="nav-item"><a class="nav-link" href="section.php">Liste des sections</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
</nav>

  <div class="container mt-4">
    <h3>Ajouter un étudiant</h3>

    <form action="ajouter_etudiant.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="id" class="form-label">ID de l'étudiant</label>
        <input type="number" class="form-control" id="id" name="id" required>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" id="name" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="birthday" class="form-label">Date de naissance</label>
        <input type="date" id="birthday" name="birthday" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" id="image" name="image" class="form-control">
      </div>

      <div class="mb-3">
        <label for="section" class="form-label">Section</label>
        <select id="section" name="section" class="form-control" required>
          <?php while ($section = $sectionsQuery->fetch_assoc()): ?>
            <option value="<?= $section['designation'] ?>"><?= htmlspecialchars($section['designation']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Ajouter l'étudiant</button>
    </form>
  </div>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];
    $id = $_POST['id'];
    

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        die("Erreur lors du téléchargement de l'image.");
    }


    $stmt = $mysqli->prepare("INSERT INTO etudiant (id, name, birthday, image, section) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssb", $id, $name, $birthday, $imageData, $section);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>L'étudiant a été ajouté avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'ajout de l'étudiant.</div>";
    }

    $stmt->close();
    $mysqli->close();
}
?>