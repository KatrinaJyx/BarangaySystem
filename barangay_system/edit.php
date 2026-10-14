<?php
require_once "pdo.php";
require_once "resident_functions.php";
require_once "header.php";

$resident_id = $_GET['resident_id'] ?? 0;
$r = getResidentById($pdo, $resident_id);
if (!$r) {
    echo "<p class='message error'>Resident not found.</p>";
    require_once "footer.php"; exit;
}
$households = getAllHouseholds($pdo);
?>
<h2>✏️ Edit Resident</h2>

<div class="form-layout">
    <div class="form-main">
        <form method="post" action="resident_action.php"
              onsubmit="return confirm('Update this record?')">
            <input type="hidden" name="resident_id" value="<?= $r['resident_id'] ?>">

            <p>Full Name:<br>
                <input type="text" name="full_name"
                       value="<?= htmlspecialchars($r['full_name']) ?>" required>
            </p>
            <p>Age:<br>
                <input type="number" name="age" min="0" max="120"
                       value="<?= htmlspecialchars($r['age']) ?>" required>
            </p>
            <p>Gender:<br>
                <select name="gender" required>
                    <?php foreach (['Male','Female','Other'] as $g): ?>
                        <option <?= $r['gender']==$g?'selected':'' ?>><?= $g ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>Contact:<br>
                <input type="text" name="contact"
                       value="<?= htmlspecialchars($r['contact']) ?>">
            </p>
            <p>Civil Status:<br>
                <select name="civil_status" required>
                    <?php foreach (['Single','Married','Widowed','Separated'] as $cs): ?>
                        <option <?= $r['civil_status']==$cs?'selected':'' ?>><?= $cs ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>Household:<br>
                <select name="household_id">
                    <option value="">-- None --</option>
                    <?php foreach ($households as $h): ?>
                        <option value="<?= $h['household_id'] ?>"
                            <?= $h['household_id']==$r['household_id']?'selected':'' ?>>
                            <?= htmlspecialchars($h['household_head']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <h3>Current Address</h3>
            <div class="addr-grid">
                <div>
                    <label>Region</label>
                    <input type="text" name="region" value="<?= htmlspecialchars($r['region']) ?>">
                </div>
                <div>
                    <label>Province</label>
                    <input type="text" name="province" value="<?= htmlspecialchars($r['province']) ?>">
                </div>
                <div>
                    <label>City / Municipality</label>
                    <input type="text" name="citymun" value="<?= htmlspecialchars($r['citymun']) ?>">
                </div>
                <div>
                    <label>Barangay</label>
                    <input type="text" name="barangay" value="<?= htmlspecialchars($r['barangay']) ?>">
                </div>
            </div>

            <p style="margin-top:20px;">
                <input type="submit" name="update" value="Update Resident" class="edit-button">
                <a href="index.php" class="btn cancel-button">Cancel</a>
            </p>
        </form>
    </div>

    <div class="form-side">
        <div class="tip-box">
            <strong>✏️ Editing</strong>
            <ul>
                <li>Update any field that changed.</li>
                <li>You can edit the address manually if needed.</li>
                <li>Click Save to apply changes.</li>
            </ul>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>