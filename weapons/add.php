<?php include '../includes/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name         = mysqli_real_escape_string($conn, $_POST['name']);
    $type         = mysqli_real_escape_string($conn, $_POST['type']);
    $price        = (float)$_POST['price'];
    $manufacturer = mysqli_real_escape_string($conn, $_POST['manufacturer']);

    $sql = "INSERT INTO Weapons (name, type, price, manufacturer) VALUES ('$name', '$type', $price, '$manufacturer')";

    if (mysqli_query($conn, $sql)) {
        header('Location: /GTA_Projekt/weapons/index.php?success=added');
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
        background: linear-gradient(135deg, #0a0a1a, #111);
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
    .form-group select:focus { border-color: #e8291c; }
    .form-group select option { background: #111; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .btn-submit {
        width: 100%; background: #e8291c; color: #fff; padding: 14px; border: none;
        border-radius: 6px; font-size: 14px; font-weight: bold; letter-spacing: 2px;
        text-transform: uppercase; cursor: pointer; transition: background 0.2s; margin-top: 8px;
    }
    .btn-submit:hover { background: #c41f10; }
    .alert-error { background: #1a0000; border: 1px solid #e8291c; color: #f05555; padding: 12px 16px; border-radius: 6px; font-size: 13px; margin-bottom: 20px; }
</style>

<div class="page-header">
    <div>
        <h1>WAFFE <span>HINZUFÜGEN</span></h1>
        <p>Neue Waffe zur Datenbank hinzufügen</p>
    </div>
    <a href="/GTA_Projekt/weapons/index.php" class="btn-back">← Zurück</a>
</div>

<div class="container">
    <div class="form-card">
        <div class="form-card-header">
            <span class="icon">🔫</span>
            <h2>Neue Waffe</h2>
        </div>
        <div class="form-body">
            <?php if (isset($error)) echo '<div class="alert-error">' . $error . '</div>'; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Waffenname</label>
                    <input type="text" name="name" placeholder="z.B. Assault Rifle" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Typ</label>
                        <select name="type" required>
                            <option value="">-- Typ wählen --</option>
                            <option value="Pistol">🔫 Pistol</option>
                            <option value="Rifle">🎯 Rifle</option>
                            <option value="Sniper">🔭 Sniper</option>
                            <option value="Shotgun">💥 Shotgun</option>
                            <option value="SMG">⚡ SMG</option>
                            <option value="Melee">🏏 Melee</option>
                            <option value="Explosive">💣 Explosive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Preis ($)</label>
                        <input type="number" name="price" placeholder="z.B. 3500" min="0" step="0.01" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Hersteller</label>
                    <select name="manufacturer" required>
                        <option value="">-- Hersteller wählen --</option>
                        <option value="Hawk & Little">Hawk & Little</option>
                        <option value="Shrewsbury">Shrewsbury</option>
                        <option value="Coil">Coil</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">+ Waffe hinzufügen</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>