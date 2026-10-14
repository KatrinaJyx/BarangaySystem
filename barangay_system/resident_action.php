<?php
require_once "session_check.php";
require_once "pdo.php";
require_once "resident_functions.php";

/* DELETE */
if (isset($_POST['delete'])) {
    deleteResident($pdo, $_POST['resident_id']);
    header("Location: index.php?msg=" . urlencode("Resident deleted."));
    exit;
}

/* ADD */
if (isset($_POST['add'])) {
    addResident(
        $pdo,
        trim($_POST['full_name']),
        (int)$_POST['age'],
        $_POST['gender'],
        $_POST['contact'] ?? '',
        $_POST['civil_status'] ?? 'Single',
        $_POST['household_id'] ?: null,
        $_POST['region']   ?? '',
        $_POST['province'] ?? '',
        $_POST['citymun']  ?? '',
        $_POST['barangay'] ?? ''
    );
    header("Location: index.php?msg=" . urlencode("Resident added."));
    exit;
}

/* UPDATE */
if (isset($_POST['update'])) {
    updateResident(
        $pdo,
        $_POST['resident_id'],
        trim($_POST['full_name']),
        (int)$_POST['age'],
        $_POST['gender'],
        $_POST['contact'] ?? '',
        $_POST['civil_status'] ?? 'Single',
        $_POST['household_id'] ?: null,
        $_POST['region']   ?? '',
        $_POST['province'] ?? '',
        $_POST['citymun']  ?? '',
        $_POST['barangay'] ?? ''
    );
    header("Location: index.php?msg=" . urlencode("Resident updated."));
    exit;
}
?>