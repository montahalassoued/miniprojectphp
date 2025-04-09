<?php
session_start();
include 'data.php';
include 'log.php';

if (!isLoggedIn() || !isAdmin()) {
    header("Location: auth.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "newdata");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

class Etudiant {
    public $id;
    public $name;
    public $birthday;
    public $image;
    public $section_id;

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($name, $birthday, $image, $section_id) {
        $stmt = $this->conn->prepare("INSERT INTO etudiant (name, birthday, image, section_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $birthday, $image, $section_id);
        return $stmt->execute();
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM etudiant");
    }

    public function update($id, $name, $birthday, $image, $section_id) {
        $stmt = $this->conn->prepare("UPDATE etudiant SET name=?, birthday=?, image=?, section_id=? WHERE id=?");
        $stmt->bind_param("sssii", $name, $birthday, $image, $section_id, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM etudiant WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

$homePage = "index-admin.php";
$studentListPage = "etudiant.php";


$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $mysqli->real_escape_string($_GET['search']);
    $stmt = $mysqli->prepare("SELECT * FROM etudiant WHERE name LIKE ? OR section LIKE ?");
    $likeSearch = "%" . $search . "%";
    $stmt->bind_param("ss", $likeSearch, $likeSearch);
    $stmt->execute();
    $resultat = $stmt->get_result();
} else {
    $resultat = $mysqli->query("SELECT * FROM etudiant");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Students Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
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
 
  <div class="container mt-4">
    <h5>Liste des étudiants</h5>

    <div class="d-flex gap-2 mb-3">
      <button class="btn btn-outline-secondary">Copy</button>
      <button class="btn btn-outline-secondary">Excel</button>
      <button class="btn btn-outline-secondary">CSV</button>
      <button class="btn btn-outline-secondary">PDF</button>
    </div>

    <div class="input-group mb-3">
      <input type="text" class="form-control" id="filterInput" placeholder="Filtrer par nom ou section">
      <button class="btn btn-danger" onclick="filterTable()">Filtrer</button>
    </div>

    <div class="d-flex justify-content-end mb-3">
      <form method="GET" action="" class="d-flex">
        <input type="search" class="form-control me-2" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Rechercher">
        <button type="submit" class="btn btn-outline-primary">Rechercher</button>
      </form>
    </div>
  </div>
    <div class="container mt-4">
    <table class="table" id="studentTable">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">Birthday</th>
      <th scope="col">Section</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $requete = "SELECT * FROM etudiant" . $searchQuery;
    $resultat = $mysqli->query($requete);

    if ($resultat) {
        while ($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            $imageData = base64_encode($row['image']);
            $src = 'data:image/jpeg;base64,' . $imageData;
            echo "<td><img src='{$src}' alt='Photo' width='50' height='50'></td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['birthday'] . "</td>";
            echo "<td>" . $row['section'] . "</td>";
            echo "<td>
            <a class='btn btn-info btn-sm' href='details.php?id=" . $row['id'] . "'>Voir détails</a>
            <a class='btn btn-danger btn-sm' href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Supprimer cet étudiant ?\")'>Supprimer</a>
            <a class='btn btn-warning btn-sm' href='edit.php?id=" . $row['id'] . "'>Modifier</a>
          </td>";
        }
    }
    ?>
  </tbody>
</table>

<script>
function filterTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("filterInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("studentTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { 
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            var cell = td[j];
            if (cell) {
                txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}
</script>
</body>
</html>