<?php
/**
 * Database utility functions
 */

/**
 * Create and configure database connection
 * @return mysqli Database connection object
 * @throws Exception If connection fails
 */
function getDbConnection(): mysqli {
    require_once(__DIR__ . '/../dbconfig.php');
    
    if (!isset($dbhost, $dbuser, $dbpassword, $database)) {
        throw new Exception("Error: Database configuration variables not set in dbconfig.php");
    }
    
    $dbport_int = isset($dbport) ? (int)$dbport : 3306;
    $db = new mysqli($dbhost, $dbuser, $dbpassword, $database, $dbport_int);
    
    if ($db->connect_error) {
        throw new Exception("Connection Error: " . $db->connect_error);
    }
    
    // Use utf8mb4 for full UTF-8 support (including 4-byte characters)
    $db->set_charset('utf8mb4');
    $db->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    $db->query("SET CHARACTER SET utf8mb4");
    $db->query("SET character_set_client = utf8mb4");
    $db->query("SET character_set_results = utf8mb4");
    $db->query("SET character_set_connection = utf8mb4");
    $db->query("SET sql_mode = ''");
    
    return $db;
}

/**
 * Execute a database query with error handling
 * @param mysqli $db Database connection
 * @param string $sql SQL query
 * @param bool $debug Enable debug output
 * @return mysqli_result|false Query result or false on failure
 */
function executeQuery(mysqli $db, string $sql, bool $debug = false) {
    if ($debug) {
        echo "<!-- DEBUG SQL: " . htmlspecialchars($sql) . " -->\n";
    }
    
    $result = $db->query($sql);
    
    if ($result === false) {
        $error_msg = "Query Error: " . $db->error;
        if ($debug) {
            $error_msg .= "\n\nSQL Query:\n" . htmlspecialchars($sql);
        }
        throw new Exception($error_msg);
    }
    
    return $result;
}

/**
 * Escape string for SQL query
 * @param mysqli $db Database connection
 * @param string $value Value to escape
 * @return string Escaped value
 */
function escapeSql(mysqli $db, string $value): string {
    return $db->real_escape_string($value);
}

