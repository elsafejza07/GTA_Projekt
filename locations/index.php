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

    /* Locations Grid */
    .locations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .location-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
    }
    .location-card:hover {
        transform: translateY(-4px);
        border-color: #e8291c;
    }

    .location-card-top {
        padding: 28px 20px 20px;
        border-bottom: 1px solid #1a1a1a;
        background: linear-gradient(135deg, #0a001a, #111);
        text-align: center;
    }

    .location-icon {
        font-size: 40px;
        margin-bottom: 12px;
        display: block;
    }

    .location-name {
        font-size: 17px;
        font-weight: 900;
        color: #fff;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .location-id {
        font-size: 11px;
        color: #444;
        margin-top: 4px;
        letter-spacing: 1px;
    }

    .location-card-bottom {
        padding: 16px 20px;
    }

    /* Charaktere die dort sind */
    .chars-label {
        font-size: 10px;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .chars-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 16px;
        min-height: 28px;
    }

    .char-tag {
        display: flex;
        align-items: center;
        gap: 5px;
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 11px;
        color: #aaa;
    }
    .char-tag .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #e8291c;
        flex-shrink: 0;
    }

    .stat-row {
        background: #0a0a0a;
        border: 1px solid #1a1a1a;
        border-radius: 6px;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }
    .stat-row-label {
        font-size: 11px;
        color: #444;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .stat-row-value {
        font-size: 14px;
        color: #e8291c;
        font-weight: bold;
    }

    .location-actions {
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
        <h1>LOCA<span>TIONS</span></h1>
        <p>Alle Orte aus GTA V</p>
    </div>
    <a href="/GTA_Projekt/locations/add.php" class="btn-add">+ Neu hinzufügen</a>
</div>

<div class="container">
    <div class="locations-grid">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM Locations");

    if (mysqli_num_rows($result) == 0) {
        echo '<div class="empty"><span>🗺️</span>Keine Locations gefunden.</div>';
    }

    function getLocationIcon($name) {
        $name = strtolower($name);
        if (strpos($name, 'santos') !== false)   return '🌆';
        if (strpos($name, 'blaine') !== false)   return '🏜️';
        if (strpos($name, 'sandy') !== false)    return '🏕️';
        if (strpos($name, 'vinewood') !== false) return '⭐';
        if (strpos($name, 'downtown') !== false) return '🏙️';
        if (strpos($name, 'beach') !== false)    return '🏖️';
        if (strpos($name, 'fort') !== false)     return '✈️';
        if (strpos($name, 'paleto') !== false)   return '🌊';
        return '📍';
    }

    while ($row = mysqli_fetch_assoc($result)) {
        // Charaktere an diesem Ort
        $chars = mysqli_query($conn,
            "SELECT c.name FROM Characters c
             JOIN Character_Locations cl ON c.id = cl.characterId
             WHERE cl.locationId = " . $row['id']
        );
        $char_count = mysqli_num_rows($chars);
    ?>
        <div class="location-card">
            <div class="location-card-top">
                <span class="location-icon"><?= getLocationIcon($row['name']) ?></span>
                <div class="location-name"><?= htmlspecialchars($row['name']) ?></div>
                <div class="location-id">Location #<?= $row['id'] ?></div>
            </div>
            <div class="location-card-bottom">

                <div class="stat-row">
                    <span class="stat-row-label">Charaktere hier</span>
                    <span class="stat-row-value"><?= $char_count ?></span>
                </div>

                <div class="chars-label">Bekannte Charaktere</div>
                <div class="chars-list">
                <?php
                if ($char_count == 0) {
                    echo '<span style="color:#444;font-size:12px">Keine Charaktere</span>';
                }
                mysqli_data_seek($chars, 0);
                while ($c = mysqli_fetch_assoc($chars)) { ?>
                    <span class="char-tag">
                        <span class="dot"></span>
                        <?= htmlspecialchars($c['name']) ?>
                    </span>
                <?php } ?>
                </div>

                <div class="location-actions">
                    <a href="/GTA_Projekt/locations/edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏ Bearbeiten</a>
                    <a href="/GTA_Projekt/locations/delete.php?id=<?= $row['id'] ?>"
                       class="btn-del"
                       onclick="return confirm('<?= htmlspecialchars($row['name']) ?> wirklich löschen?')">✕ Löschen</a>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>