<?php include '../includes/header.php'; ?>

<?php
$id      = (int)$_GET['id'];
$vehicle = mysqli_fetch_assoc(mysqli_query($conn, "SELECT v.*, c.name AS owner_name FROM Vehicles v LEFT JOIN Characters c ON v.character_id = c.id WHERE v.id = $id"));

if (!$vehicle) {
    header('Location: /GTA_Projekt/vehicles/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    mysqli_query($conn, "DELETE FROM Vehicles WHERE id = $id");
    header('Location: /GTA_Projekt/vehicles/index.php?success=deleted');
    exit();
}
?>

<style>
    .page-header {
        background: linear-gradient(180deg, #001a0a 0%, #0a0a0a 100%);
        padding: 40px 30px 30px; border-bottom: 1px solid #2a2a2a;
        display: flex; align-items: center; justify-content: space-between;
    }
    .page-header h1 { font-size: 28px; font-weight: 900; letter-spacing: 4px; text-transform: uppercase; color: #fff; }
    .page-header h1 span { color: #e8291c; }
    .page-header p { color: #555; font-size: 13px; margin-top: 5px; letter-spacing: 1px; }

    .btn-back { background: #1a1a1a; color: #aaa; padding: 10px 22px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; border: 1px solid #333; transition: all 0.2s; }
    .btn-back:hover { background: #222; color: #fff; }

    .container { padding: 40px 30px; max-width: 500px; margin: 0 auto; }

    .confirm-card { background: #111; border: 1px solid #e8291c33; border-radius: 10px; overflow: hidden; text-align: center; }

    .confirm-card-top {
        background: linear-gradient(135deg, #1a0000, #111);
        padding: 30px 24px; border-bottom: 1px solid #2a2a2a;
    }
    .warning-icon { font-size: 50px; display: block; margin-bottom: 16px; }
    .confirm-card-top h2 { font-size: 18px; font-weight: 900; color: #fff; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; }
    .confirm-card-top p { color: #666; font-size: 13px; }

    .vehicle-info-box {
        background: #0a0a0a; border: 1px solid #2a2a2a; border-radius: 8px;
        padding: 16px; margin: 20px 24px;
    }
    .vehicle-info-icon { font-size: 32px; display: block; margin-bottom: 8px; }
    .vehicle-info-name { font-size: 20px; font-weight: 900; color: #fff; letter-spacing: 1px; }
    .vehicle-info-details { color: #666; font-size: 13px; margin-top: 6px; }
    .vehicle-info-details span { color: #e8291c; }

    .confirm-actions { padding: 0 24px 24px; display: flex; gap: 12px; }

    .btn-cancel {
        flex: 1; background: #1a1a1a; color: #aaa; padding: 14px; border-radius: 6px;
        text-decoration: none; font-size: 13px; font-weight: bold; letter-spacing: 1px;
        text-transform: uppercase; border: 1px solid #333; transition: all 0.2s; text-align: center;
    }
    .btn-cancel:hover { background: #222; color: #fff; }

    .btn-delete {
        flex: 1; background: #e8291c; color: #fff; padding: 14px; border: none;
        border-radius: 6px; font-size: 13px; font-weight: bold; letter-spacing: 1px;
        text-transform: uppercase; cursor: pointer; transition: background 0.2s;
    }
    .btn-delete:hover { background: #c41f10; }
</style>

<div class="page-header">
    <div>
        <h1>FAHRZEUG <span>LÖSCHEN</span></h1>
        <p>Bitte bestätige die Löschung</p>
    </div>
    <a href="/GTA_Projekt/vehicles/index.php" class="btn-back">← Zurück</a>
</div>

<div class="container">
    <div class="confirm-card">
        <div class="confirm-card-top">
            <span class="warning-icon">⚠️</span>
            <h2>Wirklich löschen?</h2>
            <p>Diese Aktion kann nicht rückgängig gemacht werden!</p>
        </div>

        <div class="vehicle-info-box">
            <span class="vehicle-info-icon">🚗</span>
            <div class="vehicle-info-name"><?= htmlspecialchars($vehicle['name']) ?></div>
            <div class="vehicle-info-details">
                Typ: <?= htmlspecialchars($vehicle['type']) ?> &nbsp;|&nbsp;
                Preis: <span>$<?= number_format($vehicle['price'], 0, ',', '.') ?></span> &nbsp;|&nbsp;
                Fahrer: <span><?= $vehicle['owner_name'] ?? 'Niemand' ?></span>
            </div>
        </div>

        <div class="confirm-actions">
            <a href="/GTA_Projekt/vehicles/index.php" class="btn-cancel">✕ Abbrechen</a>
            <form method="POST" style="flex:1">
                <button type="submit" class="btn-delete" style="width:100%">🗑 Ja, löschen!</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>