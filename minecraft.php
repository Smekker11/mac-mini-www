<?php
// Download handler: generate a temporary zip of all .jar files and serve it
// Define allowed root early so headers can be sent before HTML output.
$config = load_services_config(__DIR__ . '/config.ini');
function load_services_config(string $file): array {
  if (!file_exists($file)) {
    die('Config file not found: ' . htmlspecialchars($file, ENT_QUOTES, 'UTF-8'));
  }

  $config = parse_ini_file($file, true, INI_SCANNER_TYPED);

  return [
    'mc_path' => $config['settings']['mc_path'] ?? '/usr/local/mc',
  ];
}

$ALLOWED_ROOT = realpath($config['mc_path']);

if ($ALLOWED_ROOT === false) {
    die('Configured root path does not exist. Check config.ini settings.');
}

function generate_and_send_jars_zip($root) {
    if (!extension_loaded('zip')) {
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Zip extension not available.';
        exit;
    }

    $files = scandir($root);
    $rand = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $dt = date('Ymd_His');
    $tmpName = "merky_mods_{$dt}_{$rand}.zip";
    $tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $tmpName;

    $zip = new ZipArchive();
    if ($zip->open($tmpPath, ZipArchive::CREATE) !== true) {
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Could not create zip file.';
        exit;
    }

    $added = 0;
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        $full = $root . DIRECTORY_SEPARATOR . $file;
        if (is_file($full) && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'jar') {
            $zip->addFile($full, $file);
            $added++;
        }
    }

    $zip->close();

    if ($added === 0) {
        @unlink($tmpPath);
        header('HTTP/1.1 404 Not Found');
        echo 'No JAR files found to include in the archive.';
        exit;
    }

    // Serve the file
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $tmpName . '"');
    header('Content-Length: ' . filesize($tmpPath));
    readfile($tmpPath);
    @unlink($tmpPath);
    exit;
}

if (isset($_GET['download_all']) && $_GET['download_all'] === '1') {
    generate_and_send_jars_zip($ALLOWED_ROOT);
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Minecraft Mods — Mac Mini Server</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body class="page-transition">
        <div style="display:flex; align-items:center; justify-content:center; min-height:100vh; padding:10px;">
            <div class="container">
                <header class="hero">
                    <div class="logo">
                        <img src="metro/Grass-Block-1.svg" alt="Mac Mini Server" width="76" height="64" />
                    </div>
                    <h1 class="title">Minecraft Mods</h1>
                    <p class="subtitle">Index of mods running on the minecraft server.</p>
                </header>

                <section class="tiles" style="grid-template-columns: 1fr; grid-auto-rows: auto;">
                    <article class="tile tile--wide" style="overflow: visible;">
                        <div style="font-size:14px;">
                            <p class="subtitle" style="margin-bottom:12px;">This will generate the latest /mods jar dump zip file.</p>
                            <form method="get" action="" style="margin-bottom:12px;">
                                <input type="hidden" name="download_all" value="1" />
                                <button type="submit" style="color: var(--text); background: rgba(0,120,215,0.1); border: none; padding:6px 10px; border-radius:4px; cursor:pointer;">Mods zip file download</button>
                            </form>

                            <h3 style="margin-bottom:12px;">Index of /mods</h3>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <?php

                                function list_jars($root) {
                                    $html = '';

                                    $files = scandir($root);

                                    foreach ($files as $file) {
                                        if ($file === '.' || $file === '..') {
                                            continue;
                                        }

                                        $fullpath = $root . DIRECTORY_SEPARATOR . $file;

                                        // Only allow .jar files
                                        if (is_file($fullpath) && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'jar') {
                                            $safeName = htmlspecialchars($file, ENT_QUOTES, 'UTF-8');
                                            $url = 'download.php?file=' . urlencode($file);

                                            $html .= "<li style=\"margin:10px 0;\">"
                                                . "<a href=\"{$url}\" style=\"color: var(--text); text-decoration:none; padding:4px 8px; border-radius:4px; background:rgba(0,120,215,0.1); display:inline-block;\">"
                                                . "{$safeName}</a></li>\n";
                                        }
                                    }

                                    return $html;
                                }

                                echo list_jars($ALLOWED_ROOT);

                                ?>
                            </ul>
                        </div>
                    </article>
                </section>

                <footer class="foot">
                    <small><a href="/" class="transition-link" style="color: var(--text-secondary);">← Back to Home</a></small>
                </footer>
            </div>
        </div>

        <script src="page-transitions.js"></script>
        <script>initPageTransitions();</script>
    </body>
</html>