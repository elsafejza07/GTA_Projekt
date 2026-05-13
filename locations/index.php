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

    .page-header h1 { font-size: 28px; font-weight: 900; letter-spacing: 4px; text-transform: uppercase; color: #fff; }

    .page-header h1 span { color: #e8291c; }

    .page-header p { color: #555; font-size: 13px; margin-top: 5px; letter-spacing: 1px; }
 
    .btn-add {

        background: #e8291c; color: #fff; padding: 10px 22px;

        border-radius: 4px; text-decoration: none; font-size: 13px;

        font-weight: bold; letter-spacing: 1px; transition: background 0.2s;

    }

    .btn-add:hover { background: #c41f10; }
 
    .container { padding: 30px; max-width: 1200px; margin: 0 auto; }
 
    .locations-grid {

        display: grid;

        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));

        gap: 20px;

    }
 
    .location-card {

        background: #111; border: 1px solid #222; border-radius: 10px;

        overflow: hidden; transition: transform 0.2s, border-color 0.2s; cursor: pointer;

    }

    .location-card:hover { transform: translateY(-4px); border-color: #e8291c; }
 
    /* Bild oben auf der Karte */

    .location-img-wrap {

        height: 160px;

        overflow: hidden;

        background: #0a001a;

        position: relative;

    }

    .location-img-wrap img {

        width: 100%; height: 100%; object-fit: cover;

        filter: brightness(0.75) saturate(1.1);

        transition: all 0.4s;

        display: block;

    }

    .location-card:hover .location-img-wrap img {

        filter: brightness(0.95) saturate(1.3);

        transform: scale(1.05);

    }

    .location-img-wrap .no-img {

        width: 100%; height: 100%;

        display: flex; align-items: center; justify-content: center;

        font-size: 50px;

        background: linear-gradient(135deg, #0a001a, #111);

    }

    .location-img-overlay {

        position: absolute; bottom: 0; left: 0; right: 0;

        height: 60px;

        background: linear-gradient(to top, #111, transparent);

    }
 
    .location-card-top {

        padding: 16px 20px 14px;

        border-bottom: 1px solid #1a1a1a;

        background: #111;

        text-align: center;

    }

    .location-name {

        font-size: 16px; font-weight: 900; color: #fff;

        letter-spacing: 2px; text-transform: uppercase;

    }

    .location-id { font-size: 11px; color: #444; margin-top: 4px; letter-spacing: 1px; }
 
    .location-card-bottom { padding: 16px 20px; }
 
    .chars-label { font-size: 10px; color: #444; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }

    .chars-list { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; min-height: 28px; }

    .char-tag {

        display: flex; align-items: center; gap: 5px;

        background: #1a1a1a; border: 1px solid #2a2a2a;

        border-radius: 20px; padding: 4px 10px; font-size: 11px; color: #aaa;

    }

    .char-tag .dot { width: 6px; height: 6px; border-radius: 50%; background: #e8291c; flex-shrink: 0; }
 
    .stat-row {

        background: #0a0a0a; border: 1px solid #1a1a1a; border-radius: 6px;

        padding: 10px 14px; display: flex; justify-content: space-between;

        align-items: center; margin-bottom: 14px;

    }

    .stat-row-label { font-size: 11px; color: #444; text-transform: uppercase; letter-spacing: 1px; }

    .stat-row-value { font-size: 14px; color: #e8291c; font-weight: bold; }
 
    .location-actions { display: flex; gap: 8px; }

    .btn-edit {

        flex: 1; background: #1a2a3a; color: #5ba3f5; padding: 8px;

        border-radius: 4px; font-size: 12px; text-decoration: none;

        text-align: center; font-weight: bold; transition: background 0.2s;

    }

    .btn-edit:hover { background: #1e3a5f; }

    .btn-del {

        flex: 1; background: #2a1010; color: #f05555; padding: 8px;

        border-radius: 4px; font-size: 12px; text-decoration: none;

        text-align: center; font-weight: bold; transition: background 0.2s;

    }

    .btn-del:hover { background: #3d1515; }
 
    .empty { text-align: center; padding: 60px; color: #444; font-size: 15px; }

    .empty span { font-size: 40px; display: block; margin-bottom: 12px; }
 
    /* ===== LIGHTBOX ===== */

    .lightbox {

        display: none;

        position: fixed; inset: 0; z-index: 9999;

        background: rgba(0,0,0,0.92);

        align-items: center; justify-content: center;

    }

    .lightbox.active { display: flex; }
 
    .lightbox-inner {

        position: relative;

        max-width: 900px; width: 90%;

        border-radius: 10px;

        overflow: hidden;

        border: 1px solid #333;

        animation: fadeIn 0.3s ease;

    }

    @keyframes fadeIn { from { opacity:0; transform: scale(0.95); } to { opacity:1; transform: scale(1); } }
 
    .lightbox-img {

        width: 100%; display: block;

        max-height: 70vh; object-fit: cover;

        filter: brightness(0.9);

    }

    .lightbox-caption {

        background: #111; padding: 20px 24px;

        display: flex; justify-content: space-between; align-items: center;

    }

    .lightbox-caption h3 {

        font-size: 18px; font-weight: 900; color: #fff;

        text-transform: uppercase; letter-spacing: 3px;

    }

    .lightbox-caption p { font-size: 12px; color: #555; margin-top: 4px; letter-spacing: 1px; }

    .lightbox-close {

        background: #e8291c; color: #fff; border: none;

        width: 36px; height: 36px; border-radius: 50%;

        font-size: 18px; cursor: pointer; flex-shrink: 0;

        display: flex; align-items: center; justify-content: center;

        transition: background 0.2s;

    }

    .lightbox-close:hover { background: #c41f10; }
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
 
    // Bild + Emoji + Beschreibung automatisch anhand Name

    function getLocationData($name) {

        $n = strtolower($name);
 
        $data = [

            // Los Santos

            'los santos'     => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-downtown-dusk.jpg',           'emoji' => '🌆', 'desc' => 'Die Großstadt im Herzen von San Andreas'],

            'downtown'       => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-downtown-dusk.jpg',           'emoji' => '🏙️', 'desc' => 'Das Stadtzentrum von Los Santos'],

            'vinewood'       => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-vinewood-blvd.jpg',           'emoji' => '⭐', 'desc' => 'Der glamouröse Promi-Bezirk'],

            'blaine'         => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-trevor-in-the-desert.jpg',    'emoji' => '🏜️', 'desc' => 'Die raue Wildnis außerhalb der Stadt'],

            'sandy'          => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-alamo-sea.jpg',               'emoji' => '🏕️', 'desc' => 'Trevors Heimat in der Wüste'],

            'beach'          => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-cape-catfish.jpg',            'emoji' => '🏖️', 'desc' => 'Der sonnige Strandbereich von LS'],

            'del perro'      => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-cape-catfish.jpg',            'emoji' => '🏖️', 'desc' => 'Pier und Strandpromenade'],

            'fort'           => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-getting-higher.jpg',          'emoji' => '✈️', 'desc' => 'Militärbasis im Westen'],

            'paleto'         => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-cape-catfish.jpg',            'emoji' => '🌊', 'desc' => 'Kleines Küstenstädtchen im Norden'],

            'rockford'       => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-castle-in-the-hills.jpg',     'emoji' => '🏰', 'desc' => 'Das reiche Nobelviertel von LS'],

            'mirror'         => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-dodging-the-law.jpg',         'emoji' => '🌃', 'desc' => 'Ruhiges Wohnviertel in LS'],

            'grove'          => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-franklin-calls-michael.jpg',  'emoji' => '🏘️', 'desc' => 'Franklins Heimatviertel in Süd-LS'],

            'strawberry'     => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-franklin-calls-michael.jpg',  'emoji' => '🏙️', 'desc' => 'Arbeiterviertel im Süden von LS'],

            'vespucci'       => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-cape-catfish.jpg',            'emoji' => '🏖️', 'desc' => 'Strandviertel mit Pier und Boardwalk'],

            'grapeseed'      => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-sunrise-in-grapeseed.jpg',    'emoji' => '🌾', 'desc' => 'Landwirtschaftliche Gemeinde in Blaine'],

            'zancudo'        => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-getting-higher.jpg',          'emoji' => '✈️', 'desc' => 'Militärstützpunkt mit Sperrgebiet'],

            'alamo'          => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-alamo-sea.jpg',               'emoji' => '🏜️', 'desc' => 'Ausgetrockneter See in Blaine County'],

            'chumash'        => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-lighthouse.jpg',              'emoji' => '🌊', 'desc' => 'Küstenort südlich von Paleto Bay'],

            'sandy shores'   => ['img' => 'https://www.igta5.com/images/official-screenshot-pc-alamo-sea.jpg',               'emoji' => '🏕️', 'desc' => 'Trevors Heimat am Alamo See'],

        ];
 
        // Passendes Bild suchen

        foreach ($data as $keyword => $info) {

            if (strpos($n, $keyword) !== false) return $info;

        }
 
        // Standard falls kein Match

        return ['img' => null, 'emoji' => '📍', 'desc' => 'Ein Ort in San Andreas'];

    }
 
    while ($row = mysqli_fetch_assoc($result)):

        $locData    = getLocationData($row['name']);

        $chars      = mysqli_query($conn,

            "SELECT c.name FROM Characters c

             JOIN Character_Locations cl ON c.id = cl.characterId

             WHERE cl.locationId = " . $row['id']

        );

        $char_count = mysqli_num_rows($chars);

    ?>
<div class="location-card"

             onclick="openLightbox('<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>',

                                   '<?= $locData['img'] ?>',

                                   '<?= htmlspecialchars($locData['desc'], ENT_QUOTES) ?>')"
>
<!-- Bild oben -->
<div class="location-img-wrap">
<?php if ($locData['img']): ?>
<img src="<?= $locData['img'] ?>"

                         alt="<?= htmlspecialchars($row['name']) ?>"

                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
<div class="no-img" style="display:none"><?= $locData['emoji'] ?></div>
<?php else: ?>
<div class="no-img"><?= $locData['emoji'] ?></div>
<?php endif; ?>
<div class="location-img-overlay"></div>
</div>
 
            <!-- Name -->
<div class="location-card-top">
<div class="location-name"><?= htmlspecialchars($row['name']) ?></div>
<div class="location-id">📍 <?= htmlspecialchars($locData['desc']) ?></div>
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

                while ($c = mysqli_fetch_assoc($chars)): ?>
<span class="char-tag">
<span class="dot"></span>
<?= htmlspecialchars($c['name']) ?>
</span>
<?php endwhile; ?>
</div>
 
                <div class="location-actions" onclick="event.stopPropagation()">
<a href="/GTA_Projekt/locations/edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏ Bearbeiten</a>
<a href="/GTA_Projekt/locations/delete.php?id=<?= $row['id'] ?>"

                       class="btn-del"

                       onclick="return confirm('<?= htmlspecialchars($row['name'], ENT_QUOTES) ?> wirklich löschen?')">✕ Löschen</a>
</div>
</div>
</div>
<?php endwhile; ?>
</div>
</div>
 
<!-- ===== LIGHTBOX ===== -->
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
<div class="lightbox-inner" onclick="event.stopPropagation()">
<img class="lightbox-img" id="lightbox-img" src="" alt="">
<div class="lightbox-caption">
<div>
<h3 id="lightbox-title"></h3>
<p id="lightbox-desc"></p>
</div>
<button class="lightbox-close" onclick="closeLightbox()">✕</button>
</div>
</div>
</div>
 
<script>

function openLightbox(name, img, desc) {

    if (!img) return; // kein Bild vorhanden

    document.getElementById('lightbox-img').src   = img;

    document.getElementById('lightbox-title').textContent = name;

    document.getElementById('lightbox-desc').textContent  = desc;

    document.getElementById('lightbox').classList.add('active');

    document.body.style.overflow = 'hidden';

}
 
function closeLightbox() {

    document.getElementById('lightbox').classList.remove('active');

    document.body.style.overflow = '';

}
 
// ESC Taste schließt Lightbox

document.addEventListener('keydown', function(e) {

    if (e.key === 'Escape') closeLightbox();

});
</script>
 
<?php include '../includes/footer.php'; ?>
 