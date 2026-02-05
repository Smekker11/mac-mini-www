<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Info — Mac Mini Server</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { background: black !important; color: white !important; }
        .center { text-align: left !important; color: white !important; }
        .e { background: #111 !important; color: white !important; }
        .v { background: #222 !important; color: white !important; }
        table { border-collapse: collapse !important; width: 100% !important; border: 1px solid #333 !important; }
        td, th { border: 1px solid #333 !important; padding: 8px !important; color: white !important; }
        a { color: #00aaff !important; }
        .down-menu a { background: white !important; color: black !important; padding: 8px 12px !important; border-radius: 4px !important; text-decoration: none !important; }
    </style>
</head>
<body class="">
    <?php
    include 'access_control.php';
    if (!check_access()) {
        http_response_code(403);
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        echo '<div style="text-align: center; color: white; background: black; height: 100vh; display: flex; align-items: center; justify-content: center;"><h1>Access Denied</h1><p>PHP Info is only accessible from local networks.</p><p>Your IP: ' . htmlspecialchars($ip) . '</p></div> <div class="down-menu"><small><a href="index.php" class="transition-link" style="color: var(--text-secondary);">← Back to Home</a></small></div>';
        exit;
    }
    ?>

        <section class="tiles" style="grid-template-columns: 1fr; grid-auto-rows: auto;">
            <article class="tile tile--wide" style="overflow: visible;">
                <div style="font-size:14px; text-align: center;">
                    <h3 style="margin-bottom:12px;">PHP Configuration</h3>
                    <div style="background: rgba(255,255,255,0.05); padding: 16px; border-radius: 8px; border: 1px solid var(--line); display:flex; align-items:center; justify-content:center; min-height:100vh; padding:10px;">
                        <?php phpinfo(); ?>
                    </div>
                </div>
            </article>
        </section>
         <div class="down-menu">
        <small><a href="index.php" class="transition-link" style="color: var(--text-secondary);">← Back to Home</a></small>
      </div>
    <script src="page-transitions.js"></script>
    <script>initPageTransitions();</script>
</body>
</html>