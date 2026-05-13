<?php include '../includes/header.php'; ?>
<?php include '../includes/char_images.php'; ?>

<?php
$id   = (int)$_GET['id'];
$char = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Characters WHERE id = $id"));

if (!$char) {
    header('Location: /GTA_Projekt/characters/index.php');
    exit();
}

// ── SPEICHERN ────────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Basisdaten speichern
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $age     = (int)$_POST['age'];
    $role    = mysqli_real_escape_string($conn, $_POST['role']);
    mysqli_query($conn, "UPDATE Characters SET name='$name', surname='$surname', age=$age, role='$role' WHERE id=$id");

    // 2. Waffen — alte löschen, neue einfügen
    mysqli_query($conn, "DELETE FROM Character_Weapons WHERE characterId = $id");
    if (!empty($_POST['weapons'])) {
        foreach ($_POST['weapons'] as $wid) {
            $wid = (int)$wid;
            mysqli_query($conn, "INSERT INTO Character_Weapons (weaponId, characterId) VALUES ($wid, $id)");
        }
    }

    // 3. Locations — alte löschen, neue einfügen
    mysqli_query($conn, "DELETE FROM Character_Locations WHERE characterId = $id");
    if (!empty($_POST['locations'])) {
        foreach ($_POST['locations'] as $lid) {
            $lid = (int)$lid;
            mysqli_query($conn, "INSERT INTO Character_Locations (locationId, characterId) VALUES ($lid, $id)");
        }
    }

    // 4. Fahrzeuge — zuerst alle dieses Chars freigeben, dann neue zuweisen
    mysqli_query($conn, "UPDATE Vehicles SET character_id = NULL WHERE character_id = $id");
    if (!empty($_POST['vehicles'])) {
        foreach ($_POST['vehicles'] as $vid) {
            $vid = (int)$vid;
            mysqli_query($conn, "UPDATE Vehicles SET character_id = $id WHERE id = $vid");
        }
    }

    header('Location: /GTA_Projekt/characters/index.php?success=updated');
    exit();
}

// ── DATEN FÜR FORMULAR LADEN ─────────────────────────────────────────────────

// Aktuell zugewiesene Waffen
$charWeapons = [];
$r = mysqli_query($conn, "SELECT weaponId FROM Character_Weapons WHERE characterId = $id");
while ($row = mysqli_fetch_assoc($r)) $charWeapons[] = (int)$row['weaponId'];

// Aktuell zugewiesene Locations
$charLocations = [];
$r = mysqli_query($conn, "SELECT locationId FROM Character_Locations WHERE characterId = $id");
while ($row = mysqli_fetch_assoc($r)) $charLocations[] = (int)$row['locationId'];

// Aktuell zugewiesene Fahrzeuge
$charVehicles = [];
$r = mysqli_query($conn, "SELECT id FROM Vehicles WHERE character_id = $id");
while ($row = mysqli_fetch_assoc($r)) $charVehicles[] = (int)$row['id'];

// Charakter-Bild
$charImg = getCharacterImageOrSVG($char['name'], $char['surname'], $char['role']);
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=Barlow:wght@400;500;700&display=swap');

* { box-sizing: border-box; }
body { font-family: 'Barlow', sans-serif; }

