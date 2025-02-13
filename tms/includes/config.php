<?php 
// DB credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tourism');

try {
    // Establish database connection with error mode set to exception
    $dbh = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME, 
        DB_USER, 
        DB_PASS, 
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Set error mode to exception
        )
    );
} catch (PDOException $e) {
    // Handle connection error
    exit("Error: " . $e->getMessage());
}
?>
