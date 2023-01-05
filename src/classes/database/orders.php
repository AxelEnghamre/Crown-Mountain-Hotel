<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database.php');

class orders extends database
{
     // create
     public function create(string $userName, string $transferCode, int $grossPrice, int $discount, int $netPrice): void
     {
          $db = $this->connect();

          $query = "INSERT INTO orders
                    (
                         user_name,
                         transfer_code,
                         gross_price,
                         discount,
                         net_price
                    )
                    VALUES
                    (
                         :input_user_name,
                         :input_transfer_code,
                         :input_gross_price,
                         :input_discount,
                         :input_net_price
                    )
          ";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_user_name', $userName, PDO::PARAM_STR);
          $stmt->bindParam('input_transfer_code', $transferCode, PDO::PARAM_STR);
          $stmt->bindParam('input_gross_price', $grossPrice, PDO::PARAM_INT);
          $stmt->bindParam('input_discount', $discount, PDO::PARAM_INT);
          $stmt->bindParam('input_net_price', $netPrice, PDO::PARAM_INT);
          $stmt->execute();
     }

     // update
     public function update(int $id, string $userName, string $transferCode, int $grossPrice, int $discount, int $netPrice): void
     {
          $db = $this->connect();

          $query = "UPDATE orders SET
                    user_name = :input_user_name,
                    transfer_code = :input_transfer_code,
                    gross_price = :input_gross_price,
                    discount = :input_discount,
                    net_price = :input_net_price
                    WHERE id = :input_id
          ";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_user_name', $userName, PDO::PARAM_STR);
          $stmt->bindParam('input_transfer_code', $transferCode, PDO::PARAM_STR);
          $stmt->bindParam('input_gross_price', $grossPrice, PDO::PARAM_INT);
          $stmt->bindParam('input_discount', $discount, PDO::PARAM_INT);
          $stmt->bindParam('input_net_price', $netPrice, PDO::PARAM_INT);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();
     }

     // delete
     public function delete(int $id): void
     {
          $db = $this->connect();

          $query = "DELETE FROM orders WHERE id = :input_id";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();
     }

     // get all orders
     public function getAll(): array
     {
          $db = $this->connect();

          $query = "SELECT * FROM orders";

          $stmt = $db->prepare($query);
          $stmt->execute();


          $response = $stmt->fetchAll();

          if (isset($response[0])) {
               return $response;
          }

          return [];
     }

     // get an order
     public function get(int $id): array
     {
          $db = $this->connect();

          $query = "SELECT * FROM orders WHERE id = :input_id";

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

          $query = "CREATE TABLE orders (
               id INTEGER PRIMARY KEY AUTOINCREMENT,
               user_name VARCHAR(40),
               transfer_code VARCHAR(100),
               gross_price INTEGER,
               discount INTEGER,
               net_price INTEGER
          )
          ";

          $db->query($query);
     }
}
