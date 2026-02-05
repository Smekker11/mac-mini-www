<?php
/**
 * Access control function for PHP info
 * Allows access only from local network IPs: 192.168.x.x, 10.x.x.x, or localhost (127.0.0.1)
 */
function check_access() {
  // Get the real IP, considering X-Forwarded-For for proxies
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';

  // Allow 192.168.x.x, 10.x.x.x, or 127.0.0.1
  if (preg_match('/^(192\.168\.|10\.|127\.0\.0\.1)/', $ip)) {
    return true;
  }

  return false;
}
?>