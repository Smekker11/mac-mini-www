# Mac Mini — Local Server

Simple local web index and utilities. MAC MINI DASHBOARD.

Important: php-zip REQUIRED on Debian/Ubuntu. Research for other distros, the ZIP dependency.
- If you run this on Debian/Ubuntu and do not install `php-zip`, the "Download All JARs" feature WILL FAIL.
	Install it with:

```bash
sudo apt update
sudo apt install php-zip
```

Quick setup
- Put the files in your root.
- Ensure PHP is installed and the webserver works.
- Edit the allowed JAR root path in `minecraft/index.php` to point at your jars directory.
- Edit the services params `config.ini` to customize.

What it does
- Provides a simple Metro-style dashboard with tiles for Pages, PHP Info, Services, and Minecraft.
- `minecraft/` lists `.jar` files and can generate a temporary ZIP named in format: `jars_YYYYmmdd_HHMMSS_######.zip`.

How the Minecraft zip works
- Clicking "Download All JARs" hits the handler at the top of `minecraft/index.php`. It creates a temporary ZIP in the system temp dir named like `merky_mods_{$dt}_{$rand}.zip`, streams it to the requester, then deletes the temp file.
- If no `.jar` files exist, it returns a 404 and a brief message.

Security notes
- DO NOT point `$ALLOWED_ROOT` at `/` or any sensitive folder.
- The ZIPer reads only files under the configured `$ALLOWED_ROOT`.
- WIP `access_control.php` for intranet.

Troubleshooting
- ZIP errors usually mean `php-zip` is missing or file permissions prevent creating temp files.
- php info shows access denied if lacking intranet access due to `access_control.php` and your client IP.
- no provided direcory in `config.ini`

What is here
- `index.php` — the main Metro-style dashboard (tiles link to the other pages).
- `pages.php` — a generic pages index dashboard.
- `services.php` and `config.ini` — simple service checks / config.
- `phpinfo.php` — system PHP info (protected by `access_control.php`).
- `access_control.php` — tiny gatekeeper used by sensitive pages; adjust for your network.
- `minecraft/` — a subfolder containing its own `index.php` (lists `.jar` files). It also contains `styles.css` and `Grass-Block-1.svg`.
- `hampter-satumare.php` and `hampter-satumare.png` — a single-image page you can open directly.
- `styles.css` and `page-transitions.js` — global styling and page transition utilities.
- `metro/` — a folder full of SVG assets for the UI (skip scanning these unless you need them).

- There is no global `download.php` in this repo; individual file links in `minecraft/index.php` point to `download.php?file=...` — if you rely on that, add an implementation or use the "Download All JARs" button which is handled in `minecraft/index.php`.

License
-  <small>Copyright ©2026 meperky cod,<code>Mac Mini Server</code>. /index.php</small>
MAC MINI DASHBOARD SERVER
