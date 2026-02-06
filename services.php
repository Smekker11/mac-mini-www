<?php
// services.php — scan ports using services.ini config

/**
 * Load INI configuration safely
 * returns array: ['host'=>string,'timeout'=>int,'ports'=>[port=>name,...]]
 */
function load_services_config(string $file): array {
  if (!file_exists($file)) {
    return [
      'host' => '127.0.0.1',
      'timeout' => 1,
      'ports' => [],
      'error' => "Config file not found: {$file}"
    ];
  }

  $config = parse_ini_file($file, true, INI_SCANNER_TYPED);

  return [
    'host'    => $config['server']['host']    ?? '127.0.0.1',
    'timeout' => (int)($config['server']['timeout'] ?? 1),
    'ports'   => $config['ports']             ?? [],
  ];
}

/**
 * Scan ports defined in services.ini
 * Returns: [port => ['name' => string, 'status' => 'open'|'closed']]
 */
function scan_ports(array $ports, string $host, int $timeout): array {
  $results = [];

  foreach ($ports as $port => $name) {
    $fp = @fsockopen($host, (int)$port, $errno, $errstr, $timeout);

    $results[(int)$port] = [
      'name'   => (string)$name,
      'status' => $fp ? 'open' : 'closed'
    ];

    if ($fp) fclose($fp);
  }

  return $results;
}

/* -------------------------------
   Bootstrap
-------------------------------- */

$config = load_services_config(__DIR__ . '/config.ini');
$results = [];
$error = $config['error'] ?? null;

if (empty($error)) {
  $results = scan_ports($config['ports'], $config['host'], (int)$config['timeout']);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Services — Mac Mini</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="apple-touch-icon" sizes="180x180" href="ico/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
<link rel="manifest" href="ico/site.webmanifest">
  <style>
    .tile--wide:hover { transform: none; box-shadow: none; }
    .tile--wide { flex-direction: column; overflow: visible; min-height: auto; }
    .scan-results { flex-wrap: wrap; justify-content: center; }
    .status-open { color: #00ff00; text-shadow: 0 0 10px #00ff00, 0 0 20px #00ff00; font-weight: 700; }
    .status-closed { color: #ff0000; font-weight: 700; }
  </style>
  <style>
    @media (max-width:768px){
      .scan-results{ flex-wrap: wrap; }
      .port-row{ flex: 0 0 100%; max-width: 200px; }
    }
  </style>
</head>
<body class="page-transition page-hidden" style="display: block; margin:0; padding:0;">
  <div style="display:flex; align-items:center; justify-content:center; min-height:100vh; padding:10px;">
    <div class="container">
      <article class="tile tile--wide">
      <header class="hero" style="background: none; border: none; backdrop-filter: none;">
        <div class="logo"><img src="mac-mini.svg" alt="Mac Mini" width="76" height="64"></div>
        <h1 class="title">Services</h1>
        <p class="subtitle">Quick port/service check on this machine.</p>
      </header>

      <?php if (!empty($error)): ?>
        <p class="" style="color:var(--muted);margin-top:12px"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <?php if (empty($error)): ?>
        <div class="results-container">
          <div class="scan-results">
          <?php if (empty($results)): ?>
            <p style="color:var(--text-secondary);margin-top:12px">No ports configured to scan.</p>
          <?php else: ?>
              <?php foreach ($results as $port => $info):
                // choose a random accent color per tile and create a blended Metro-style background
                $colors = ['#0078d7','#00b3a6','#c51162','#ffb020','#6c63ff','#1abc9c'];
                $hex = $colors[array_rand($colors)];
                // convert hex to rgb
                $hexClean = ltrim($hex, '#');
                if (strlen($hexClean) === 3) {
                  $r = hexdec(str_repeat(substr($hexClean,0,1),2));
                  $g = hexdec(str_repeat(substr($hexClean,1,1),2));
                  $b = hexdec(str_repeat(substr($hexClean,2,1),2));
                } else {
                  $r = hexdec(substr($hexClean,0,2));
                  $g = hexdec(substr($hexClean,2,2));
                  $b = hexdec(substr($hexClean,4,2));
                }
                $bg = "background:linear-gradient(180deg, rgba($r,$g,$b,0.18), rgba($r,$g,$b,0.12)); border-color: rgba($r,$g,$b,0.12);";
              ?>
                <div class="port-row" style="<?php echo $bg; ?> color:var(--text);">
                  <div style="text-align:center">
                    <div style="font-size:14px;font-weight:700;color:var(--text)"><?php echo htmlspecialchars($info['name']); ?></div>
                    <div style="color:var(--text-secondary);font-size:13px;margin-top:6px">Port <?php echo (int)$port; ?></div>
                  </div>
                  <div class="<?php echo $info['status'] === 'open' ? 'status-open' : 'status-closed'; ?>"><?php echo $info['status']; ?></div>
                </div>
              <?php endforeach; ?>
          <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="down-menu">
        <small><a href="index.php" class="transition-link" style="color: var(--text-secondary);">← Back to Home</a></small>
      </div>
    </article>
  </div>
  </div>

  <script src="page-transitions.js"></script>
  <script>initPageTransitions();</script>
</body>
</html>
