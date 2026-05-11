<?php include '../includes/header.php'; ?>
<?php include '../includes/char_images.php'; ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,700;0,900;1,900&family=Barlow:wght@400;500;700&display=swap');

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
}
.page-header h1 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 32px;
    font-weight: 900;
    letter-spacing: 5px;
    text-transform: uppercase;
    color: #fff;
    margin: 0;
}
.page-header h1 span { color: #e8291c; }
.page-header p { color: #555; font-size: 13px; margin-top: 6px; letter-spacing: 1px; }

.btn-add {
    background: #e8291c;
    color: #fff;
    padding: 11px 24px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 1px;
    transition: background 0.2s;
    white-space: nowrap;
}
.btn-add:hover { background: #c41f10; }

/* ── SUCCESS BANNER ──────────────────────────────────── */
.success-banner {
    background: #001a00;
    border-bottom: 1px solid #55c855;
    color: #55c855;
    padding: 12px 30px;
    font-size: 13px;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ── CONTAINER & GRID ────────────────────────────────── */
.container {
    padding: 30px;
    max-width: 1300px;
    margin: 0 auto;
}

.chars-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 20px;
}

/* ── CHARAKTER CARD ──────────────────────────────────── */
.char-card {
    background: #111;
    border: 1px solid #1e1e1e;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
}
.char-card:hover {
    transform: translateY(-5px);
    border-color: #e8291c;
    box-shadow: 0 12px 40px rgba(232,41,28,0.15);
}

/* ── BILD-BEREICH ─────────────────────────────────────── */
.char-img-wrap {
    width: 100%;
    height: 190px;
    overflow: hidden;
    position: relative;
    background: #0a0a0a;
}

/* Echtes Foto */
.char-img-wrap img.char-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    filter: brightness(0.88) saturate(1.1);
    transition: filter 0.4s, transform 0.4s;
    display: block;
}
.char-card:hover .char-img-wrap img.char-photo {
    filter: brightness(1) saturate(1.2);
    transform: scale(1.04);
}

/* SVG-Portrait (inline, immer sichtbar) */
.char-img-wrap img.char-svg {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Gradient-Overlay unten */
.char-img-wrap::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 60px;
    background: linear-gradient(to top, #111, transparent);
    pointer-events: none;
}

/* ── TEXT-BEREICH ─────────────────────────────────────── */
.char-card-text {
    padding: 16px 18px 14px;
    border-bottom: 1px solid #1a1a1a;
}

.char-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 20px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 2px;
    text-transform: uppercase;
    line-height: 1.1;
}
.char-surname { font-size: 13px; color: #555; margin-top: 3px; }

.char-role {
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

/* ── STATS + WAFFEN ───────────────────────────────────── */
.char-card-bottom { padding: 14px 18px; }

.char-stats {
    display: flex;
    gap: 24px;
    margin-bottom: 12px;
}
.char-stat-label { font-size: 10px; color: #444; text-transform: uppercase; letter-spacing: 1px; }
.char-stat-value { font-size: 15px; color: #ccc; font-weight: 700; margin-top: 2px; }

.weapons-list {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-bottom: 14px;
    min-height: 22px;
}
.weapon-tag {
    background: #1a1a1a;
    border: 1px solid #2a2a2a;
    color: #777;
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 3px;
    letter-spacing: 0.5px;
}
.no-weapons { font-size: 11px; color: #333; letter-spacing: 1px; }

/* ── AKTIONEN ─────────────────────────────────────────── */
.char-actions { display: flex; gap: 8px; }

.btn-edit {
    flex: 1;
    background: #0e2340;
    color: #5ba3f5;
    padding: 9px;
    border-radius: 4px;
    font-size: 12px;
    text-decoration: none;
    text-align: center;
    font-weight: bold;
    transition: background 0.2s;
    border: 1px solid #1a3a5c;
}
.btn-edit:hover { background: #152e52; }

.btn-del {
    flex: 1;
    background: #2a0e0e;
    color: #f05555;
    padding: 9px;
    border-radius: 4px;
    font-size: 12px;
    text-decoration: none;
    text-align: center;
    font-weight: bold;
    transition: background 0.2s;
    border: 1px solid #3d1515;
}
.btn-del:hover { background: #3d1515; }

/* ── EMPTY STATE ─────────────────────────────────────── */
.empty {
    text-align: center;
    padding: 80px 30px;
    color: #333;
    grid-column: 1/-1;
}
.empty-icon { font-size: 48px; display: block; margin-bottom: 16px; }
.empty p { font-size: 15px; letter-spacing: 1px; }
</style>

<!-- ── HEADER ── -->
<div class="page-header">
    <div>
        <h1>CHARAK<span>TERE</span></h1>
        <p>Alle Charaktere aus GTA V</p>
    </div>
    <a href="/GTA_Projekt/characters/add.php" class="btn-add">+ Neu hinzufügen</a>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="success-banner">
    ✓ <?= $_GET['success'] === 'updated' ? 'Charakter erfolgreich aktualisiert.' : 'Charakter erfolgreich gespeichert.' ?>
</div>
<?php endif; ?>

<!-- ── GRID ── -->
<div class="container">
    <div class="chars-grid">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM Characters ORDER BY id ASC");

    if (mysqli_num_rows($result) == 0):
    ?>
        <div class="empty">
            <span class="empty-icon">👤</span>
            <p>Noch keine Charaktere vorhanden.</p>
        </div>
    <?php endif; ?>

    <?php while ($row = mysqli_fetch_assoc($result)):
        // Bild holen (Foto-URL oder SVG-Data-URL)
        $charImg = getCharacterImageOrSVG($row['name'], $row['surname'], $row['role']);

        // Rolle → CSS-Klasse
        if ($row['role'] === 'Main character')  $roleClass = 'role-main';
        elseif ($row['role'] === 'Protagonist') $roleClass = 'role-proto';
        else                                     $roleClass = 'role-supporter';

        // Waffen des Charakters
        $weaponsQ = mysqli_query($conn,
            "SELECT w.name FROM Weapons w
             JOIN Character_Weapons cw ON w.id = cw.weaponId
             WHERE cw.characterID = " . (int)$row['id']
        );
        $weaponCount = mysqli_num_rows($weaponsQ);
    ?>
        <div class="char-card">

            <!-- BILD -->
            <div class="char-img-wrap">
                <?php if ($charImg['type'] === 'img'): ?>
                    <!-- Echtes Foto mit SVG-Fallback wenn Laden fehlschlägt -->
                    <img class="char-photo"
                         src="<?= htmlspecialchars($charImg['src']) ?>"
                         alt="<?= htmlspecialchars($row['name'] . ' ' . $row['surname']) ?>"
                         onerror="this.src='<?= getCharacterSVG($row['name'], $row['surname'], $row['role']) ?>'; this.className='char-svg';">
                <?php else: ?>
                    <!-- SVG-Portrait (kein Netzwerk nötig) -->
                    <img class="char-svg"
                         src="<?= $charImg['src'] ?>"
                         alt="<?= htmlspecialchars($row['name'] . ' ' . $row['surname']) ?>">
                <?php endif; ?>
            </div>

            <!-- NAME & ROLLE -->
            <div class="char-card-text">
                <div class="char-name"><?= htmlspecialchars($row['name']) ?></div>
                <div class="char-surname"><?= htmlspecialchars($row['surname']) ?></div>
                <span class="char-role <?= $roleClass ?>"><?= htmlspecialchars($row['role']) ?></span>
            </div>

            <!-- STATS & WAFFEN -->
            <div class="char-card-bottom">
                <div class="char-stats">
                    <div>
                        <div class="char-stat-label">Alter</div>
                        <div class="char-stat-value"><?= (int)$row['age'] ?></div>
                    </div>
                    <div>
                        <div class="char-stat-label">Waffen</div>
                        <div class="char-stat-value"><?= $weaponCount ?></div>
                    </div>
                </div>

                <div class="weapons-list">
                <?php
                if ($weaponCount === 0):
                    echo '<span class="no-weapons">Keine Waffen</span>';
                else:
                    mysqli_data_seek($weaponsQ, 0);
                    while ($w = mysqli_fetch_assoc($weaponsQ)):
                        echo '<span class="weapon-tag">' . htmlspecialchars($w['name']) . '</span>';
                    endwhile;
                endif;
                ?>
                </div>

                <div class="char-actions">
                    <a href="/GTA_Projekt/characters/edit.php?id=<?= (int)$row['id'] ?>" class="btn-edit">✏ Bearbeiten</a>
                    <a href="/GTA_Projekt/characters/delete.php?id=<?= (int)$row['id'] ?>"
                       class="btn-del"
                       onclick="return confirm('<?= htmlspecialchars($row['name'], ENT_QUOTES) ?> wirklich löschen?')">✕ Löschen</a>
                </div>
            </div>

        </div>
    <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>