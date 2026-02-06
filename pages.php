<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages — Mac Mini Server</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body class="page-transition">
    <div style="display:flex; align-items:center; justify-content:center; min-height:100vh; padding:10px;">
    <div class="container">
        <header class="hero">
            <div class="logo">
                <img src="mac-mini.svg" alt="Mac Mini Server" width="76" height="64"/>
            </div>
            <h1 class="title">Pages</h1>
            <p class="subtitle">Index of files in the root folder.</p>
        </header>

        <section class="tiles" style="grid-template-columns: 1fr; grid-auto-rows: auto;">
            <article class="tile tile--wide" style="overflow: visible;">
                <div style="font-size:14px;">
                    <h3 style="margin-bottom:12px;">Index of /var/www/html</h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <?php
                        function generate_tree($path, $level = 0) {
                          $html = '';
                          $items = scandir($path);
                          $items = array_diff($items, ['.', '..', '.git']);
                          foreach ($items as $item) {
                            $fullpath = $path . '/' . $item;
                            if (is_file($fullpath)) {
                              $html .= "<li style='margin: 10px 0;'><a href='$fullpath' style='color: var(--text); text-decoration: none; padding: 4px 8px; border-radius: 4px; background: rgba(0,120,215,0.1); display: inline-block; max-width: 100%; word-wrap: break-word;' onmouseover='this.style.background=\"rgba(0,120,215,0.2)\"' onmouseout='this.style.background=\"rgba(0,120,215,0.1)\"'>$item</a></li>";
                            } elseif (is_dir($fullpath)) {
                              $subHtml = generate_tree($fullpath, $level + 1);
                              $html .= "<li style='margin: 10px 0;'><details style='border: 1px solid var(--line); border-radius: 4px; padding: 8px; margin-bottom: 12px;'><summary style='cursor: pointer; font-weight: 600; color: var(--text); user-select: none;'>$item/</summary><ul style='list-style: none; padding-left: 16px; margin-top: 8px;'>$subHtml</ul></details></li>";
                            }
                          }
                          return $html;
                        }
                        echo generate_tree('.');
                        ?>
                    </ul>
                </div>
            </article>
        </section>

        <footer class="foot">
            <small><a href="index.php" class="transition-link" style="color: var(--text-secondary);">← Back to Home</a></small>
        </footer>
    </div>
    </div>

    <script src="page-transitions.js"></script>
    <script>initPageTransitions();</script>
</body>
</html>