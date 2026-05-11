<?php include_once __DIR__ . '/db_connect.php'; ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GTA V Datenbank</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #0a0a0a;
            color: #fff;
        }

        nav {
            background: #111111;
            border-bottom: 2px solid #e8291c;
            padding: 0 30px;
            display: flex;
            align-items: center;
            gap: 25px;
            height: 58px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav .logo {
            color: #e8291c;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 3px;
            margin-right: 10px;
        }

        nav a {
            color: #aaaaaa;
            text-decoration: none;
            font-size: 14px;
            padding: 5px 0;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        nav a:hover {
            color: #ffffff;
            border-bottom: 2px solid #e8291c;
        }

        nav .btn-add {
            margin-left: auto;
            background: #e8291c;
            color: #fff !important;
            padding: 8px 20px;
            border-radius: 4px;
            border-bottom: none !important;
            font-size: 13px;
        }

        nav .btn-add:hover {
            background: #c41f10;
            border-bottom: none !important;
        }
    </style>
</head>
<body>

<nav>
    <span class="logo">GTA V</span>
    <a href="/GTA_Projekt/scripts/index.php">Startseite</a>
    <a href="/GTA_Projekt/characters/index.php">Charaktere</a>
    <a href="/GTA_Projekt/weapons/index.php">Waffen</a>
    <a href="/GTA_Projekt/vehicles/index.php">Fahrzeuge</a>
    <a href="/GTA_Projekt/locations/index.php">Locations</a>
</nav>