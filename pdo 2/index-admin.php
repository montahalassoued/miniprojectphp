<?php
session_start();
include 'data.php';
include 'log.php';

if (!isLoggedIn() || !isAdmin()) {
    header("Location: auth.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<link href="style.css" rel="stylesheet">
<title>Gestion des étudiants</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Students Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index-admin.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="etudiant.php">Liste des étudiants</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="section.php">Liste des sections</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="main-message">
  <div class="text-center">
    <h1>HELLO, PHP LOVERS! Welcome to your administration Platform</h1>
    <h2>Admin Platform</h2>
  </div>
</div>
</body>
</html>