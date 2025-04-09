<?php
session_start();
require_once 'data.php';




if (!isset($_GET['id'])) {
    echo "ID non fourni.";
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $section = $_POST['section'];

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $stmt = $conn->prepare("UPDATE etudiant SET name=?, birthday=?, section=?, image=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $birthday, $section, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE etudiant SET name=?, birthday=?, section=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $birthday, $section, $id);
    }

    $stmt->execute();
    header("Location: etudiant.php");
    exit();
}

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
    <title>Modifier étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h3>Modifier un étudiant</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($etudiant['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date de naissance</label>
                <input type="date" name="birthday" class="form-control" value="<?= htmlspecialchars($etudiant['birthday']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Section</label>
                <input type="text" name="section" class="form-control" value="<?= htmlspecialchars($etudiant['section']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Image (laisser vide pour garder l’ancienne)</label>
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">💾 Enregistrer</button>
            <a href="etudiant.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
