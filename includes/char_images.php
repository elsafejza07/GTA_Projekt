<?php
/**
 * GTA V Charakter-Bild-Mapping
 * Datei: includes/char_images.php
 *
 * Verwendung in anderen PHP-Dateien:
 *   include '../includes/char_images.php';   (aus characters/, weapons/ etc.)
 *   include 'includes/char_images.php';       (aus root index.php)
 *
 *   $result = getCharacterImageOrSVG($row['name'], $row['surname'], $row['role']);
 *   // $result['src']  = Bild-URL oder Data-URL (SVG)
 *   // $result['type'] = 'img' oder 'svg'
 */

// ── Bekannte Charakter-Bilder (Wikipedia Commons, kein Hotlink-Block) ──────────
function getCharacterImage(string $name, string $surname): string
{
    $key = strtolower(trim($name . ' ' . $surname));

    $images = [
        'michael de santa' => '/GTA_Projekt/characters/images/Michael-desanta.webp',
        'trevor philips' => '/GTA_Projekt/characters/images/TrevorPhilips-GTAVee.webp',
        'franklin clinton' => '/GTA_Projekt/characters/images/FranklinClinton-GTAOe-TheContract.webp',
        'lester crest' => '/GTA_Projekt/characters/images/LesterCrest-GTAOe-2019Portrait.webp',
        'lamar davis' => '/GTA_Projekt/characters/images/LamarDavis-GTAOe-2021Portrait.webp',
        'ron jakowski'=> '/GTA_Projekt/characters/images/RonJakowski-GTAOe-2022Portrait.webp',
        'amanda de santa' => '/GTA_Projekt/characters/images/Amanda-GTAV.webp',
        'wade herbert'=> '/GTA_Projekt/characters/images/WadeHerbert-GTAV-Portrait.webp',
        'tracey de santa' => '/GTA_Projekt/characters/images/TraceyDeSanta-GTAVee.webp',
        'jimmy de santa'=> '/GTA_Projekt/characters/images/JimmyDeSanta-GTA5.webp',
        'floyd hebert'=> '/GTA_Projekt/characters/images/FloydHebert-GTAVee.webp',

        // Alias: nur Vorname
        'michael' => '/GTA_Projekt/characters/images/Michael-desanta.webp',
        'trevor' => 'https://upload.wikimedia.org/wikipedia/en/4/48/Trevor_Philips.png',
        'franklin' => 'https://upload.wikimedia.org/wikipedia/en/d/d6/Franklin_Clinton_-_GTA_V.png',
        'lester' => '/GTA_Projekt/characters/images/LesterCrest-GTAOe-2019Portrait.webp', 
        'lamar' => '/GTA_Projekt/characters/images/LamarDavis-GTAOe-2021Portrait.webp',
        'chop' => '/GTA_Projekt/characters/images/Chop_from_GTA.webp',
        'ron'=> '/GTA_Projekt/characters/images/RonJakowski-GTAOe-2022Portrait.webp',
        'amanda' => '/GTA_Projekt/characters/images/Amanda-GTAV.webp',
        'herbert' => '/GTA_Projekt/characters/images/WadeHerbert-GTAV-Portrait.webp',
        'tracey'=> '/GTA_Projekt/characters/images/TraceyDeSanta-GTAVee.webp',
        'jimmy'=> '/GTA_Projekt/characters/images/JimmyDeSanta-GTA5.webp',
        'floyd'=> '/GTA_Projekt/characters/images/FloydHebert-GTAVee.webp',
  ];

    if (isset($images[$key]))
        return $images[$key];

    $fn = strtolower(trim($name));
    if (isset($images[$fn]))
        return $images[$fn];

    return '';
}

