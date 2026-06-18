<?php include '../includes/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $age     = (int)$_POST['age'];
    $role    = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "INSERT INTO Characters (name, surname, age, role) VALUES ('$name', '$surname', $age, '$role')";

    if (mysqli_query($conn, $sql)) {
        header('Location: /GTA_Projekt/characters/index.php?success=added');
        exit();
    } else {
        $error = "Fehler: " . mysqli_error($conn);
    }
}
?>

<style>
    .page-header {
        background: linear-gradient(180deg, #1a0000 0%, #0a0a0a 100%);
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
    .page-header p { color: #555; font-size: 13px; margin-top: 5px; letter-spacing: 1px; }

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
    }
    .btn-back:hover { background: #222; color: #fff; }

    .container {
        padding: 40px 30px;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 10px;
        overflow: hidden;
    }

    .form-card-header {
        background: linear-gradient(135deg, #1a0000, #111);
        padding: 20px 24px;
        border-bottom: 1px solid #222;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .form-card-header .icon {
        font-size: 24px;
    }
    .form-card-header h2 {
        font-size: 16px;
        font-weight: 900;
        color: #fff;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .form-body { padding: 24px; }

    .form-group { margin-bottom: 20px; }

    .form-group label {
        display: block;
        font-size: 11px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        background: #0a0a0a;
        border: 1px solid #2a2a2a;
        border-radius: 6px;
        padding: 12px 14px;
        color: #fff;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus {
        border-color: #e8291c;
    }
    .form-group select option { background: #111; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .btn-submit {
        width: 100%;
        background: #e8291c;
        color: #fff;
        padding: 14px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: bold;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.2s;
        margin-top: 8px;
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
</style>

<div class="page-header">
    <div>
        <h1>CHARAKTER <span>HINZUFÜGEN</span></h1>
        <p>Neuen Charakter zur Datenbank hinzufügen</p>
    </div>
    <a href="/GTA_Projekt/characters/index.php" class="btn-back">← Zurück</a>
</div>

<div class="container">
    <div class="form-card">
        <div class="form-card-header">
            <span class="icon">👤</span>
            <h2>Neuer Charakter</h2>
        </div>
        <div class="form-body">
            <?php if (isset($error)) echo '<div class="alert-error">' . $error . '</div>'; ?>

            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Vorname</label>
                        <input type="text" name="name" placeholder="z.B. Michael" required>
                    </div>
                    <div class="form-group">
                        <label>Nachname</label>
                        <input type="text" name="surname" placeholder="z.B. De Santa">
                    </div>
                </div>

                <div class="form-group">
                    <label>Alter</label>
                    <input type="number" name="age" placeholder="z.B. 45" min="1" max="100" required>
                </div>

                <div class="form-group">
                    <label>Rolle</label>
                    <select name="role" required>
                        <option value="">-- Rolle wählen --</option>
                        <option value="Main character">Main character</option>
                        <option value="Protagonist">Protagonist</option>
                        <option value="Supporter">Supporter</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">+ Charakter hinzufügen</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>