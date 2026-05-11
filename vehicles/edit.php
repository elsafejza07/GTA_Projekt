<?php include '../includes/header.php'; ?>

<?php
$id = (int)$_GET['id'];

// Fahrzeug laden
$vehicle = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM Vehicles WHERE id = $id
"));

if (!$vehicle) {
    header('Location: /GTA_Projekt/vehicles/index.php');
    exit();
}

// Charaktere laden
$characters = mysqli_query($conn, "SELECT id, name FROM Characters");

// Update speichern
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $character_id = mysqli_real_escape_string($conn, $_POST['character_id']);

    $sql = "UPDATE Vehicles 
            SET name='$name', type='$type', price='$price', character_id='$character_id'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: /GTA_Projekt/vehicles/index.php?success=updated');
        exit();
    } else {
        $error = "Fehler: " . mysqli_error($conn);
    }
}
?>

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

.container {
    max-width: 600px;
    margin: 40px auto;
    padding: 0 20px;
}

.form-card {
    background: #111;
    border: 1px solid #222;
    border-radius: 10px;
    overflow: hidden;
}

.form-card-header {
    background: linear-gradient(135deg, #1a1a00, #111);
    padding: 20px 24px;
    border-bottom: 1px solid #222;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-card-header h2 {
    font-size: 16px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.form-body { padding: 24px; }

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-size: 11px;
    color: #666;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px;
    background: #0a0a0a;
    border: 1px solid #2a2a2a;
    color: #fff;
    border-radius: 6px;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #ffc107;
    outline: none;
}

.btn-submit {
    width: 100%;
    background: #ffc107;
    color: #000;
    padding: 14px;
    border: none;
    font-weight: bold;
    text-transform: uppercase;
    cursor: pointer;
    border-radius: 6px;
}

.btn-submit:hover {
    background: #e0a800;
}

.error {
    background: #2a0000;
    color: #ff5c5c;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #e8291c;
}
</style>

<div class="page-header">
    <div>
        <h1>VEHICLE <span>BEARBEITEN</span></h1>
        <p><?= htmlspecialchars($vehicle['name']) ?></p>
    </div>
    <a href="/GTA_Projekt/vehicles/index.php" style="color:#aaa;text-decoration:none;">← Zurück</a>
</div>

<div class="container">

    <div class="form-card">

        <div class="form-card-header">
            <h2>Fahrzeug bearbeiten</h2>
        </div>

        <div class="form-body">

            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($vehicle['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Typ</label>
                    <select name="type">
                        <option <?= $vehicle['type']=="Car"?"selected":"" ?>>Car</option>
                        <option <?= $vehicle['type']=="SUV"?"selected":"" ?>>SUV</option>
                        <option <?= $vehicle['type']=="Truck"?"selected":"" ?>>Truck</option>
                        <option <?= $vehicle['type']=="Motorcycle"?"selected":"" ?>>Motorcycle</option>
                        <option <?= $vehicle['type']=="Helicopter"?"selected":"" ?>>Helicopter</option>
                        <option <?= $vehicle['type']=="Sports"?"selected":"" ?>>Sports</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Preis</label>
                    <input type="number" step="0.01" name="price" value="<?= $vehicle['price'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Besitzer (Charakter)</label>
                    <select name="character_id">
                        <?php while($row = mysqli_fetch_assoc($characters)) { ?>
                            <option value="<?= $row['id'] ?>"
                                <?= $vehicle['character_id']==$row['id']?"selected":"" ?>>
                                <?= $row['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn-submit">Änderungen speichern</button>

            </form>

        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>