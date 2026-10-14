<?php
require_once "pdo.php";
require_once "resident_functions.php";
require_once "header.php";

if (isset($_POST['add'])) {
    addClearance($pdo, $_POST['resident_id'],
                 $_POST['purpose'] ?? '',
                 $_POST['date_issued'],
                 $_POST['status']);
    header("Location: clearances.php?msg=" . urlencode("Clearance recorded."));
    exit;
}
if (isset($_POST['delete'])) {
    deleteClearance($pdo, $_POST['clearance_id']);
    header("Location: clearances.php?msg=" . urlencode("Clearance deleted."));
    exit;
}

$residents  = getAllResidents($pdo);
$clearances = getAllClearances($pdo);
?>
<h2>📄 Barangay Clearances</h2>

<?php if (isset($_GET['msg'])): ?>
    <p class="message success"><?= htmlspecialchars($_GET['msg']) ?></p>
<?php endif; ?>

<h3>Issue New Clearance</h3>
<form method="post">
    <p>Resident:
        <select name="resident_id" required>
            <option value="">-- Select --</option>
            <?php foreach ($residents as $r): ?>
                <option value="<?= $r['resident_id'] ?>"><?= htmlspecialchars($r['full_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>Purpose: <input type="text" name="purpose" required></p>
    <p>Date Issued: <input type="date" name="date_issued" value="<?= date('Y-m-d') ?>" required></p>
    <p>Status:
        <select name="status" required>
            <option>Pending</option><option>Issued</option><option>Rejected</option>
        </select>
    </p>
    <input type="submit" name="add" value="Save Clearance" class="add-button">
</form>

<h3 style="margin-top:30px;">Clearance Records</h3>
<table id="clearance-table" border="1">
<thead>
<tr><th>Resident</th><th>Purpose</th><th>Date Issued</th><th>Status</th><th>Action</th></tr>
</thead>
<tbody>
<?php foreach ($clearances as $c): ?>
<tr>
    <td><?= htmlspecialchars($c['full_name']) ?></td>
    <td><?= htmlspecialchars($c['purpose']) ?></td>
    <td><?= htmlspecialchars($c['date_issued']) ?></td>
    <td><?= htmlspecialchars($c['status']) ?></td>
    <td>
        <div class="actions">
            <form method="post" onsubmit="return confirm('Delete this clearance?')">
                <input type="hidden" name="clearance_id" value="<?= $c['clearance_id'] ?>">
                <input type="submit" value="Del" name="delete" class="delete-button">
            </form>
        </div>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php require_once "footer.php"; ?>