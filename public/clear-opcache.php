<?php
// Temporary file to clear opcache - DELETE THIS FILE AFTER USE
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache cleared successfully!";
} else {
    echo "OPcache is not enabled.";
}
// Delete this file after clearing cache
if (file_exists(__FILE__)) {
    unlink(__FILE__);
}
