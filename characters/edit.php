<?php include '../includes/header.php'; ?>
<?php include '../includes/char_images.php'; ?>

<?php
$id   = (int)$_GET['id'];
$char = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Characters WHERE id = $id"));

if (!$char) {
    header('Location: /GTA_Projekt/characters/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $age     = (int)$_POST['age'];
    $role    = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "UPDATE Characters SET name='$name', surname='$surname', age=$age, role='$role' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: /GTA_Projekt/characters/index.php?success=updated');
        exit();
    } else {
        $error = 'Fehler: ' . mysqli_error($conn);
    }
}

// Charakter-Bild für die Vorschau
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
.container {
    padding: 40px 30px;
    max-width: 900px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 30px;
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

.preview-info {
    padding: 16px;
    border-top: 1px solid #1a1a1a;
}
.preview-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 20px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.preview-surname { font-size: 12px; color: #555; margin-top: 3px; }
.preview-label {
    font-size: 9px;
    color: #333;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-top: 14px;
    margin-bottom: 4px;
}
.preview-role {
    display: inline-block;
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

/* ── FORMULAR ─────────────────────────────────────────── */
.form-card {
    background: #111;
    border: 1px solid #1e1e1e;
    border-radius: 10px;
    overflow: hidden;
}

.form-card-header {
    background: linear-gradient(135deg, #1a1200, #111);
    padding: 20px 24px;
    border-bottom: 1px solid #222;
    display: flex;
    align-items: center;
    gap: 12px;
}
.form-card-header .icon { font-size: 22px; }
.form-card-header h2 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 18px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin: 0;
}

.form-body { padding: 26px; }

.form-group { margin-bottom: 20px; }
.form-group label {
    display: block;
    font-size: 11px;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 8px;
    font-weight: bold;
}
.form-group input,
.form-group select {
    width: 100%;
    background: #0a0a0a;
    border: 1px solid #252525;
    border-radius: 6px;
    padding: 13px 15px;
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

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.form-divider {
    border: none;
    border-top: 1px solid #1a1a1a;
    margin: 8px 0 20px;
}

.btn-submit {
    width: 100%;
    background: #e8291c;
    color: #fff;
    padding: 14px;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: bold;
    font-family: 'Barlow', sans-serif;
    letter-spacing: 3px;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 6px;
}
.btn-submit:hover { background: #c41f10; }

.alert-error {
    background: #1a0000;
    border: 1px solid #e8291c;
    color: #f05555;
    padding: 12px 16px;
    border-radius: 6px;
    font-size: 13px;
    margin-bottom: 20px;
}

/* ── RESPONSIVE ───────────────────────────────────────── */
@media (max-width: 700px) {
    .container { grid-template-columns: 1fr; }
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

<div class="container">

    <!-- ── VORSCHAU ── -->
    <div class="preview-card">
        <img class="preview-img"
             src="<?= htmlspecialchars($charImg['src']) ?>"
             alt="<?= htmlspecialchars($char['name']) ?>"
             id="previewImg">
        <div class="preview-info">
            <div class="preview-label">Vorschau</div>
            <div class="preview-name" id="prevName"><?= htmlspecialchars($char['name']) ?></div>
            <div class="preview-surname" id="prevSurname"><?= htmlspecialchars($char['surname']) ?></div>
            <div style="margin-top:10px">
                <span class="preview-role <?=
                    $char['role'] === 'Main character' ? 'role-main' :
                    ($char['role'] === 'Protagonist' ? 'role-proto' : 'role-supporter')
                ?>" id="prevRole"><?= htmlspecialchars($char['role']) ?></span>
            </div>
        </div>
    </div>

    <!-- ── FORMULAR ── -->
    <div class="form-card">
        <div class="form-card-header">
            <span class="icon">✏️</span>
            <h2>Daten bearbeiten</h2>
        </div>
        <div class="form-body">

            <?php if (isset($error)): ?>
                <div class="alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" id="editForm">

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

                <div class="form-group">
                    <label>Alter</label>
                    <input type="number" name="age"
                           value="<?= (int)$char['age'] ?>" min="1" max="120" required>
                </div>

                <hr class="form-divider">

                <div class="form-group">
                    <label>Rolle</label>
                    <select name="role" id="inputRole" required>
                        <option value="Main character" <?= $char['role'] === 'Main character' ? 'selected' : '' ?>>Main character</option>
                        <option value="Protagonist"    <?= $char['role'] === 'Protagonist'    ? 'selected' : '' ?>>Protagonist</option>
                        <option value="Supporter"      <?= $char['role'] === 'Supporter'      ? 'selected' : '' ?>>Supporter</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">✔ Änderungen speichern</button>
            </form>
        </div>
    </div>
</div>

<!-- Live-Vorschau: Name & Rolle aktualisieren während man tippt -->
<script>
const prevName    = document.getElementById('prevName');
const prevSurname = document.getElementById('prevSurname');
const prevRole    = document.getElementById('prevRole');
const inputName   = document.getElementById('inputName');
const inputSur    = document.getElementById('inputSurname');
const inputRole   = document.getElementById('inputRole');

const roleClasses = {
    'Main character': 'role-main',
    'Protagonist':    'role-proto',
    'Supporter':      'role-supporter'
};

inputName.addEventListener('input',  () => prevName.textContent    = inputName.value || '—');
inputSur.addEventListener('input',   () => prevSurname.textContent = inputSur.value  || '');
inputRole.addEventListener('change', () => {
    prevRole.textContent = inputRole.value;
    prevRole.className   = 'preview-role ' + (roleClasses[inputRole.value] || 'role-supporter');
});
</script>

<?php include '../includes/footer.php'; ?>