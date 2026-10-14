<?php
require_once "pdo.php";
require_once "resident_functions.php";
require_once "header.php";
$households = getAllHouseholds($pdo);
?>
<h2>➕ Add Resident</h2>

<div class="form-layout">
    <div class="form-main">
        <form method="post" action="resident_action.php"
              onsubmit="return confirm('Save this resident?')">

            <p>Full Name:<br>
                <input type="text" name="full_name" required maxlength="150">
            </p>
            <p>Age:<br>
                <input type="number" name="age" min="0" max="120" required>
            </p>
            <p>Gender:<br>
                <select name="gender" required>
                    <option value="">-- Select --</option>
                    <option>Male</option><option>Female</option><option>Other</option>
                </select>
            </p>
            <p>Contact:<br>
                <input type="text" name="contact">
            </p>
            <p>Civil Status:<br>
                <select name="civil_status" required>
                    <option>Single</option><option>Married</option>
                    <option>Widowed</option><option>Separated</option>
                </select>
            </p>
            <p>Household (optional):<br>
                <select name="household_id">
                    <option value="">-- None --</option>
                    <?php foreach ($households as $h): ?>
                        <option value="<?= $h['household_id'] ?>">
                            <?= htmlspecialchars($h['household_head']) ?>
                            (<?= $h['member_count'] ?> members)
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <h3>Address (PSGC API)</h3>
            <div class="addr-grid">
                <div>
                    <label for="region">Region :</label>
                    <select id="region" name="region">
                        <option value=""> -- Select Region --</option>
                    </select>
                </div>
                <div>
                    <label for="province">Province :</label>
                    <select id="province" name="province" disabled>
                        <option value=""> -- Select Province --</option>
                    </select>
                </div>
                <div>
                    <label for="citymun">City / Municipality :</label>
                    <select id="citymun" name="citymun" disabled>
                        <option value=""> -- Select City/Municipality --</option>
                    </select>
                </div>
                <div>
                    <label for="barangay">Barangay :</label>
                    <select id="barangay" name="barangay" disabled>
                        <option value=""> -- Select Barangay --</option>
                    </select>
                </div>
            </div>

            <p style="margin-top:20px;">
                <input type="submit" name="add" value="Save Resident" class="add-button">
                <a href="index.php" class="btn cancel-button">Cancel</a>
            </p>
        </form>
    </div>

    <div class="form-side">
        <div class="tip-box">
            <strong>📝 Guidelines</strong>
            <ul>
                <li>Enter the resident's legal full name.</li>
                <li>Age must match their record.</li>
                <li>Use the PSGC dropdowns to select the exact address.</li>
                <li>You can optionally link a resident to a household.</li>
            </ul>
        </div>
        <div class="tip-box tip-info">
            <strong>🗺️ How PSGC works</strong>
            <ul>
                <li>Region → Province → City/Municipality → Barangay</li>
                <li>Each level loads dynamically using Fetch API.</li>
                <li>Data is fetched from <code>psgc.cloud</code>.</li>
            </ul>
        </div>
    </div>
</div>

<script>
/* ============================================================
   PSGC cascading dropdowns — logic unchanged from Exercise 6
   ============================================================ */
const regionSelect   = document.getElementById("region");
const provinceSelect = document.getElementById("province");
const citymunSelect  = document.getElementById("citymun");
const barangaySelect = document.getElementById("barangay");

async function loadRegions() {
    try {
        const res = await fetch("https://psgc.cloud/api/regions/");
        const regions = await res.json();
        regions.forEach(region => {
            const opt = document.createElement("option");
            opt.value = region.code;
            opt.textContent = region.name;
            regionSelect.appendChild(opt);
        });
    } catch (error) {
        console.error("Error loading regions:", error);
    }
}

async function loadProvinces(regionCode) {
    provinceSelect.innerHTML = '<option value=""> -- Select Province --</option>';
    citymunSelect.innerHTML  = '<option value=""> -- Select City/Municipality --</option>';
    barangaySelect.innerHTML = '<option value=""> -- Select Barangay --</option>';
    citymunSelect.disabled  = true;
    barangaySelect.disabled = true;

    if (!regionCode) { provinceSelect.disabled = true; return; }

    try {
        const res = await fetch(`https://psgc.cloud/api/regions/${regionCode}/provinces/`);
        const provinces = await res.json();
        provinces.forEach(province => {
            const opt = document.createElement("option");
            opt.value = province.code;
            opt.textContent = province.name;
            provinceSelect.appendChild(opt);
        });
        provinceSelect.disabled = false;
    } catch (error) {
        console.error("Error loading provinces:", error);
    }
}

async function loadCitiesMunicipalities(provinceCode) {
    citymunSelect.innerHTML  = '<option value=""> -- Select City/Municipality --</option>';
    barangaySelect.innerHTML = '<option value=""> -- Select Barangay --</option>';
    barangaySelect.disabled  = true;

    if (!provinceCode) { citymunSelect.disabled = true; return; }

    try {
        const res = await fetch(`https://psgc.cloud/api/provinces/${provinceCode}/cities-municipalities/`);
        const citiesMun = await res.json();
        citiesMun.forEach(citymun => {
            const opt = document.createElement("option");
            opt.value = citymun.code;
            opt.textContent = citymun.name;
            citymunSelect.appendChild(opt);
        });
        citymunSelect.disabled = false;
    } catch (error) {
        console.error("Error loading cities/municipalities:", error);
    }
}

async function loadBarangays(cityMunCode) {
    barangaySelect.innerHTML = '<option value=""> -- Select Barangay --</option>';

    if (!cityMunCode) { barangaySelect.disabled = true; return; }

    try {
        const res = await fetch(`https://psgc.cloud/api/cities-municipalities/${cityMunCode}/barangays/`);
        const barangays = await res.json();
        barangays.forEach(barangay => {
            const opt = document.createElement("option");
            opt.value = barangay.code;
            opt.textContent = barangay.name;
            barangaySelect.appendChild(opt);
        });
        barangaySelect.disabled = false;
    } catch (error) {
        console.error("Error loading barangays:", error);
    }
}

regionSelect.addEventListener("change",   (e) => loadProvinces(e.target.value));
provinceSelect.addEventListener("change", (e) => loadCitiesMunicipalities(e.target.value));
citymunSelect.addEventListener("change",  (e) => loadBarangays(e.target.value));

/* Save the readable NAME (not code) on submit, by copying option text into a hidden field */
regionSelect.addEventListener("change", () => {
    document.querySelector('input[name="region_text"]')?.remove();
});
loadRegions();
</script>

<script>
/* Replace submitted code values with their text on form submit */
document.querySelector('form').addEventListener('submit', function () {
    ['region','province','citymun','barangay'].forEach(id => {
        const sel = document.getElementById(id);
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = id; // same name overwrites the select's value with text
        hidden.value = sel.options[sel.selectedIndex]?.text?.trim() || '';
        sel.removeAttribute('name'); // prevent duplicate POST
        this.appendChild(hidden);
    });
});
</script>

<?php require_once "footer.php"; ?>