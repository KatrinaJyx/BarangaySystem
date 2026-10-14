<?php require_once "session_check.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Barangay Resident Records System</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
</head>
<body>
<nav>
    <a href="index.php">👥 Residents</a>
    <a href="add.php">➕ Add Resident</a>
    <a href="households.php">🏠 Households</a>
    <a href="clearances.php">📄 Clearances</a>
    <a href="api_address.php">🗺️ PSGC Explorer</a>
    <a href="logout.php" style="margin-left:auto;">Logout</a>
</nav>
<div class="container">