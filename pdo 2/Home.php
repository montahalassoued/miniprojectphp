<?php
include("data.php");

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
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Students Management System</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-3">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Liste des étudiants</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Liste des sections</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-4">
    <h5>Liste des étudiants</h5>

    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Veuillez renseigner votre recherche">
      <button class="btn btn-danger">Filtrer</button>
      <button class="btn btn-outline-primary ms-2">
        <i class="bi bi-person-plus"></i> Ajouter
      </button>
    </div>

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
      echo "<td><a class='btn btn-primary' href='details.php?id=".$row['id']."'>Voir détails</a>
      <a class='btn btn-primary' href='details.php?id=".$row['id']."'>Delete</a>
      <a class='btn btn-primary' href='details.php?id=".$row['id']."'>Update</a>

      </td>";
     }}
    ?>
  </tbody>
</table>
</body>
</html>