// ── SVG-Portrait Generator (kein Netzwerk nötig, immer funktionsfähig) ─────────
function getCharacterSVG(string $name, string $surname, string $role = ''): string
{
    $initials = strtoupper(substr($name, 0, 1) . (strlen(trim($surname)) > 0 ? substr($surname, 0, 1) : substr($name, 1, 1)));

    // Farben je nach Rolle
    switch ($role) {
        case 'Main character':
            $bg1 = '#2a1500';
            $bg2 = '#120900';
            $accent = '#ff8c00';
            $dimAccent = '#ff8c0033';
            break;
        case 'Protagonist':
            $bg1 = '#1a0000';
            $bg2 = '#0a0000';
            $accent = '#e85555';
            $dimAccent = '#e8555533';
            break;
        default:
            $bg1 = '#001a06';
            $bg2 = '#000d03';
            $accent = '#55cc55';
            $dimAccent = '#55cc5533';
    }

    // Deterministisches Muster aus Namens-Hash
    $hash = crc32($name . $surname);
    $px = abs($hash % 200) + 40;
    $py = abs(($hash >> 8) % 120) + 30;
    $r = abs(($hash >> 4) % 80) + 60;

    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 280 200">
  <defs>
    <linearGradient id="gbg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="{$bg1}"/>
      <stop offset="100%" stop-color="{$bg2}"/>
    </linearGradient>
    <radialGradient id="gglow" cx="{$px}" cy="{$py}" r="{$r}" gradientUnits="userSpaceOnUse">
      <stop offset="0%" stop-color="{$accent}" stop-opacity="0.18"/>
      <stop offset="100%" stop-color="{$bg2}" stop-opacity="0"/>
    </radialGradient>
  </defs>

  <!-- Hintergrund -->
  <rect width="280" height="200" fill="url(#gbg)"/>
  <rect width="280" height="200" fill="url(#gglow)"/>

  <!-- Dekor-Linien -->
  <line x1="0" y1="0" x2="280" y2="200" stroke="{$accent}" stroke-width="0.4" opacity="0.2"/>
  <line x1="280" y1="0" x2="0" y2="200" stroke="{$accent}" stroke-width="0.4" opacity="0.1"/>
  <line x1="0" y1="100" x2="280" y2="100" stroke="{$accent}" stroke-width="0.3" opacity="0.08"/>

  <!-- Linker Akzent-Streifen -->
  <rect x="0" y="0" width="4" height="200" fill="{$accent}" opacity="0.9"/>

  <!-- Großer Hintergrund-Buchstabe (Wasserzeichen-Effekt) -->
  <text x="140" y="175" font-family="Arial Black,Impact,sans-serif" font-size="160"
        font-weight="900" fill="{$accent}" text-anchor="middle" opacity="0.06">{$initials}</text>

  <!-- Initialen-Kreis -->
  <circle cx="140" cy="95" r="52" fill="none" stroke="{$accent}" stroke-width="2" opacity="0.3"/>
  <circle cx="140" cy="95" r="48" fill="{$dimAccent}"/>

  <!-- Initialen -->
  <text x="140" y="113" font-family="Arial Black,Impact,sans-serif" font-size="42"
        font-weight="900" fill="{$accent}" text-anchor="middle">{$initials}</text>

  <!-- Unterer Label-Streifen -->
  <rect x="0" y="165" width="280" height="35" fill="rgba(0,0,0,0.55)"/>
  <rect x="0" y="165" width="280" height="1" fill="{$accent}" opacity="0.4"/>
  <text x="20" y="187" font-family="Arial,sans-serif" font-size="11" fill="{$accent}"
        opacity="0.8" letter-spacing="3" font-weight="bold">GTA V</text>
</svg>
SVG;

    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}

// ── Haupt-Funktion: immer ein Bild zurückgeben ───────────────────────────────
/**
 * Gibt immer ein verwendbares Bild zurück.
 * Bekannte Charaktere → echte Foto-URL
 * Unbekannte Charaktere → schönes SVG-Portrait (inline, kein Netzwerk nötig)
 *
 * Rückgabe: ['src' => '...', 'type' => 'img'|'svg']
 */
function getCharacterImageOrSVG(string $name, string $surname, string $role = ''): array
{
    $url = getCharacterImage($name, $surname);
    if ($url) {
        return ['type' => 'img', 'src' => $url];
    }
    return ['type' => 'svg', 'src' => getCharacterSVG($name, $surname, $role)];
}
?>