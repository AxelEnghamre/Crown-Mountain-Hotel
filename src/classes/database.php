<?php

declare(strict_types=1);

class database
{
     private string $dbName = 'database.db';

     function connect(): object
     {
          $dbPath = __DIR__ . "/../" . $this->dbName;
          $db = "sqlite:$dbPath";

          // Open the database file and catch the exception if it fails.
          try {
               $db = new PDO($db);
               $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
          } catch (PDOException $e) {
               echo "Database error: " . $e->getMessage();
               exit;
          }
          return $db;
     }

     public function fetch(string $tabel): array
     {
          try {
               $db = $this->connect();
               $stmt = $db->query('SELECT * FROM ' . $tabel);
               return $stmt->fetchAll(PDO::FETCH_ASSOC);
          } catch (Exception $e) {
               throw new Exception(
                    sprintf("fetch function failed, couldn't find " . $tabel)
               );
          }
     }
}
