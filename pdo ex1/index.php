<?php
include("studentdata.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATA</title>
    <meta name="description" content="Page description">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="containr mt-4">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Birthday</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $requete="SELECT * FROM student";
    $resultat=$mysqli->query($requete);
    if($resultat){
     while($row=$resultat->fetch_assoc()){
    echo "<tr>";
      echo "<td>".$row['id']."</td>";
      echo"<td>".$row['name']."</td>";
      echo "<td>".$row['date_naissance']."</td>";
      echo "<td><a class='btn btn-primary' href='details.php?id=".$row['id']."'>Voir détails</a></td>";
      echo "</tr>";
     }}
    ?>
  </tbody>
</table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

