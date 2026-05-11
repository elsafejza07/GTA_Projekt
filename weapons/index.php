<?php include '../includes/header.php'; ?>

<style>
    .page-header {
        background: linear-gradient(180deg, #0a0a1a 0%, #0a0a0a 100%);
        padding: 40px 30px 30px;
        border-bottom: 1px solid #2a2a2a;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .page-header h1 {
        font-size: 28px;
        font-weight: 900;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: #fff;
    }
    .page-header h1 span { color: #e8291c; }
    .page-header p {
        color: #555;
        font-size: 13px;
        margin-top: 5px;
        letter-spacing: 1px;
    }

    .btn-add {
        background: #e8291c;
        color: #fff;
        padding: 10px 22px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        letter-spacing: 1px;
        transition: background 0.2s;
    }
    .btn-add:hover { background: #c41f10; }

    .container {
        padding: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Weapons Grid */
    .weapons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .weapon-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
    }
    .weapon-card:hover {
        transform: translateY(-4px);
        border-color: #e8291c;
    }

    .weapon-card-top {
        padding: 24px 20px;
        border-bottom: 1px solid #1a1a1a;
        display: flex;
        align-items: center;
        gap: 16px;
        background: linear-gradient(135deg, #0a0a1a, #111);
    }

    .weapon-icon {
        width: 55px;
        height: 55px;
        border-radius: 8px;
        background: #0a0a0a;
        border: 2px solid #333;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .weapon-info { flex: 1; }

    .weapon-name {
        font-size: 16px;
        font-weight: 900;
        color: #fff;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .weapon-type {
        display: inline-block;
        margin-top: 6px;
        padding: 3px 10px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .type-pistol     { background: #1a1500; color: #ffc107; border: 1px solid #ffc10733; }
    .type-rifle      { background: #001a00; color: #55c855; border: 1px solid #55c85533; }
    .type-sniper     { background: #00001a; color: #5ba3f5; border: 1px solid #5ba3f533; }
    .type-shotgun    { background: #1a0a00; color: #ff8c00; border: 1px solid #ff8c0033; }
    .type-smg        { background: #1a001a; color: #cc55ff; border: 1px solid #cc55ff33; }
    .type-melee      { background: #1a0000; color: #e85555; border: 1px solid #e8555533; }
    .type-explosive  { background: #1a0500; color: #ff4500; border: 1px solid #ff450033; }
    .type-default    { background: #1a1a1a; color: #888;    border: 1px solid #33333333; }

    .weapon-card-bottom {
        padding: 16px 20px;
    }

    .weapon-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 14px;
    }
    .stat-item {
        background: #0a0a0a;
        border: 1px solid #1a1a1a;
        border-radius: 6px;
        padding: 10px;
        text-align: center;
    }
    .stat-label {
        font-size: 10px;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .stat-value {
        font-size: 14px;
        color: #ccc;
        margin-top: 3px;
        font-weight: bold;
    }
    .stat-value.price { color: #55c855; }

    /* Benutzer Tags */
    .users-label {
        font-size: 10px;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }
    .users-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 14px;
        min-height: 24px;
    }
    .user-tag {
        background: #1a1a1a;
        border: 1px solid #333;
        color: #888;
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 3px;
    }

    .weapon-actions {
        display: flex;
        gap: 8px;
    }
    .btn-edit {
        flex: 1;
        background: #1a2a3a;
        color: #5ba3f5;
        padding: 8px;
        border-radius: 4px;
        font-size: 12px;
        text-decoration: none;
        text-align: center;
        font-weight: bold;
        transition: background 0.2s;
    }
    .btn-edit:hover { background: #1e3a5f; }
    .btn-del {
        flex: 1;
        background: #2a1010;
        color: #f05555;
        padding: 8px;
        border-radius: 4px;
        font-size: 12px;
        text-decoration: none;
        text-align: center;
        font-weight: bold;
        transition: background 0.2s;
    }
    .btn-del:hover { background: #3d1515; }

    .empty {
        text-align: center;
        padding: 60px;
        color: #444;
        font-size: 15px;
    }
    .empty span { font-size: 40px; display: block; margin-bottom: 12px; }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1>WAF<span>FEN</span></h1>
        <p>Alle Waffen aus GTA V</p>
    </div>
    <a href="/GTA_Projekt/weapons/add.php" class="btn-add">+ Neu hinzufügen</a>
</div>

<div class="container">
    <div class="weapons-grid">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM Weapons");

    if (mysqli_num_rows($result) == 0) {
        echo '<div class="empty"><span>🔫</span>Keine Waffen gefunden.</div>';
    }

    // Waffen-Typ zu Emoji
    function getWeaponIcon($type) {
        switch(strtolower($type)) {
            case 'pistol':    return '🔫';
            case 'rifle':     return '🎯';
            case 'sniper':    return '🔭';
            case 'shotgun':   return '💥';
            case 'smg':       return '⚡';
            case 'melee':     return '🏏';
            case 'explosive': return '💣';
            default:          return '🔧';
        }
    }

    // Waffen-Typ zu CSS Klasse
    function getTypeClass($type) {
        switch(strtolower($type)) {
            case 'pistol':    return 'type-pistol';
            case 'rifle':     return 'type-rifle';
            case 'sniper':    return 'type-sniper';
            case 'shotgun':   return 'type-shotgun';
            case 'smg':       return 'type-smg';
            case 'melee':     return 'type-melee';
            case 'explosive': return 'type-explosive';
            default:          return 'type-default';
        }
    }

    while ($row = mysqli_fetch_assoc($result)) {
        // Charaktere die diese Waffe benutzen
        $users = mysqli_query($conn,
            "SELECT c.name FROM Characters c
             JOIN Character_Weapons cw ON c.id = cw.characterID
             WHERE cw.weaponId = " . $row['id']
        );
    ?>
        <div class="weapon-card">
            <div class="weapon-card-top">
                <div class="weapon-icon"><?= getWeaponIcon($row['type']) ?></div>
                <div class="weapon-info">
                    <div class="weapon-name"><?= htmlspecialchars($row['name']) ?></div>
                    <span class="weapon-type <?= getTypeClass($row['type']) ?>">
                        <?= htmlspecialchars($row['type']) ?>
                    </span>
                </div>
            </div>
            <div class="weapon-card-bottom">
                <div class="weapon-stats">
                    <div class="stat-item">
                        <div class="stat-label">Preis</div>
                        <div class="stat-value price">$<?= number_format($row['price'], 0, ',', '.') ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Hersteller</div>
                        <div class="stat-value"><?= htmlspecialchars($row['manufacturer']) ?></div>
                    </div>
                </div>

                <div class="users-label">Benutzt von</div>
                <div class="users-list">
                <?php
                if (mysqli_num_rows($users) == 0) {
                    echo '<span class="user-tag">Niemand</span>';
                }
                while ($u = mysqli_fetch_assoc($users)) {
                    echo '<span class="user-tag">' . htmlspecialchars($u['name']) . '</span>';
                }
                ?>
                </div>

                <div class="weapon-actions">
                    <a href="/GTA_Projekt/weapons/edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏ Bearbeiten</a>
                    <a href="/GTA_Projekt/weapons/delete.php?id=<?= $row['id'] ?>"
                       class="btn-del"
                       onclick="return confirm('<?= htmlspecialchars($row['name']) ?> wirklich löschen?')">✕ Löschen</a>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?><?php include '../includes/header.php'; ?>

<?php
$id     = (int)$_GET['id'];
$weapon = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Weapons WHERE id = $id"));

if (!$weapon) {
    header('Location: /GTA_Projekt/weapons/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name         = mysqli_real_escape_string($conn, $_POST['name']);
    $type         = mysqli_real_escape_string($conn, $_POST['type']);
    $price        = (float)$_POST['price'];
    $manufacturer = mysqli_real_escape_string($conn, $_POST['manufacturer']);

    $sql = "UPDATE Weapons SET name='$name', type='$type', price=$price, manufacturer='$manufacturer' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: /GTA_Projekt/weapons/index.php?success=updated');
        exit();
    } else {
        $error = "Fehler: " . mysqli_error($conn);
    }
}
?>

<style>
    .page-header {
        background: linear-gradient(180deg, #0a0a1a 0%, #0a0a0a 100%);
        padding: 40px 30px 30px; border-bottom: 1px solid #2a2a2a;
        display: flex; align-items: center; justify-content: space-between;
    }
    .page-header h1 { font-size: 28px; font-weight: 900; letter-spacing: 4px; text-transform: uppercase; color: #fff; }
    .page-header h1 span { color: #e8291c; }
    .page-header p { color: #555; font-size: 13px; margin-top: 5px; letter-spacing: 1px; }

    .btn-back { background: #1a1a1a; color: #aaa; padding: 10px 22px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; border: 1px solid #333; transition: all 0.2s; }
    .btn-back:hover { background: #222; color: #fff; }

    .container { padding: 40px 30px; max-width: 600px; margin: 0 auto; }
    .form-card { background: #111; border: 1px solid #222; border-radius: 10px; overflow: hidden; }

    .form-card-header {
        background: linear-gradient(135deg, #1a1500, #111);
        padding: 20px 24px; border-bottom: 1px solid #222;
        display: flex; align-items: center; gap: 12px;
    }
    .form-card-header .icon { font-size: 24px; }
    .form-card-header h2 { font-size: 16px; font-weight: 900; color: #fff; letter-spacing: 2px; text-transform: uppercase; }

    .form-body { padding: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
    .form-group input,
    .form-group select {
        width: 100%; background: #0a0a0a; border: 1px solid #2a2a2a;
        border-radius: 6px; padding: 12px 14px; color: #fff; font-size: 14px;
        outline: none; transition: border-color 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus { border-color: #ffc107; }
    .form-group select option { background: #111; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .btn-submit {
        width: 100%; background: #ffc107; color: #000; padding: 14px; border: none;
        border-radius: 6px; font-size: 14px; font-weight: bold; letter-spacing: 2px;
        text-transform: uppercase; cursor: pointer; transition: background 0.2s; margin-top: 8px;
    }
    .btn-submit:hover { background: #e6ac00; }
    .alert-error { background: #1a0000; border: 1px solid #e8291c; color: #f05555; padding: 12px 16px; border-radius: 6px; font-size: 13px; margin-bottom: 20px; }
</style>

<div class="page-header">
    <div>
        <h1>WAFFE <span>BEARBEITEN</span></h1>
        <p><?= htmlspecialchars($weapon['name']) ?></p>
    </div>
    <a href="/GTA_Projekt/weapons/index.php" class="btn-back">← Zurück</a>
</div>

<div class="container">
    <div class="form-card">
        <div class="form-card-header">
            <span class="icon">✏️</span>
            <h2>Waffe bearbeiten</h2>
        </div>
        <div class="form-body">
            <?php if (isset($error)) echo '<div class="alert-error">' . $error . '</div>'; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Waffenname</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($weapon['name']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Typ</label>
                        <select name="type" required>
                            <?php
                            $types = ['Pistol'=>'🔫','Rifle'=>'🎯','Sniper'=>'🔭','Shotgun'=>'💥','SMG'=>'⚡','Melee'=>'🏏','Explosive'=>'💣'];
                            foreach ($types as $t => $icon): ?>
                                <option value="<?= $t ?>" <?= $weapon['type'] == $t ? 'selected' : '' ?>><?= $icon ?> <?= $t ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Preis ($)</label>
                        <input type="number" name="price" value="<?= $weapon['price'] ?>" min="0" step="0.01" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Hersteller</label>
                    <select name="manufacturer" required>
                        <?php
                        $manufacturers = ['Hawk & Little', 'Shrewsbury', 'Coil', 'Unknown'];
                        foreach ($manufacturers as $m): ?>
                            <option value="<?= $m ?>" <?= $weapon['manufacturer'] == $m ? 'selected' : '' ?>><?= $m ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-submit">✏ Änderungen speichern</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>