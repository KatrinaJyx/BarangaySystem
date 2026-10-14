<?php
require_once "pdo.php";
require_once "resident_functions.php";
require_once "header.php";

/* Handle add/delete inline */
if (isset($_POST['add'])) {
    addHousehold($pdo,
        trim($_POST['head']),
        (int)$_POST['count'],
        $_POST['contact'] ?? '',
        $_POST['region']   ?? '',
        $_POST['province'] ?? '',
        $_POST['citymun']  ?? '',
        $_POST['barangay'] ?? ''
    );
    header("Location: households.php?msg=" . urlencode("Household added."));
    exit;
}
if (isset($_POST['delete'])) {
    deleteHousehold($pdo, $_POST['household_id']);
    header("Location: households.php?msg=" . urlencode("Household deleted."));
    exit;
}
$rows = getAllHouseholds($pdo);
?>
<h2>🏠 Households</h2>

<?php if (isset($_GET['msg'])): ?>
    <p class="message success"><?= htmlspecialchars($_GET['msg']) ?></p>
<?php endif; ?>

<h3>Add Household</h3>
<form method="post">
    <p>Household Head: <input type="text" name="head" required></p>
    <p>Member Count: <input type="number" name="count" min="1" value="1" required></p>
    <p>Contact: <input type="text" name="contact"></p>
    <input type="submit" name="add" value="Save Household" class="add-button">
</form>

<h3 style="margin-top:30px;">List of Households</h3>
<table id="household-table" border="1">
<thead>
<tr><th>Household Head</th><th>Members</th><th>Contact</th><th>Barangay</th><th>Action</th></tr>
</thead>
<tbody>
<?php foreach ($rows as $r): ?>
<tr>
    <td><?= htmlspecialchars($r['household_head']) ?></td>
    <td><?= htmlspecialchars($r['member_count']) ?></td>
    <td><?= htmlspecialchars($r['contact']) ?></td>
    <td><?= htmlspecialchars($r['barangay']) ?></td>
    <td>
        <div class="actions">
            <form method="post" onsubmit="return confirm('Delete this household?')">
                <input type="hidden" name="household_id" value="<?= $r['household_id'] ?>">
                <input type="submit" value="Del" name="delete" class="delete-button">
            </form>
        </div>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php require_once "footer.php"; ?>