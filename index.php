<!DOCTYPE html>
<?php include 'access_control.php'; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mac Mini Server</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="apple-touch-icon" sizes="180x180" href="ico/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
<link rel="manifest" href="ico/site.webmanifest">
</head>
<body class="page-transition page-hidden">
    <div style="display:flex; align-items:center; justify-content:center; min-height:100vh; padding:10px;">
    <div class="container">
        <header class="hero">
            <div class="logo">
                <img src="mac-mini.svg" alt="Mac Mini Server" width="76" height="64"/>
            </div>
            <h1 class="title">merky.home.ro</h1>
            <p class="subtitle">Mac Mini - Web Server core of merky.home</p>
            <p class="meta">Local IP: <strong><?php echo $_SERVER['SERVER_ADDR'] ?? 'localhost'; ?></strong> • PHP: <strong><?php echo phpversion(); ?></strong></p>
            <p><a class="cta" href="hampter-satumare.php">hampter.php</a></p>
        </header>

        <section id="tiles" class="tiles" aria-label="Features">
            <article class="tile tile--blue" tabindex="0">
                <a class="tile-link transition-link" href="pages.php" style="display:block;padding:0;margin:0;color:inherit">
                    <div style="display:flex;align-items:center;gap:12px">
                        <img class="icon" src="metro/Globe%20Earth.svg" alt="Static Sites" width="36" height="36" />
                        <div>
                            <h3>Pages</h3>
                            <p>Index of http root.</p>
                        </div>
                    </div>
                </a>
            </article>

            <!-- Minecraft tile (distinct green accent) -->
            <article class="tile tile--green" tabindex="0">
                <a class="tile-link transition-link" href="minecraft.php" style="display:block;padding:0;margin:0;color:inherit">
                    <div style="display:flex;align-items:center;gap:12px">
                        <img class="icon" src="metro/Grass-Block-1.svg" alt="Minecraft" width="36" height="36" />
                        <div>
                            <h3>Minecraft</h3>
                            <p>Index for the Minecraft servers mods.</p>
                        </div>
                    </div>
                </a>
            </article>

            <?php $hasAccess = check_access(); ?>
<article class="tile tile--teal" tabindex="0" style="cursor: <?= $hasAccess ? 'pointer' : 'not-allowed'; ?>;">
    <?php if ($hasAccess): ?>
        <a class="tile-link transition-link" href="phpinfo.php" style="display:block;padding:0;margin:0;color:inherit">
    <?php endif; ?>

    <div style="display:flex;align-items:center;gap:12px">
        <img class="icon" src="metro/Php.svg" alt="PHP Ready" width="36" height="36" /><!--php-->
        <div>
            <h3>PHP Ready</h3>
            <p>PHP is installed and configured.</p>
            <p>phpinfo(); dump enabled for intranet users</p>
        </div>
    </div>

    <?php if ($hasAccess): ?>
        </a>
    <?php endif; ?>
</article>


            <?php if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'): ?>
            <article class="tile tile--magenta">
                <div style="display:flex;align-items:center;gap:12px">
                    <img class="icon" src="metro/Security%20Checked.svg" alt="Secure" width="36" height="36" />
                    <div>
                        <h3>Secure</h3>
                        <p>Use SSH, manage packages and enabled HTTPS with Let's Encrypt secure CERTBOT certifications.</p>
                    </div>
                </div>
            </article>
            <?php endif; ?>

            <article class="tile tile--amber" tabindex="0">
                <a class="tile-link transition-link" href="services.php" style="display:block;padding:0;margin:0;color:inherit">
                    <div style="display:flex;align-items:center;gap:12px">
                        <img class="icon" src="metro/Settings.svg" alt="Customizable" width="36" height="36" />
                        <div>
                            <h3>Services</h3>
                            <p>Check running services status.</p>
                        </div>
                    </div>
                </a>
            </article>
        </section>

        <section class="feature">
            <div class="device">
                <a class="device-link" href="ascii-neofetch.php" title="Ascii Neofetch" style="display:inline-block">
                    <img src="mac-mini.svg" alt="Mac Mini" width="120"/>
                </a>
            </div>
            <div class="feature-text">
                <h2><?php echo gethostname() . "@merky.home.ro"; ?></h2>
                <p><?php echo trim(file_get_contents('/sys/devices/virtual/dmi/id/sys_vendor')) . " "; echo trim(file_get_contents('/sys/devices/virtual/dmi/id/product_name')); ?></p>
            </div>
        </section>

        <footer class="foot">
            <small>Copyright ©2026 meperky cod,<code>Mac Mini Server</code>. /index.php</small>
        </footer>
        </div>
    </div>

        <script src="page-transitions.js"></script>
        <script>initPageTransitions();</script>
</body>
</html>