<?php  
session_start(); 
include 'data.php';       
include 'log.php';

if (!isLoggedIn()) {
    header("Location: auth.php");
    exit();
}

// Connexion BD => $mysqli
class Section {
    public $id;
    public $designation;
    public $description;
    
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function create($designation, $description) {
        $stmt = $this->conn->prepare("INSERT INTO section (designation, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $designation, $description);
        return $stmt->execute();
    }
    
    public function getAll() {
        return $this->conn->query("SELECT * FROM section");
    }
    
    public function update($id, $designation, $description) {
        $stmt = $this->conn->prepare("UPDATE section SET designation=?, description=? WHERE id=?");
        $stmt->bind_param("ssi", $designation, $description, $id);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM section WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

$sectionObj = new Section($conn);
$sections = $sectionObj->getAll();

$homePage = isAdmin() ? "index-admin.php" : "index-user.php";
$studentListPage = isAdmin() ? "etudiant.php" : "user.php";
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Liste des sections</title>
  <link href="style.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <span class="navbar-brand">Students Management System</span>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-3">
          <li class="nav-item"><a class="nav-link active" href="<?php echo $homePage; ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo $studentListPage; ?>">Liste des étudiants</a></li>
          <li class="nav-item"><a class="nav-link" href="section.php">Liste des sections</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5">
    <h2 class="mb-4 top">Liste des sections</h2>
    
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Désignation</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($section = $sections->fetch_assoc()): ?>
        <tr>
          <td><?= $section['id'] ?></td>
          <td><?= htmlspecialchars($section['designation']) ?></td>
          <td><?= htmlspecialchars($section['description']) ?></td>
          <td>
            <a href="etudiants_par_section.php?designation=<?= urlencode($section['designation']) ?>" class="btn btn-primary">Liste étudiant</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>