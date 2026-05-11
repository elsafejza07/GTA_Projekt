<?php include '../includes/header.php'; ?>

<?php
// Fahrzeug speichern
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $character_id = mysqli_real_escape_string($conn, $_POST['character_id']);

    $sql = "INSERT INTO Vehicles (name, type, price, character_id)
            VALUES ('$name', '$type', '$price', '$character_id')";

    if (mysqli_query($conn, $sql)) {
        header('Location: /GTA_Projekt/vehicles/index.php?success=added');
        exit();
    } else {
        $error = "Fehler: " . mysqli_error($conn);
    }
}

// Charaktere laden
$characters = mysqli_query($conn, "SELECT id, name FROM Characters");
?>

<style>
.page-header {
    background: linear-gradient(180deg, #0a0a1a 0%, #0a0a0a 100%);
    padding: 40px 30px 30px;
    border-bottom: 1px solid #2a2a2a;
    display: flex;
    justify-content: space-between;
    align-items: center;
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

.form-header {
    padding: 20px;
    border-bottom: 1px solid #222;
    background: #0a0a1a;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.form-body { padding: 20px; }

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-size: 12px;
    color: #888;
    margin-bottom: 5px;
    text-transform: uppercase;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    background: #0a0a0a;
    border: 1px solid #333;
    color: #fff;
    border-radius: 5px;
}

.btn {
    width: 100%;
    padding: 12px;
    background: #e8291c;
    border: none;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    cursor: pointer;
    margin-top: 10px;
}

.btn:hover {
    background: #c71f14;
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
    <h1>FAHRZEUG <span>HINZUFÜGEN</span></h1>
</div>

<div class="container">

    <div class="form-card">
        <div class="form-header">Neues Fahrzeug hinzufügen</div>

        <div class="form-body">

            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">

                <div class="form-group">
                    <label>Fahrzeugname</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Typ</label>
                    <select name="type" required>
                        <option value="Car">Car</option>
                        <option value="SUV">SUV</option>
                        <option value="Truck">Truck</option>
                        <option value="Motorcycle">Motorcycle</option>
                        <option value="Helicopter">Helicopter</option>
                        <option value="Sports">Sports</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Preis</label>
                    <input type="number" step="0.01" name="price" required>
                </div>

                <div class="form-group">
                    <label>Besitzer (Charakter)</label>
                    <select name="character_id" required>
                        <option value="">-- Charakter auswählen --</option>

                        <?php while($row = mysqli_fetch_assoc($characters)) { ?>
                            <option value="<?= $row['id']; ?>">
                                <?= $row['name']; ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <button class="btn" type="submit">Fahrzeug hinzufügen</button>

            </form>

        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>