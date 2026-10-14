<?php
require_once "pdo.php";
require_once "resident_functions.php";
$rows = getAllResidents($pdo);
require_once "header.php";
?>
<div class="topbar">
    <h1>👥 Resident Records</h1>
    <h3>Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'User') ?>!</h3>
</div>

<?php if (isset($_GET['msg'])): ?>
    <p class="message success"><?= htmlspecialchars($_GET['msg']) ?></p>
<?php endif; ?>

<table id="resident-table" border="1">
<thead>
<tr>
    <th>Full Name</th>
    <th>Age</th>
    <th>Gender</th>
    <th>Civil Status</th>
    <th>Barangay</th>
    <th>Household Head</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($rows as $r): ?>
<tr>
    <td><strong><?= htmlspecialchars($r['full_name']) ?></strong></td>
    <td><?= htmlspecialchars($r['age']) ?></td>
    <td><?= htmlspecialchars($r['gender']) ?></td>
    <td><?= htmlspecialchars($r['civil_status']) ?></td>
    <td><?= htmlspecialchars($r['barangay']) ?></td>
    <td><?= htmlspecialchars($r['household_head'] ?? '—') ?></td>
    <td>
        <div class="actions">
            <a href="edit.php?resident_id=<?= $r['resident_id'] ?>" class="btn edit-button">Edit</a>
            <form method="post" action="resident_action.php"
                  onsubmit="return confirm('Delete this resident?')">
                <input type="hidden" name="resident_id" value="<?= $r['resident_id'] ?>">
                <input type="submit" value="Del" name="delete" class="delete-button">
            </form>
        </div>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php require_once "footer.php"; ?>