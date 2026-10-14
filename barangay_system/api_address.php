<?php require_once "header.php"; ?>
<h2>🗺️ PSGC Address Explorer</h2>
<p style="color:#666;">
    Explore the Philippine Standard Geographic Code (PSGC) data — regions, provinces,
    cities, and barangays — fetched live from the API.
</p>

<p>
    <button onclick="loadRegionsAsync()">Load Regions (async/await)</button>
    <button onclick="loadRegionsPromise()" class="view-button">Load Regions (Promises)</button>
</p>

<p id="loading" class="loading">Loading data…</p>
<p id="statusMsg"></p>
<div id="results" class="grid"></div>

<script>
const loading   = document.getElementById("loading");
const results   = document.getElementById("results");
const statusMsg = document.getElementById("statusMsg");

function renderRegions(data) {
    results.innerHTML = "";
    if (!data || data.length === 0) {
        statusMsg.innerHTML = '<p class="message info">No regions found.</p>';
        return;
    }
    statusMsg.innerHTML = `<p class="message success">${data.length} region(s) loaded.</p>`;

    data.forEach(r => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
            <h4>${r.name}</h4>
            <small><strong>Code:</strong> ${r.code}</small>
            <small><strong>Region Name:</strong> ${r.regionName || r.name}</small>
        `;
        results.appendChild(card);
    });
}

/* ---------- async / await version ---------- */
async function loadRegionsAsync() {
    loading.style.display = "block";
    statusMsg.innerHTML = "";
    results.innerHTML   = "";

    try {
        const res = await fetch("https://psgc.cloud/api/regions/");
        if (!res.ok) throw new Error("HTTP " + res.status);
        const data = await res.json();
        renderRegions(data);
    } catch (err) {
        statusMsg.innerHTML = `<p class="message error">Error: ${err.message}</p>`;
        console.error(err);
    } finally {
        loading.style.display = "none";
    }
}

/* ---------- Promise chain version ---------- */
function loadRegionsPromise() {
    loading.style.display = "block";
    statusMsg.innerHTML = "";
    results.innerHTML   = "";

    fetch("https://psgc.cloud/api/regions/")
        .then(res => {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.json();
        })
        .then(data => renderRegions(data))
        .catch(err => {
            statusMsg.innerHTML = `<p class="message error">Error: ${err.message}</p>`;
            console.error(err);
        })
        .finally(() => { loading.style.display = "none"; });
}
</script>
<?php require_once "footer.php"; ?>