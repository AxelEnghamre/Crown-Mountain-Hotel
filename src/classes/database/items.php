<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database.php');

class items extends database
{
     // create
     public function create(string $name, int $price): void
     {
          $db = $this->connect();

          $query = "INSERT INTO items
                    (
                         name,
                         price
                    )
                    VALUES
                    (
                         :input_name,
                         :input_price
                    )
          ";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_name', $name, PDO::PARAM_STR);
          $stmt->bindParam('input_price', $price, PDO::PARAM_INT);
          $stmt->execute();
     }

     // update
     public function update(int $id, string $name, int $price): void
     {
          $db = $this->connect();

          $query = "UPDATE items SET
                    name = :input_name,
                    price = :input_price
                    WHERE id = :input_id
          ";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_name', $name, PDO::PARAM_STR);
          $stmt->bindParam('input_price', $price, PDO::PARAM_INT);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();
     }

     // delete
     public function delete(int $id): void
     {
          $db = $this->connect();

          $query = "DELETE FROM items WHERE id = :input_id";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();
     }

     // get all items
     public function getAll(): array
     {
          $db = $this->connect();

          $query = "SELECT * FROM items";

          $stmt = $db->prepare($query);
          $stmt->execute();


          $response = $stmt->fetchAll();

          if (isset($response[0])) {
               return $response;
          }

          return [];
     }

     // get an item
     public function get(int $id): array
     {
          $db = $this->connect();

          $query = "SELECT * FROM items WHERE id = :input_id";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();


          $response = $stmt->fetch();

          if (isset($response['id'])) {
               return $response;
          }

          return [];
     }

     public function setup(): void
     {
          $db = $this->connect();

          $query = "CREATE TABLE items (
               id INTEGER PRIMARY KEY AUTOINCREMENT,
               name VARCHAR(50),
               price INTEGER
          )
          ";

          $db->query($query);
     }
}
