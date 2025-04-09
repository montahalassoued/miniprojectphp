<?php
session_start();
include 'data.php';
include 'log.php';

if (!isLoggedIn()) {
    header("Location: auth.php");
    exit();
}

$homePage = isAdmin() ? "index-admin.php" : "index-user.php";
$studentListPage = isAdmin() ? "etudiant.php" : "user.php";
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
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top <?php echo isAdmin() ? 'admin' : ''; ?>">
    <div class="container-fluid">
        <span class="navbar-brand">Students Management System</span>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-3">
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === basename($homePage) ? 'active' : ''; ?>" href="<?php echo $homePage; ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === basename($studentListPage) ? 'active' : ''; ?>" href="<?php echo $studentListPage; ?>">Liste des étudiants</a></li>
                <li class="nav-item"><a class="nav-link" href="section.php">Liste des sections</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>