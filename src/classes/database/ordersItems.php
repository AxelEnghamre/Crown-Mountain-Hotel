<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database.php');

class ordersItems extends database
{
     // create
     public function create(int $orderId, int $itemId): void
     {
          $db = $this->connect();

          $query = "INSERT INTO orders_items
                    (
                         order_id,
                         item_id
                    )
                    VALUES
                    (
                         :input_order_id,
                         :input_item_id
                    )
          ";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_order_id', $orderId, PDO::PARAM_INT);
          $stmt->bindParam('input_item_id', $itemId, PDO::PARAM_INT);
          $stmt->execute();
     }

     // update
     public function update(int $id, int $orderId, int $itemId): void
     {
          $db = $this->connect();

          $query = "UPDATE orders_items SET
                    order_id = :input_order_id,
                    item_id = :input_item_id
                    WHERE id = :input_id
          ";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_order_id', $orderId, PDO::PARAM_INT);
          $stmt->bindParam('input_item_id', $itemId, PDO::PARAM_INT);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();
     }

     // delete
     public function delete(int $id): void
     {
          $db = $this->connect();

          $query = "DELETE FROM orders_items WHERE id = :input_id";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();
     }

     // get all items
     public function getAll(): array
     {
          $db = $this->connect();

          $query = "SELECT * FROM orders_items";

          $stmt = $db->prepare($query);
          $stmt->execute();


          $response = $stmt->fetchAll();

          if (isset($response[0])) {
               return $response;
          }

          return [];
     }

     public function allInOrder(int $orderId): array
     {
          $db = $this->connect();

          $query = "SELECT * FROM orders_items WHERE order_id = :input_order_id";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_order_id', $orderId, PDO::PARAM_INT);
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

          $query = "SELECT * FROM orders_items WHERE id = :input_id";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();


          $response = $stmt->fetch();

          if (isset($response['id'])) {
               return $response;
          }

          return [];
     }
}
