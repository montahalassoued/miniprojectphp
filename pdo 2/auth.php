
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "newdata";
    
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
    
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Secure version using prepared statements
    $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND email=?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1) {
        // user go to home page
        header("Location: index.php"); 
        exit(); 
    }
    else {
       exit();
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Gestion Étudiants</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
  <form class="row g-3 login-form" method="POST" action="">
    <div class="col-12">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="lalla@example.com" required>
    </div>
    <div class="col-12">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="lalla" required>
    </div>
    <div class="col-12">
      <label for="username">Role</label>
      <input type="text" class="form-control" id="role" name="role" placeholder="etudiant/administrateur" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Confirm identity</button>
    </div>
    
  </form>
</body>
</html>


