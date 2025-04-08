<?php
session_start();
require_once 'data.php';
require_once 'log.php';



if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("DELETE FROM etudiant WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header("Location: Home.php");
  exit();
}
?>