/* ── PAGE HEADER ─────────────────────────────────────── */
.page-header {
    background: linear-gradient(180deg, #1a0000 0%, #0a0a0a 100%);
    padding: 40px 30px 30px;
    border-bottom: 1px solid #2a2a2a;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}
.page-header h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 30px;
    font-weight: 900;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: #fff;
    margin: 0;
}
.page-header h1 span { color: #e8291c; }
.page-header p { color: #555; font-size: 13px; margin-top: 6px; letter-spacing: 1px; }

.btn-back {
    background: #1a1a1a;
    color: #aaa;
    padding: 10px 22px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    border: 1px solid #333;
    transition: all 0.2s;
    white-space: nowrap;
}
.btn-back:hover { background: #252525; color: #fff; border-color: #555; }

/* ── LAYOUT ──────────────────────────────────────────── */
.edit-layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 24px;
    padding: 30px;
    max-width: 1200px;
    margin: 0 auto;
    align-items: start;
}

/* ── VORSCHAU-KARTE ───────────────────────────────────── */
.preview-card {
    background: #111;
    border: 1px solid #1e1e1e;
    border-radius: 10px;
    overflow: hidden;
    position: sticky;
    top: 20px;
}
.preview-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    object-position: top center;
    display: block;
    filter: brightness(0.85);
}
.preview-info { padding: 16px; border-top: 1px solid #1a1a1a; }
.preview-mini-label {
    font-size: 9px;
    color: #333;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 4px;
}
.preview-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 20px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.preview-surname { font-size: 12px; color: #555; margin-top: 2px; }
.preview-role {
    display: inline-block;
    margin-top: 10px;
    padding: 3px 10px;
    border-radius: 3px;
    font-size: 10px;
    font-weight: bold;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.role-main      { background: #2a1500; color: #ff8c00; border-left: 3px solid #ff8c00; }
.role-proto     { background: #1a0000; color: #e85555; border-left: 3px solid #e85555; }
.role-supporter { background: #001a00; color: #55cc55; border-left: 3px solid #55cc55; }

/* Mini-Tags in der Vorschau */
.preview-section { margin-top: 14px; padding-top: 14px; border-top: 1px solid #1a1a1a; }
.preview-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 6px; min-height: 20px; }
.preview-tag {
    display: inline-block;
    background: #1a1a1a;
    border: 1px solid #2a2a2a;
    color: #666;
    font-size: 10px;
    padding: 2px 7px;
    border-radius: 3px;
}

/* ── RECHTE SPALTE ────────────────────────────────────── */
.form-sections { display: flex; flex-direction: column; gap: 20px; }

/* ── SECTION CARD ─────────────────────────────────────── */
.section-card {
    background: #111;
    border: 1px solid #1e1e1e;
    border-radius: 10px;
    overflow: hidden;
}
.section-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #1a1a1a;
    display: flex;
    align-items: center;
    gap: 10px;
}
.header-gold  { background: linear-gradient(135deg, #1a1200, #111); }
.header-red   { background: linear-gradient(135deg, #1a0500, #111); }
.header-blue  { background: linear-gradient(135deg, #001220, #111); }
.header-green { background: linear-gradient(135deg, #001a08, #111); }

.section-icon { font-size: 20px; }
.section-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 16px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 3px;
    text-transform: uppercase;
}
.section-count {
    margin-left: auto;
    font-size: 11px;
    color: #444;
    letter-spacing: 1px;
}
.section-body { padding: 20px 22px; }

/* ── FORMULAR FELDER ──────────────────────────────────── */
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { margin-bottom: 16px; }
.form-group:last-child { margin-bottom: 0; }
.form-group label {
    display: block;
    font-size: 11px;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 7px;
    font-weight: bold;
}
.form-group input,
.form-group select {
    width: 100%;
    background: #0a0a0a;
    border: 1px solid #252525;
    border-radius: 6px;
    padding: 12px 14px;
    color: #fff;
    font-size: 14px;
    font-family: 'Barlow', sans-serif;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-group input:focus,
.form-group select:focus {
    border-color: #e8291c;
    box-shadow: 0 0 0 3px rgba(232,41,28,0.1);
}
.form-group select option { background: #111; }

/* ── CHECKBOX ITEMS ───────────────────────────────────── */
.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
    gap: 8px;
}

.cb-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #0a0a0a;
    border: 1px solid #1e1e1e;
    border-radius: 6px;
    padding: 10px 12px;
    cursor: pointer;
    transition: all 0.15s;
    user-select: none;
}
.cb-item:hover { border-color: #333; background: #0f0f0f; }

/* Aktiv-Zustände */
.cb-item.active-weapon   { border-color: #e85555; background: #1a0500; }
.cb-item.active-location { border-color: #5ba3f5; background: #001220; }
.cb-item.active-vehicle  { border-color: #55cc55; background: #001a08; }

.cb-item input[type="checkbox"] { display: none; }

.cb-check {
    width: 18px;
    height: 18px;
    border: 2px solid #333;
    border-radius: 4px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: bold;
    transition: all 0.15s;
    color: #fff;
}
.active-weapon   .cb-check { background: #e85555; border-color: #e85555; }
.active-location .cb-check { background: #5ba3f5; border-color: #5ba3f5; }
.active-vehicle  .cb-check { background: #55cc55; border-color: #55cc55; }

.cb-label { font-size: 13px; color: #777; line-height: 1.3; }
.active-weapon .cb-label,
.active-location .cb-label,
.active-vehicle .cb-label { color: #fff; }
.cb-sub { font-size: 10px; color: #444; margin-top: 2px; }

/* Fahrzeug einem anderen gehört → ausgegraut */
.cb-taken { opacity: 0.4; cursor: not-allowed; }

.empty-note { font-size: 13px; color: #333; font-style: italic; }

/* ── SPEICHERN BUTTON ─────────────────────────────────── */
.btn-submit {
    width: 100%;
    background: #e8291c;
    color: #fff;
    padding: 15px;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: bold;
    font-family: 'Barlow', sans-serif;
    letter-spacing: 3px;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-submit:hover { background: #c41f10; }

.alert-error {
    background: #1a0000;
    border: 1px solid #e8291c;
    color: #f05555;
    padding: 12px 16px;
    border-radius: 6px;
    font-size: 13px;
    margin-bottom: 16px;
}

@media (max-width: 800px) {
    .edit-layout { grid-template-columns: 1fr; }
    .preview-card { position: static; }
}
</style>

<!-- ── HEADER ── -->
<div class="page-header">
    <div>
        <h1>CHARAKTER <span>BEARBEITEN</span></h1>
        <p><?= htmlspecialchars($char['name'] . ' ' . $char['surname']) ?></p>
    </div>
    <a href="/GTA_Projekt/characters/index.php" class="btn-back">← Zurück</a>
</div>

<form method="POST" id="editForm">
<div class="edit-layout">

    <!-- ══════════ LINKE SPALTE: VORSCHAU ══════════ -->
    <div class="preview-card">
        <img class="preview-img"
             src="<?= htmlspecialchars($charImg['src']) ?>"
             alt="<?= htmlspecialchars($char['name']) ?>">
        <div class="preview-info">
            <div class="preview-mini-label">Vorschau</div>
            <div class="preview-name" id="prevName"><?= htmlspecialchars($char['name']) ?></div>
            <div class="preview-surname" id="prevSurname"><?= htmlspecialchars($char['surname']) ?></div>
            <span class="preview-role <?=
                $char['role'] === 'Main character' ? 'role-main' :
                ($char['role'] === 'Protagonist'   ? 'role-proto' : 'role-supporter')
            ?>" id="prevRole"><?= htmlspecialchars($char['role']) ?></span>

            <!-- Waffen-Tags -->
            <div class="preview-section">
                <div class="preview-mini-label">🔫 Waffen</div>
                <div class="preview-tags" id="prevWeapons">
                    <?php foreach ($charWeapons as $wid):
                        $w = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM Weapons WHERE id=$wid"));
                        if ($w): ?><span class="preview-tag"><?= htmlspecialchars($w['name']) ?></span><?php endif;
                    endforeach; ?>
                </div>
            </div>

            <!-- Location-Tags -->
            <div class="preview-section">
                <div class="preview-mini-label">📍 Locations</div>
                <div class="preview-tags" id="prevLocations">
                    <?php foreach ($charLocations as $lid):
                        $l = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM Locations WHERE id=$lid"));
                        if ($l): ?><span class="preview-tag"><?= htmlspecialchars($l['name']) ?></span><?php endif;
                    endforeach; ?>
                </div>
            </div>

            <!-- Fahrzeug-Tags -->
            <div class="preview-section">
                <div class="preview-mini-label">🚗 Fahrzeuge</div>
                <div class="preview-tags" id="prevVehicles">
                    <?php foreach ($charVehicles as $vid):
                        $v = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM Vehicles WHERE id=$vid"));
                        if ($v): ?><span class="preview-tag"><?= htmlspecialchars($v['name']) ?></span><?php endif;
                    endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ══════════ RECHTE SPALTE: FORMULAR ══════════ -->
    <div class="form-sections">

        <?php if (isset($error)): ?>
            <div class="alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- ── 1. BASISDATEN ── -->
        <div class="section-card">
            <div class="section-card-header header-gold">
                <span class="section-icon">✏️</span>
                <span class="section-title">Basisdaten</span>
            </div>
            <div class="section-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Vorname</label>
                        <input type="text" name="name" id="inputName"
                               value="<?= htmlspecialchars($char['name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nachname</label>
                        <input type="text" name="surname" id="inputSurname"
                               value="<?= htmlspecialchars($char['surname']) ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Alter</label>
                        <input type="number" name="age"
                               value="<?= (int)$char['age'] ?>" min="1" max="120" required>
                    </div>
                    <div class="form-group">
                        <label>Rolle</label>
                        <select name="role" id="inputRole" required>
                            <option value="Main character" <?= $char['role'] === 'Main character' ? 'selected' : '' ?>>Main character</option>
                            <option value="Protagonist"    <?= $char['role'] === 'Protagonist'    ? 'selected' : '' ?>>Protagonist</option>
                            <option value="Supporter"      <?= $char['role'] === 'Supporter'      ? 'selected' : '' ?>>Supporter</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── 2. WAFFEN ── -->
        <div class="section-card">
            <div class="section-card-header header-red">
                <span class="section-icon">🔫</span>
                <span class="section-title">Waffen</span>
                <span class="section-count" id="cntWeapon"><?= count($charWeapons) ?> ausgewählt</span>
            </div>
            <div class="section-body">
                <?php $allWeapons = mysqli_query($conn, "SELECT * FROM Weapons ORDER BY name");
                if (mysqli_num_rows($allWeapons) == 0): ?>
                    <p class="empty-note">Keine Waffen in der Datenbank.</p>
                <?php else: ?>
                <div class="checkbox-grid">
                <?php while ($w = mysqli_fetch_assoc($allWeapons)):
                    $active = in_array((int)$w['id'], $charWeapons) ? 'active-weapon' : '';
                ?>
                    <label class="cb-item <?= $active ?>"
                           data-type="weapon" data-name="<?= htmlspecialchars($w['name']) ?>">
                        <input type="checkbox" name="weapons[]"
                               value="<?= $w['id'] ?>" <?= $active ? 'checked' : '' ?>>
                        <div class="cb-check"><?= $active ? '✓' : '' ?></div>
                        <div>
                            <div class="cb-label"><?= htmlspecialchars($w['name']) ?></div>
                            <?php if (!empty($w['type'])): ?>
                                <div class="cb-sub"><?= htmlspecialchars($w['type']) ?></div>
                            <?php endif; ?>
                        </div>
                    </label>
                <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── 3. LOCATIONS ── -->
        <div class="section-card">
            <div class="section-card-header header-blue">
                <span class="section-icon">📍</span>
                <span class="section-title">Locations</span>
                <span class="section-count" id="cntLocation"><?= count($charLocations) ?> ausgewählt</span>
            </div>
            <div class="section-body">
                <?php $allLocations = mysqli_query($conn, "SELECT * FROM Locations ORDER BY name");
                if (mysqli_num_rows($allLocations) == 0): ?>
                    <p class="empty-note">Keine Locations in der Datenbank.</p>
                <?php else: ?>
                <div class="checkbox-grid">
                <?php while ($l = mysqli_fetch_assoc($allLocations)):
                    $active = in_array((int)$l['id'], $charLocations) ? 'active-location' : '';
                    // Prüfe welche Spalten Locations hat
                    $sub = $l['district'] ?? ($l['type'] ?? ($l['region'] ?? ''));
                ?>
                    <label class="cb-item <?= $active ?>"
                           data-type="location" data-name="<?= htmlspecialchars($l['name']) ?>">
                        <input type="checkbox" name="locations[]"
                               value="<?= $l['id'] ?>" <?= $active ? 'checked' : '' ?>>
                        <div class="cb-check"><?= $active ? '✓' : '' ?></div>
                        <div>
                            <div class="cb-label"><?= htmlspecialchars($l['name']) ?></div>
                            <?php if (!empty($sub)): ?>
                                <div class="cb-sub"><?= htmlspecialchars($sub) ?></div>
                            <?php endif; ?>
                        </div>
                    </label>
                <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── 4. FAHRZEUGE ── -->
        <div class="section-card">
            <div class="section-card-header header-green">
                <span class="section-icon">🚗</span>
                <span class="section-title">Fahrzeuge</span>
                <span class="section-count" id="cntVehicle"><?= count($charVehicles) ?> ausgewählt</span>
            </div>
            <div class="section-body">
                <?php
                $allVehicles = mysqli_query($conn,
                    "SELECT v.*, c.name AS owner_name
                     FROM Vehicles v
                     LEFT JOIN Characters c ON v.character_id = c.id
                     ORDER BY v.name"
                );
                if (mysqli_num_rows($allVehicles) == 0): ?>
                    <p class="empty-note">Keine Fahrzeuge in der Datenbank.</p>
                <?php else: ?>
                <div class="checkbox-grid">
                <?php while ($v = mysqli_fetch_assoc($allVehicles)):
                    $isOwn   = in_array((int)$v['id'], $charVehicles);
                    $isTaken = !empty($v['character_id']) && (int)$v['character_id'] !== $id;
                    $active  = $isOwn ? 'active-vehicle' : '';
                    $taken   = ($isTaken && !$isOwn) ? 'cb-taken' : '';
                ?>
                    <label class="cb-item <?= $active ?> <?= $taken ?>"
                           data-type="vehicle" data-name="<?= htmlspecialchars($v['name']) ?>"
                           <?= ($isTaken && !$isOwn) ? 'title="Gehört ' . htmlspecialchars($v['owner_name']) . '"' : '' ?>>
                        <input type="checkbox" name="vehicles[]"
                               value="<?= $v['id'] ?>" <?= $isOwn ? 'checked' : '' ?>>
                        <div class="cb-check"><?= $isOwn ? '✓' : '' ?></div>
                        <div>
                            <div class="cb-label"><?= htmlspecialchars($v['name']) ?></div>
                            <div class="cb-sub">
                                <?= htmlspecialchars($v['type'] ?? '') ?>
                                <?php if ($isTaken && !$isOwn): ?>
                                    · <span style="color:#e85555"><?= htmlspecialchars($v['owner_name']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </label>
                <?php endwhile; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── SPEICHERN ── -->
        <button type="submit" class="btn-submit">✔ Alle Änderungen speichern</button>

    </div>
</div>
</form>

<script>
// ── Live-Vorschau Name & Rolle ────────────────────────────────────────────────
document.getElementById('inputName').addEventListener('input', function() {
    document.getElementById('prevName').textContent = this.value || '—';
});
document.getElementById('inputSurname').addEventListener('input', function() {
    document.getElementById('prevSurname').textContent = this.value || '';
});
document.getElementById('inputRole').addEventListener('change', function() {
    const el = document.getElementById('prevRole');
    el.textContent = this.value;
    const map = { 'Main character':'role-main', 'Protagonist':'role-proto', 'Supporter':'role-supporter' };
    el.className = 'preview-role ' + (map[this.value] || 'role-supporter');
});

// ── Checkbox Klick ────────────────────────────────────────────────────────────
document.querySelectorAll('.cb-item').forEach(function(item) {
    item.addEventListener('click', function() {
        // Fahrzeug das einem anderen gehört → nicht klickbar
        if (this.classList.contains('cb-taken')) return;

        const cb    = this.querySelector('input[type="checkbox"]');
        const check = this.querySelector('.cb-check');
        const type  = this.dataset.type;

        cb.checked = !cb.checked;

        if (cb.checked) {
            this.classList.add('active-' + type);
            check.textContent = '✓';
        } else {
            this.classList.remove('active-' + type);
            check.textContent = '';
        }

        updatePreview(type);
        updateCount(type);
    });
});

// ── Vorschau-Tags aktualisieren ───────────────────────────────────────────────
function updatePreview(type) {
    const ids = { weapon: 'prevWeapons', location: 'prevLocations', vehicle: 'prevVehicles' };
    const container = document.getElementById(ids[type]);
    if (!container) return;
    container.innerHTML = '';
    document.querySelectorAll('.cb-item.active-' + type).forEach(function(item) {
        const tag = document.createElement('span');
        tag.className   = 'preview-tag';
        tag.textContent = item.dataset.name;
        container.appendChild(tag);
    });
}

// ── Zähler aktualisieren ──────────────────────────────────────────────────────
function updateCount(type) {
    const ids = { weapon: 'cntWeapon', location: 'cntLocation', vehicle: 'cntVehicle' };
    const el  = document.getElementById(ids[type]);
    if (!el) return;
    el.textContent = document.querySelectorAll('.cb-item.active-' + type).length + ' ausgewählt';
}
</script>

<?php include '../includes/footer.php'; ?>