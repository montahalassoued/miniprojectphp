<?php
session_start(); 
include 'data.php';

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
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; 
        
        if (strtolower($user['role']) == 'admin') {
            header("Location: index-admin.php");
        } else {
            header("Location: index-user.php");
        }
        exit();
    } else {
        $error_message = "Identifiants incorrects.";
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
  <div class="container h-100 d-flex align-items-center justify-content-center">
    <div class="row">
      <div class="col-12">
        <?php if(isset($error_message)): ?>
          <div class="alert alert-danger text-center">
            <?php echo $error_message; ?>
          </div>
        <?php endif; ?>
        
        <form class="login-form" method="POST" action="">
          <h2 class="text-center mb-4">Connexion</h2>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="lalla@example.com" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="lalla" required>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <input type="text" class="form-control" id="role" name="role" placeholder="etudiant/administrateur" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="*********" required>
          </div>
          <button type="submit" class="btn btn-primary">Confirm identity</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>