<!DOCTYPE html>
<?php include 'access_control.php'; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mac Mini Server</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="page-transition page-hidden">
    <div style="display:flex; align-items:center; justify-content:center; min-height:100vh; padding:10px;">
    <div class="container">
        <header class="hero">
            <div class="logo">
                <img src="mac-mini.svg" alt="Mac Mini Server" width="76" height="64"/>
            </div>
            <h1 class="title">Mac Mini — Server</h1>
            <p class="subtitle">Lightweight, fast, and ready to host your sites.</p>
            <p class="meta">IP: <strong><?php echo $_SERVER['SERVER_ADDR'] ?? 'localhost'; ?></strong> • PHP: <strong><?php echo phpversion(); ?></strong></p>
            <p><a class="cta" href="hampter-satumare.php">hampter</a></p>
        </header>

        <section id="tiles" class="tiles" aria-label="Features">
            <article class="tile tile--blue" tabindex="0">
                <a class="tile-link transition-link" href="pages.php" style="display:block;padding:0;margin:0;color:inherit">
                    <div style="display:flex;align-items:center;gap:12px">
                        <img class="icon" src="metro/Globe%20Earth.svg" alt="Static Sites" width="36" height="36" />
                        <div>
                            <h3>Pages</h3>
                            <p>Self-Hosted projects list.</p>
                        </div>
                    </div>
                </a>
            </article>

            <!-- Minecraft tile (distinct green accent) -->
            <article class="tile tile--green" tabindex="0">
                <a class="tile-link transition-link" href="minecraft/" style="display:block;padding:0;margin:0;color:inherit">
                    <div style="display:flex;align-items:center;gap:12px">
                        <img class="icon" src="minecraft/Grass-Block-1.svg" alt="Minecraft" width="36" height="36" />
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
        <img class="icon" src="metro/php.svg" alt="PHP Ready" width="36" height="36" />
        <div>
            <h3>PHP Ready</h3>
            <p>PHP is installed and configured. Dynamic apps and frameworks will run here.</p>
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
                        <p>Use SSH, manage packages and enable HTTPS with Let's Encrypt quickly.</p>
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
                            <p>Check services and manage them.</p>
                        </div>
                    </div>
                </a>
            </article>
        </section>

        <section class="feature">
            <div class="device">
                <img src="mac-mini.svg" alt="Mac Mini" width="120"/>
            </div>
            <div class="feature-text">
                <h2>Ready to go</h2>
                <p>Drop your projects into the server directory and point your browser to this machine's IP to preview them instantly.</p>
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