<?php
/**
 * Environment-aware configuration
 * Detects production vs development environment and sets appropriate URLs
 */

// Detect environment based on hostname or environment variable
function detectEnvironment(): string {
    // Check environment variable first (for explicit control)
    if (isset($_ENV['BIBLEENGINE_ENV'])) {
        return $_ENV['BIBLEENGINE_ENV'] === 'dev' ? 'dev' : 'prod';
    }
    
    // Check hostname
    $hostname = $_SERVER['HTTP_HOST'] ?? '';
    
    // Development domains
    if (strpos($hostname, 'bibledev.com') !== false || 
        strpos($hostname, 'dev.bibleengine') !== false ||
        strpos($hostname, 'bibleengine.dev') !== false ||
        strpos($hostname, 'localhost') !== false ||
        strpos($hostname, '127.0.0.1') !== false) {
        return 'dev';
    }
    
    // Default to production
    return 'prod';
}

// Get environment-specific configuration
function getEnvironmentConfig(): array {
    $env = detectEnvironment();
    
    if ($env === 'dev') {
        return [
            'short_url_base' => 'https://bibledev.com',
            'long_url_base' => 'https://bibledev.com',
            'img_url' => 'https://bibledev.com',
            'sitename' => 'BibleDev.com',
            'wiki_base' => 'https://bible.world/w',
            'wiki_search_base' => 'https://bible.world/w',
            'github_url' => 'https://github.com/viaifoundation/bibleengine',
            'engine_name_en' => 'Goshen Bible Engine (Dev)',
            'engine_name_cn' => '歌珊地圣经引擎 (开发版)',
            'copyright_text' => '2004-2024 歌珊地科技 Goshen Tech, 2025-2026 唯爱AI基金会 VI AI Foundation',
        ];
    } else {
        // Production configuration
        return [
            'short_url_base' => 'https://bibleengine.ai',
            'long_url_base' => 'https://bibleengine.ai',
            'img_url' => 'https://bibleengine.ai',
            'sitename' => 'BibleEngine.ai',
            'wiki_base' => 'https://bible.world/w',
            'wiki_search_base' => 'https://bible.world/w',
            'github_url' => 'https://github.com/viaifoundation/bibleengine',
            'engine_name_en' => 'Goshen Bible Engine',
            'engine_name_cn' => '歌珊地圣经引擎',
            'copyright_text' => '2004-2024 歌珊地科技 Goshen Tech, 2025-2026 唯爱AI基金会 VI AI Foundation',
        ];
    }
}

// Initialize environment configuration
$env_config = getEnvironmentConfig();

// Set global variables from environment config
$short_url_base = $env_config['short_url_base'];
$long_url_base = $env_config['long_url_base'];
$img_url = $env_config['img_url'];
$sitename = $env_config['sitename'];
$wiki_base = $env_config['wiki_base'];
$wiki_search_base = $env_config['wiki_search_base'];
$github_url = $env_config['github_url'];
$engine_name_en = $env_config['engine_name_en'];
$engine_name_cn = $env_config['engine_name_cn'];
$copyright_text = $env_config['copyright_text'];

