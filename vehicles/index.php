<?php include 'includes/header.php'; ?>
<?php include 'includes/char_images.php'; ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,700;0,900;1,900&family=Barlow:wght@400;500;700&display=swap');

* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Barlow', sans-serif; background: #000; color: #fff; }

/* ═══════════════════════════════════════════════════════
   HERO
═══════════════════════════════════════════════════════ */
.hero {
    position: relative;
    height: 100vh;
    min-height: 700px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('https://www.igta5.com/images/official-screenshot-pc-downtown-dusk.jpg');
    background-size: cover;
    background-position: center;
    z-index: 0;
    transition: transform 8s ease;
}
.hero:hover .hero-bg { transform: scale(1.03); }

.hero-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top,
        rgba(0,0,0,0.98) 0%,
        rgba(0,0,0,0.6) 40%,
        rgba(0,0,0,0.1) 100%);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    padding: 0 70px 70px;
}

.hero-eyebrow {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 22px;
}
.hero-eyebrow-line { width: 40px; height: 2px; background: #e8291c; }
.hero-eyebrow span {
    font-size: 12px;
    color: #e8291c;
    letter-spacing: 4px;
    text-transform: uppercase;
    font-weight: bold;
}

/* Offizielles GTA V Logo */
.gta-logo-wrap { margin-bottom: 14px; }
.gta-logo-img {
    height: 130px;
    width: auto;
    filter: drop-shadow(0 4px 30px rgba(0,0,0,0.9));
    display: block;
}
/* Fallback-Titel (nur wenn Bild nicht lädt) */
.hero-title-fallback {
    display: none;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 82px;
    font-weight: 900;
    line-height: 0.9;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: -1px;
    text-shadow: 0 4px 30px rgba(0,0,0,0.8);
}
.hero-title-fallback .v { color: #e8291c; font-style: italic; }

.hero-tagline {
    font-size: 14px;
    color: #aaa;
    letter-spacing: 5px;
    text-transform: uppercase;
    margin-bottom: 24px;
}

.hero-desc {
    font-size: 16px;
    color: #ccc;
    line-height: 1.8;
    max-width: 580px;
    margin-bottom: 38px;
}

.hero-btns { display: flex; gap: 14px; flex-wrap: wrap; }

.btn-red {
    background: #e8291c;
    color: #fff;
    padding: 15px 36px;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 3px;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 3px;
    transition: background 0.2s;
}
.btn-red:hover { background: #c41f10; }

.btn-ghost {
    background: transparent;
    color: #fff;
    padding: 15px 36px;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: 3px;
    text-transform: uppercase;
    text-decoration: none;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 3px;
    transition: border-color 0.2s;
}
.btn-ghost:hover { border-color: #fff; }

.scroll-hint {
    position: absolute;
    bottom: 30px;
    right: 70px;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #444;
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
}
.scroll-line { width: 60px; height: 1px; background: #333; }

/* ═══════════════════════════════════════════════════════
   STATS
═══════════════════════════════════════════════════════ */
.stats-strip {
    background: #0d0d0d;
    border-top: 1px solid #1a1a1a;
    border-bottom: 1px solid #1a1a1a;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.stat-block {
    padding: 30px;
    text-align: center;
    border-right: 1px solid #1a1a1a;
    position: relative;
}
.stat-block:last-child { border-right: none; }
.stat-block::before {
    content: '';
    position: absolute;
    top: 0; left: 50%;
    transform: translateX(-50%);
    width: 40px; height: 2px;
    background: #e8291c;
}

.stat-number {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 52px;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    margin-bottom: 6px;
}
.stat-text {
    font-size: 11px;
    color: #555;
    text-transform: uppercase;
    letter-spacing: 3px;
}

/* ═══════════════════════════════════════════════════════
   ÜBER GTA V
═══════════════════════════════════════════════════════ */
.about-gta { background: #000; padding: 100px 70px; }

.split-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.split-text .label {
    font-size: 11px;
    color: #e8291c;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.split-text .label::before { content: ''; width: 30px; height: 1px; background: #e8291c; }

.split-text h2 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 50px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    line-height: 1.0;
    margin-bottom: 28px;
    letter-spacing: -1px;
}
.split-text h2 span { color: #e8291c; }
.split-text p { font-size: 15px; color: #777; line-height: 1.9; margin-bottom: 16px; }
.split-text p strong { color: #ccc; }

.img-mosaic {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 200px 200px;
    gap: 8px;
}
.mosaic-img {
    overflow: hidden;
    border-radius: 4px;
    background: #111;
    border: 1px solid #1a1a1a;
}
.mosaic-img.tall { grid-row: span 2; }
.mosaic-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    filter: brightness(0.8) saturate(1.1);
    transition: all 0.4s;
}
.mosaic-img:hover img {
    filter: brightness(1) saturate(1.3);
    transform: scale(1.06);
}

/* ═══════════════════════════════════════════════════════
   CHARAKTERE (Vorschau)
═══════════════════════════════════════════════════════ */
.chars-section {
    background: #050505;
    padding: 100px 70px;
    border-top: 1px solid #111;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 44px;
}
.section-header-left .label {
    font-size: 11px;
    color: #e8291c;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 10px;
}
.section-header-left h2 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 44px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: -1px;
}
.section-header-left h2 span { color: #e8291c; }

.section-link {
    color: #555;
    text-decoration: none;
    font-size: 12px;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-bottom: 1px solid #333;
    padding-bottom: 2px;
    transition: all 0.2s;
}
.section-link:hover { color: #e8291c; border-color: #e8291c; }

.chars-grid-home {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.char-card-home {
    background: #0d0d0d;
    border: 1px solid #1a1a1a;
    border-radius: 6px;
    overflow: hidden;
    transition: all 0.3s;
    text-decoration: none;
    display: block;
}
.char-card-home:hover {
    border-color: #e8291c;
    transform: translateY(-6px);
    box-shadow: 0 10px 30px rgba(232,41,28,0.12);
}

.char-img-wrap-home {
    height: 210px;
    overflow: hidden;
    background: #111;
    position: relative;
}
.char-img-wrap-home img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    filter: brightness(0.8);
    transition: all 0.4s;
    display: block;
}
.char-card-home:hover .char-img-wrap-home img {
    filter: brightness(1) saturate(1.2);
    transform: scale(1.05);
}
.char-img-overlay {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 70px;
    background: linear-gradient(to top, #0d0d0d, transparent);
}

.char-info-home { padding: 16px; }
.char-info-name {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 17px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.char-info-surname { font-size: 12px; color: #555; margin-top: 2px; }

.char-role-badge {
    display: inline-block;
    margin-top: 10px;
    padding: 3px 10px;
    font-size: 10px;
    font-weight: bold;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-radius: 2px;
}
.badge-main  { background: #1a0d00; color: #ff8c00; border-left: 3px solid #ff8c00; }
.badge-proto { background: #1a0000; color: #e85555; border-left: 3px solid #e85555; }
.badge-supp  { background: #001a00; color: #55cc55; border-left: 3px solid #55cc55; }

/* ═══════════════════════════════════════════════════════
   PROJEKT SECTION
═══════════════════════════════════════════════════════ */
.project-section {
    background: #000;
    padding: 100px 70px;
    border-top: 1px solid #111;
}

.project-intro {
    max-width: 800px;
    margin: 0 auto 60px;
    text-align: center;
}
.project-intro .label {
    font-size: 11px;
    color: #e8291c;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 16px;
}
.project-intro h2 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 44px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: -1px;
    margin-bottom: 20px;
}
.project-intro h2 span { color: #e8291c; }
.project-intro p { font-size: 15px; color: #666; line-height: 1.9; }

.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px;
    background: #111;
    border: 1px solid #111;
    border-radius: 8px;
    overflow: hidden;
}
.feature-item {
    background: #080808;
    padding: 36px 30px;
    transition: background 0.2s;
}
.feature-item:hover { background: #0d0d0d; }
.feature-icon { font-size: 28px; margin-bottom: 16px; display: block; }
.feature-num { font-size: 11px; color: #333; letter-spacing: 3px; margin-bottom: 10px; font-weight: bold; }
.feature-item h3 {
    font-size: 13px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 12px;
}
.feature-item p { font-size: 13px; color: #555; line-height: 1.8; }
.feature-item p strong { color: #888; }

/* ═══════════════════════════════════════════════════════
   GALERIE
═══════════════════════════════════════════════════════ */
.gallery {
    background: #050505;
    padding: 100px 70px;
    border-top: 1px solid #111;
}
.gallery-header { margin-bottom: 36px; }
.gallery-header .label {
    font-size: 11px;
    color: #e8291c;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 10px;
}
.gallery-header h2 {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 44px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: -1px;
}
.gallery-header h2 span { color: #e8291c; }

.gallery-masonry {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}
.gal-item {
    overflow: hidden;
    border-radius: 4px;
    background: #111;
    border: 1px solid #1a1a1a;
    position: relative;
}
.gal-item.wide { grid-column: span 2; }
.gal-item img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    filter: brightness(0.75) saturate(1.1);
    transition: all 0.4s;
    display: block;
}
.gal-item.wide img { height: 220px; }
.gal-item:hover img { filter: brightness(1) saturate(1.3); transform: scale(1.04); }
.gal-caption {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 20px 16px 12px;
    background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);
    font-size: 11px;
    color: #888;
    letter-spacing: 1px;
    text-transform: uppercase;
    opacity: 0;
    transition: opacity 0.3s;
}
.gal-item:hover .gal-caption { opacity: 1; }

/* ═══════════════════════════════════════════════════════
   TABELLEN-NAVIGATOR
═══════════════════════════════════════════════════════ */
.nav-section {
    background: #000;
    padding: 100px 70px;
    border-top: 1px solid #111;
}
.nav-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 3px;
    margin-top: 50px;
}
.nav-card {
    display: block;
    text-decoration: none;
    background: #0a0a0a;
    padding: 40px 28px;
    border: 1px solid #111;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.nav-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: #e8291c;
    transform: scaleX(0);
    transition: transform 0.3s;
}
.nav-card:hover { background: #0d0d0d; border-color: #222; }
.nav-card:hover::before { transform: scaleX(1); }

.nav-card-icon { font-size: 36px; display: block; margin-bottom: 20px; }
.nav-card-count {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 44px;
    font-weight: 900;
    color: #e8291c;
    line-height: 1;
    margin-bottom: 6px;
}
.nav-card h3 {
    font-size: 13px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 10px;
}
.nav-card p { font-size: 12px; color: #444; line-height: 1.6; }
.nav-card-arrow {
    position: absolute;
    bottom: 20px; right: 20px;
    color: #333;
    font-size: 18px;
    transition: all 0.2s;
}
.nav-card:hover .nav-card-arrow { color: #e8291c; transform: translateX(4px); }

/* ═══════════════════════════════════════════════════════
   FOOTER
═══════════════════════════════════════════════════════ */
.site-footer {
    background: #000;
    border-top: 1px solid #111;
    padding: 50px 70px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 40px;
    align-items: center;
}
.footer-brand .logo-text {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 22px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 3px;
    text-transform: uppercase;
}
.footer-brand .logo-text span { color: #e8291c; }
.footer-brand p { font-size: 12px; color: #333; margin-top: 8px; letter-spacing: 1px; }
.footer-info { text-align: center; }
.footer-info p { font-size: 12px; color: #333; line-height: 1.8; }
.footer-info strong { color: #555; }
.footer-copy { text-align: right; font-size: 11px; color: #2a2a2a; letter-spacing: 1px; line-height: 1.8; }
</style>

<!-- ═══════════ HERO ═══════════ -->
<div class="hero">
    <div class="hero-bg"></div>
    <div class="hero-gradient"></div>
    <div class="hero-content">
        <div class="hero-eyebrow">
            <div class="hero-eyebrow-line"></div>
            <span>Datenbankprojekt</span>
        </div>

        <!-- Offizielles GTA V Logo mit Fallback -->
        <div class="gta-logo-wrap">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/GTA_V.svg/800px-GTA_V.svg.png"
                 alt="Grand Theft Auto V"
                 class="gta-logo-img"
                 onerror="this.style.display='none'; document.getElementById('heroTitleFallback').style.display='block'">
            <div id="heroTitleFallback" class="hero-title-fallback">
                Grand Theft<br>Auto <span class="v">V</span>
            </div>
        </div>

        <div class="hero-tagline">Die Datenbank zu San Andreas</div>
        <p class="hero-desc">
            Eine vollständige relationale Datenbank, die die komplexe Spielwelt von GTA V strukturiert abbildet.
            Von Charakteren über Waffen und Fahrzeuge bis hin zu den Locations von Los Santos —
            alles verwaltet in einem modernen Webinterface.
        </p>
        <div class="hero-btns">
            <a href="/GTA_Projekt/characters/index.php" class="btn-red">Datenbank öffnen</a>
            <!-- FIX: voller Pfad damit der Button von jeder Unterseite funktioniert -->
            <a href="/GTA_Projekt/index.php#projekt" class="btn-ghost">Über das Projekt</a>
        </div>
    </div>
    <div class="scroll-hint">
        <div class="scroll-line"></div>
        <span>Scroll</span>
    </div>
</div>

<!-- ═══════════ STATS ═══════════ -->
<?php
$total_chars     = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM Characters"))[0];
$total_weapons   = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM Weapons"))[0];
$total_vehicles  = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM Vehicles"))[0];
$total_locations = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM Locations"))[0];
?>
<div class="stats-strip">
    <div class="stat-block"><div class="stat-number"><?= $total_chars ?></div><div class="stat-text">Charaktere</div></div>
    <div class="stat-block"><div class="stat-number"><?= $total_weapons ?></div><div class="stat-text">Waffen</div></div>
    <div class="stat-block"><div class="stat-number"><?= $total_vehicles ?></div><div class="stat-text">Fahrzeuge</div></div>
    <div class="stat-block"><div class="stat-number"><?= $total_locations ?></div><div class="stat-text">Locations</div></div>
</div>

<!-- ═══════════ ÜBER GTA V ═══════════ -->
<div class="about-gta">
    <div class="split-layout">
        <div class="split-text">
            <div class="label">Was ist GTA V?</div>
            <h2>Die Welt von<br><span>San Andreas</span></h2>
            <p><strong>Grand Theft Auto V</strong> ist ein Open-World-Action-Adventure,
            entwickelt von <strong>Rockstar Games</strong> und erschienen am
            17. September 2013. Mit über <strong>170 Millionen verkauften Exemplaren</strong>
            ist es eines der erfolgreichsten Videospiele aller Zeiten.</p>
            <p>Das Spiel spielt in der fiktiven Metropole <strong>Los Santos</strong> —
            angelehnt an Los Angeles — sowie in der Wildnis von <strong>Blaine County</strong>.</p>
            <p>Drei spielbare Protagonisten: <strong>Michael De Santa</strong>,
            <strong>Trevor Philips</strong> und <strong>Franklin Clinton</strong>
            — ihre Geschichten verflechten sich zu einem epischen Kriminalplot.</p>
        </div>
        <div class="img-mosaic">
            <div class="mosaic-img tall">
                <img src="https://www.igta5.com/images/official-screenshot-pc-trevor-cleaning-house.jpg" alt="Trevor">
            </div>
            <div class="mosaic-img">
                <img src="https://www.igta5.com/images/official-screenshot-pc-franklin-calls-michael.jpg" alt="Franklin">
            </div>
            <div class="mosaic-img">
                <img src="https://www.igta5.com/images/official-screenshot-pc-michael-on-the-phone.jpg" alt="Michael">
            </div>
        </div>
    </div>
</div>

<!-- ═══════════ CHARAKTERE VORSCHAU ═══════════ -->
<div class="chars-section">
    <div class="section-header">
        <div class="section-header-left">
            <div class="label">Aus der Datenbank</div>
            <h2>Die <span>Charaktere</span></h2>
        </div>
        <a href="/GTA_Projekt/characters/index.php" class="section-link">Alle anzeigen →</a>
    </div>
    <div class="chars-grid-home">
    <?php
    $chars = mysqli_query($conn, "SELECT * FROM Characters LIMIT 4");
    while ($c = mysqli_fetch_assoc($chars)):
        $charImg = getCharacterImageOrSVG($c['name'], $c['surname'], $c['role']);

        if ($c['role'] === 'Main character') $badge = 'badge-main';
        elseif ($c['role'] === 'Protagonist') $badge = 'badge-proto';
        else $badge = 'badge-supp';
    ?>
        <a href="/GTA_Projekt/characters/index.php" class="char-card-home">
            <div class="char-img-wrap-home">
                <img src="<?= htmlspecialchars($charImg['src']) ?>"
                     alt="<?= htmlspecialchars($c['name'] . ' ' . $c['surname']) ?>"
                     <?php if ($charImg['type'] === 'img'): ?>
                     onerror="this.src='<?= addslashes(getCharacterSVG($c['name'], $c['surname'], $c['role'])) ?>'"
                     <?php endif; ?>>
                <div class="char-img-overlay"></div>
            </div>
            <div class="char-info-home">
                <div class="char-info-name"><?= htmlspecialchars($c['name']) ?></div>
                <div class="char-info-surname"><?= htmlspecialchars($c['surname']) ?></div>
                <span class="char-role-badge <?= $badge ?>"><?= htmlspecialchars($c['role']) ?></span>
            </div>
        </a>
    <?php endwhile; ?>
    </div>
</div>

<!-- ═══════════ PROJEKT ═══════════ -->
<div class="project-section" id="projekt">
    <div class="project-intro">
        <div class="label">Unser Schulprojekt</div>
        <h2>Was macht unsere <span>Datenbank</span>?</h2>
        <p>Im Rahmen unseres Datenbankprojekts an der Berufsschule haben wir eine vollständige
        relationale Datenbank entwickelt, die auf der Welt von GTA V basiert.
        Ziel war es, Charaktere, Waffen, Fahrzeuge und Locations strukturiert in MySQL
        abzubilden und über ein PHP-Interface zugänglich zu machen.</p>
    </div>
    <div class="features-grid">
        <div class="feature-item">
            <span class="feature-icon">🗄️</span>
            <div class="feature-num">01</div>
            <h3>Relationale Datenbank</h3>
            <p>Erfüllt vollständig die <strong>3. Normalform (3NF)</strong>.
            Alle Daten redundanzfrei, korrekt über Fremdschlüssel verknüpft.</p>
        </div>
        <div class="feature-item">
            <span class="feature-icon">🔗</span>
            <div class="feature-num">02</div>
            <h3>m:n Beziehungen</h3>
            <p>Charaktere können <strong>mehrere Waffen</strong> besitzen —
            abgebildet durch Zwischentabellen
            (<em>Character_Weapons</em>, <em>Character_Locations</em>).</p>
        </div>
        <div class="feature-item">
            <span class="feature-icon">🖥️</span>
            <div class="feature-num">03</div>
            <h3>PHP Webinterface</h3>
            <p>Vollständige <strong>CRUD-Oberfläche</strong> — Anzeigen, Hinzufügen,
            Bearbeiten und Löschen aller Datensätze ohne SQL-Kenntnisse.</p>
        </div>
        <div class="feature-item">
            <span class="feature-icon">⚙️</span>
            <div class="feature-num">04</div>
            <h3>Technologien</h3>
            <p>Entwickelt mit <strong>PHP</strong>, <strong>MySQL</strong> und
            <strong>HTML/CSS</strong>. Webserver: <strong>XAMPP</strong>
            unter Ubuntu Linux.</p>
        </div>
        <div class="feature-item">
            <span class="feature-icon">👥</span>
            <div class="feature-num">05</div>
            <h3>Zielgruppe</h3>
            <p>Für <strong>GTA-Fans</strong>, <strong>Modder</strong>
            und <strong>Studierende</strong>, die Datenbankdesign
            anhand eines realen Projekts kennenlernen möchten.</p>
        </div>
        <div class="feature-item">
            <span class="feature-icon">📋</span>
            <div class="feature-num">06</div>
            <h3>Datenmodell</h3>
            <p>6 Tabellen: <strong>Characters, Weapons, Vehicles, Locations,
            Character_Weapons</strong> und <strong>Character_Locations</strong>.</p>
        </div>
    </div>
</div>

<!-- ═══════════ GALERIE ═══════════ -->
<div class="gallery">
    <div class="gallery-header">
        <div class="label">Screenshots</div>
        <h2>San Andreas in <span>Bildern</span></h2>
    </div>
    <div class="gallery-masonry">
        <div class="gal-item wide">
            <img src="https://www.igta5.com/images/official-screenshot-pc-downtown-dusk.jpg" alt="Downtown">
            <div class="gal-caption">Downtown Los Santos</div>
        </div>
        <div class="gal-item">
            <img src="https://www.igta5.com/images/official-screenshot-pc-alamo-sea.jpg" alt="Alamo Sea">
            <div class="gal-caption">Alamo Sea</div>
        </div>
        <div class="gal-item">
            <img src="https://www.igta5.com/images/official-screenshot-pc-trevor-in-the-desert.jpg" alt="Desert">
            <div class="gal-caption">Blaine County</div>
        </div>
        <div class="gal-item">
            <img src="https://www.igta5.com/images/official-screenshot-pc-vinewood-blvd.jpg" alt="Vinewood">
            <div class="gal-caption">Vinewood Blvd</div>
        </div>
        <div class="gal-item wide">
            <img src="https://www.igta5.com/images/official-screenshot-pc-cape-catfish.jpg" alt="Coast">
            <div class="gal-caption">Cape Catfish</div>
        </div>
        <div class="gal-item">
            <img src="https://www.igta5.com/images/official-screenshot-pc-getting-higher.jpg" alt="Aerial">
            <div class="gal-caption">Los Santos Aerial</div>
        </div>
        <div class="gal-item">
            <img src="https://www.igta5.com/images/official-screenshot-pc-castle-in-the-hills.jpg" alt="Hills">
            <div class="gal-caption">Vinewood Hills</div>
        </div>
        <div class="gal-item">
            <img src="https://www.igta5.com/images/official-screenshot-pc-dodging-the-law.jpg" alt="Action">
            <div class="gal-caption">Action Szene</div>
        </div>
    </div>
</div>

<!-- ═══════════ NAVIGATOR ═══════════ -->
<div class="nav-section">
    <div class="project-intro" style="margin-bottom:0">
        <div class="label">Datenbank erkunden</div>
        <h2>Alle <span>Tabellen</span></h2>
    </div>
    <div class="nav-grid">
        <a href="/GTA_Projekt/characters/index.php" class="nav-card">
            <span class="nav-card-icon">👤</span>
            <div class="nav-card-count"><?= $total_chars ?></div>
            <h3>Charaktere</h3>
            <p>Michael, Trevor, Franklin, Lester — die Protagonisten von San Andreas</p>
            <span class="nav-card-arrow">→</span>
        </a>
        <a href="/GTA_Projekt/weapons/index.php" class="nav-card">
            <span class="nav-card-icon">🔫</span>
            <div class="nav-card-count"><?= $total_weapons ?></div>
            <h3>Waffen</h3>
            <p>Pistolen, Gewehre, Schrotflinten — das Arsenal von GTA V</p>
            <span class="nav-card-arrow">→</span>
        </a>
        <a href="/GTA_Projekt/vehicles/index.php" class="nav-card">
            <span class="nav-card-icon">🚗</span>
            <div class="nav-card-count"><?= $total_vehicles ?></div>
            <h3>Fahrzeuge</h3>
            <p>Sportwagen, Trucks, Helikopter — alle Fahrzeuge und ihre Besitzer</p>
            <span class="nav-card-arrow">→</span>
        </a>
        <a href="/GTA_Projekt/locations/index.php" class="nav-card">
            <span class="nav-card-icon">📍</span>
            <div class="nav-card-count"><?= $total_locations ?></div>
            <h3>Locations</h3>
            <p>Los Santos, Blaine County, Sandy Shores — die Orte von San Andreas</p>
            <span class="nav-card-arrow">→</span>
        </a>
    </div>
</div>

<!-- ═══════════ FOOTER ═══════════ -->
<div class="site-footer">
    <div class="footer-brand">
        <div class="logo-text">GTA <span>V</span> DB</div>
        <p>Datenbankprojekt — Berufsschule </p>
    </div>
    <div class="footer-info">
        <p><strong>Powered by</strong> PHP & MySQL<br>
        <strong>Server:</strong> XAMPPS<br>
        <strong>Design:</strong> PHP, HTML & CSS</p>
    </div>
    <div class="footer-copy">
        Schulprojekt<br>
        Alle Spielinhalte © Rockstar Games<br>
        GTA V — 2013
    </div>
</div>