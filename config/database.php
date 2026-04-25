<?php
// config/database.php

class Database {
    private static $pdo = null;

    /**
     * Get the PDO connection to the SQLite database
     * @return PDO
     */
    public static function getConnection() {
        if (self::$pdo === null) {
            try {
                // Ensure db directory exists
                $dbDir = dirname(__DIR__) . '/db';
                if (!is_dir($dbDir)) {
                    mkdir($dbDir, 0755, true);
                }

                $dbPath = $dbDir . '/kds.sqlite';
                
                // Establish connection
                self::$pdo = new PDO("sqlite:" . $dbPath);
                
                // Configure error reporting and fetch mode
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
                // Enable foreign keys in SQLite
                self::$pdo->exec("PRAGMA foreign_keys = ON;");
                
            } catch (PDOException $e) {
                // In production, log this and show a clean error page. For now, output the error.
                die("Database Connection Error: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
