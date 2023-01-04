<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database.php');

class bookings extends database
{
     // create
     public function create(string $room, string $checkIn, string $checkOut, int $orderId): void
     {
          $db = $this->connect();

          $query = "INSERT INTO bookings
                    (
                         room,
                         check_in,
                         check_out,
                         order_id
                    )
                    VALUES
                    (
                         :input_room,
                         :input_check_in,
                         :input_check_out,
                         :input_order_id
                    )
          ";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_room', $room, PDO::PARAM_STR);
          $stmt->bindParam('input_check_in', $checkIn, PDO::PARAM_STR);
          $stmt->bindParam('input_check_out', $checkOut, PDO::PARAM_STR);
          $stmt->bindParam('input_order_id', $orderId, PDO::PARAM_INT);
          $stmt->execute();
     }

     // update
     public function update(int $id, string $room, string $checkIn, string $checkOut, int $orderId): void
     {
          $db = $this->connect();

          $query = "UPDATE bookings SET
                    room = :input_room,
                    check_in = :input_check_in,
                    check_out = :input_check_out,
                    order_id = :input_order_id
                    WHERE id = :input_id
          ";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_room', $room, PDO::PARAM_STR);
          $stmt->bindParam('input_check_in', $checkIn, PDO::PARAM_STR);
          $stmt->bindParam('input_check_out', $checkOut, PDO::PARAM_STR);
          $stmt->bindParam('input_order_id', $orderId, PDO::PARAM_INT);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();
     }

     // delete
     public function delete(int $id): void
     {
          $db = $this->connect();

          $query = "DELETE FROM bookings WHERE id = :input_id";

          $stmt = $db->prepare($query);
          $stmt->bindParam('input_id', $id, PDO::PARAM_INT);
          $stmt->execute();
     }
}
