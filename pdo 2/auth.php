
<?php
include 'data.php'; // Include the database connection file
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "newdata";
    
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
    
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND email=? AND password=?");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        header("Location: index.php");
        exit();
    } else {
        echo "Identifiants incorrects.";
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
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="*********" required>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Confirm identity</button>
    </div>
    
  </form>
</body>
</html>


