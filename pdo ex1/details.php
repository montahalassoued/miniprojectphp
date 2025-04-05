<?php
include("studentdata.php");
if (!isset($_GET['id'])) {
    die("ID manquant dans l'URL");
}
$id = (int)$_GET['id'];
if ($id <= 0) {
    die("ID invalide");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person's information</title>
    <meta name="description" content="Page description">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="containr mt-<s4">
    <table class="table table-success table-striped">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Birthday</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $query= $mysqli->prepare("SELECT * FROM student WHERE id = ?");
    $query->bind_param("i",$id);
    $query->execute();
    $resultat=$query->get_result();
    if($resultat){
     while($row=$resultat->fetch_assoc()){
    echo "<tr>";
      echo "<td>".$row['id']."</td>";
      echo"<td>".$row['name']."</td>";
      echo "<td>".$row['date_naissance']."</td>";
      echo "</tr>";
     }}
