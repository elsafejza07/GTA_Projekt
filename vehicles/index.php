<?php include '../includes/header.php'; ?>

<style>
    .page-header {
        background: linear-gradient(180deg, #001a0a 0%, #0a0a0a 100%);
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

    /* Vehicles Grid */
    .vehicles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .vehicle-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s, border-color 0.2s;
    }
    .vehicle-card:hover {
        transform: translateY(-4px);
        border-color: #e8291c;
    }

    .vehicle-card-top {
        padding: 24px 20px;
        border-bottom: 1px solid #1a1a1a;
        background: linear-gradient(135deg, #001a0a, #111);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .vehicle-icon {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        background: #0a0a0a;
        border: 2px solid #333;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex-shrink: 0;
    }

    .vehicle-info { flex: 1; }

    .vehicle-name {
        font-size: 16px;
        font-weight: 900;
        color: #fff;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .vehicle-type {
        display: inline-block;
        margin-top: 6px;
        padding: 3px 10px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .type-sedan      { background: #001a1a; color: #00d4d4; border: 1px solid #00d4d433; }
    .type-suv        { background: #0a1a00; color: #88cc00; border: 1px solid #88cc0033; }
    .type-truck      { background: #1a0a00; color: #ff8c00; border: 1px solid #ff8c0033; }
    .type-sports     { background: #1a0000; color: #e85555; border: 1px solid #e8555533; }
    .type-motorcycle { background: #1a001a; color: #cc55ff; border: 1px solid #cc55ff33; }
    .type-helicopter { background: #00001a; color: #5ba3f5; border: 1px solid #5ba3f533; }
    .type-default    { background: #1a1a1a; color: #388;    border: 1px solid #5761b333; }

    .vehicle-card-bottom {
        padding: 16px 20px;
    }

    .vehicle-stats {
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
    .stat-value.owner { color: #e8291c; }

    .vehicle-actions {
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
        <h1>FAHR<span>ZEUGE</span></h1>
        <p>Alle Fahrzeuge aus GTA V</p>
    </div>
    <a href="/GTA_Projekt/vehicles/add.php" class="btn-add">+ Neu hinzufügen</a>
</div>

<div class="container">
    <div class="vehicles-grid">
    <?php
    $result = mysqli_query($conn,
        "SELECT v.*, c.name AS owner_name
         FROM Vehicles v
         LEFT JOIN Characters c ON v.character_id = c.id"
    );

    if (mysqli_num_rows($result) == 0) {
        echo '<div class="empty"><span>🚗</span>Keine Fahrzeuge gefunden.</div>';
    }

    function getVehicleIcon($type) {
        switch(strtolower($type)) {
            case 'sedan':       return '🚗';
            case 'suv':         return '🚙';
            case 'truck':       return '🛻';
            case 'sports':      return '🏎️';
            case 'motorcycle':  return '🏍️';
            case 'helicopter':  return '🚁';
            default:            return '🚘';
        }
    }

    function getVehicleTypeClass($type) {
        switch(strtolower($type)) {
            case 'sedan':       return 'type-sedan';
            case 'suv':         return 'type-suv';
            case 'truck':       return 'type-truck';
            case 'sports':      return 'type-sports';
            case 'motorcycle':  return 'type-motorcycle';
            case 'helicopter':  return 'type-helicopter';
            default:            return 'type-default';
        }
    }

    while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="vehicle-card">
            <div class="vehicle-card-top">
                <div class="vehicle-icon"><?= getVehicleIcon($row['type']) ?></div>
                <div class="vehicle-info">
                    <div class="vehicle-name"><?= htmlspecialchars($row['name']) ?></div>
                    <span class="vehicle-type <?= getVehicleTypeClass($row['type']) ?>">
                        <?= htmlspecialchars($row['type']) ?>
                    </span>
                </div>
            </div>
            <div class="vehicle-card-bottom">
                <div class="vehicle-stats">
                    <div class="stat-item">
                        <div class="stat-label">Preis</div>
                        <div class="stat-value price">$<?= number_format($row['price'], 0, ',', '.') ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Fahrer</div>
                        <div class="stat-value owner">
                            <?= $row['owner_name'] ? htmlspecialchars($row['owner_name']) : 'Niemand' ?>
                        </div>
                    </div>
                </div>

                <div class="vehicle-actions">
                    <a href="/GTA_Projekt/vehicles/edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏ Bearbeiten</a>
                    <a href="/GTA_Projekt/vehicles/delete.php?id=<?= $row['id'] ?>"
                       class="btn-del"
                       onclick="return confirm('<?= htmlspecialchars($row['name']) ?> wirklich löschen?')">✕ Löschen</a>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>