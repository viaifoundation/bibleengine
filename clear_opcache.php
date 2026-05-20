<?php
// clear_opcache.php - Helper script to reset OPCache in the web server environment
header('Content-Type: text/plain');

if (function_exists('opcache_reset')) {
    if (opcache_reset()) {
        echo "OPCache reset successfully!\n";
    } else {
        echo "Failed to reset OPCache.\n";
    }
} else {
    echo "OPCache extension is not enabled or opcache_reset() is disabled.\n";
}
