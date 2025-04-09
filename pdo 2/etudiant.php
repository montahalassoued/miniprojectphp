<?php
include 'data.php';
$mysqli = new mysqli("localhost", "root", "", "newdata");
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


?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Students Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style2.css" rel="stylesheet">
</head>
<body>
 
  <div class="container mt-4">
    <h5>Liste des étudiants</h5>

    
    <div class="d-flex gap-2 mb-3">
      <button class="btn btn-outline-secondary">Copy</button>
      <button class="btn btn-outline-secondary">Excel</button>
      <button class="btn btn-outline-secondary">CSV</button>
      <button class="btn btn-outline-secondary">PDF</button>
    </div>

    <div class="d-flex justify-content-end mb-3">
      <input type="search" class="form-control w-25" placeholder="Search">
    </div>
  </div>
    <div class="containr mt-4">
    <table class="table">
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
    $requete="SELECT * FROM etudiant";
    $resultat=$mysqli->query($requete);

    if($resultat){
     while($row=$resultat->fetch_assoc()){
    echo "<tr>";
      echo "<td>".$row['id']."</td>";
      $imageData = base64_encode($row['image']);
      $src = 'data:image/jpeg;base64,' . $imageData;
      echo "<td><img src='{$src}' alt='Photo' width='50' height='50'></td>";
      echo"<td>".$row['name']."</td>";
      echo "<td>".$row['birthday']."</td>";
      echo "<td>".$row['section']."</td>";
      echo "<td>
      <a class='btn btn-info btn-sm' href='details.php?id=".$row['id']."'>Voir détails</a>
      <a class='btn btn-danger btn-sm' href='delete.php?id=".$row['id']."' onclick='return confirm(\"Supprimer cet étudiant ?\")'>Supprimer</a>
      <a class='btn btn-warning btn-sm' href='edit.php?id=".$row['id']."'>Modifier</a>
    </td>";
    
     }}
    ?>
  </tbody>
</table>
</body>
</html>