<?php

namespace App\core;

use PDO;
use PDOException;

/**
 ** DATABASE CONNECTION
 */
class Database {

    public $conn;

    public function __construct(array $config) {
        $this->conn = null;

        $dsn    = $config['dsn']    ?? '';
        $user   = $config['user']   ?? '';
        $pass   = $config['pass']   ?? '';

        try {
            $this->conn = new PDO($dsn, $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "CONNECTION ERROR! " . $e->getMessage();
        }
    }

    /**
     ** APPLY MIGRATION
     *
     * @return void
     */
    public function applyMigration() {
        $this->createMigTable();
        $appliedMig = $this->getAppliedMig();
        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $toAppliedMig = array_diff($files, $appliedMig);

        foreach ($toAppliedMig as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className =  pathinfo($migration, PATHINFO_FILENAME);
            $inst = new $className();
            $this->log("Applying migration $migration");
            $inst->up();
            $this->log("Applyied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMig($newMigrations);
        } else {
            $this->log("All migrations applied");
        }

    }

    /**
     ** CREATE MIGRATIONS TABLE ON DATABASE
     *
     * @return void
     */
    private function createMigTable() {
        $this->conn->exec(
            "CREATE TABLE IF NOT EXISTs migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );"
        );
    }

    /**
     ** GET APPLIED MIGRATIONS
     *
     * @return void
     */
    function getAppliedMig() {
        $stmt = $this->conn->prepare("SELECT migration FROM migrations");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function saveMig(array $migrations) {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));
        $stmt = $this->conn->prepare("INSERT INTO migrations (migration) VALUES $str");
        $stmt->execute();
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    protected function log(string $message){
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message.PHP_EOL;
    }

}
