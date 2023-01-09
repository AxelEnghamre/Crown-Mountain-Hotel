<?php

declare(strict_types=1);

require_once(__DIR__ . '/../src/classes/app.php');

$app = new app;

if (!$app->getIsSignedIn()) {
     header("Location: /admin/login");
     exit;
}


require_once(__DIR__ . '/../src/classes/database/bookings.php');
require_once(__DIR__ . '/../src/classes/database/orders.php');
require_once(__DIR__ . '/../src/classes/database/ordersItems.php');
require_once(__DIR__ . '/../src/classes/database/items.php');
$tableBookings = new bookings;
$tableOrders = new orders;
$tableOrdersItems = new ordersItems;
$tableItems = new items;

$bugetBooking = $tableBookings->allRoomBookings('buget');
$standardBooking = $tableBookings->allRoomBookings('standard');
$luxuryBooking = $tableBookings->allRoomBookings('luxury');
$allOrders = $tableOrders->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <base href="../">
     <title>admin page</title>
</head>

<body>
     <a href="/api/admin/logout/">logout</a>

     <h2>buget bookings</h2>
     <ul>
          <?php
          if ($bugetBooking) {
               foreach ($bugetBooking as $booking) {
                    $order = $tableOrders->get($booking['order_id']);
          ?>
                    <li>
                         <h3><?= $order['user_name'] ?></h3>
                         <form action="/api/bookings/update" method="post">
                              <input type="hidden" name="bookingId" value=<?= $booking['id'] ?>>
                              <input type="hidden" name="room" value=<?= $booking['room'] ?>>
                              <input type="date" name="checkIn" id="checkIn" value=<?= $booking['check_in'] ?>>
                              <input type="date" name="checkOut" id="checkOut" value=<?= $booking['check_out'] ?>>
                              <input type="number" name="orderId" id="orderId" value=<?= $booking['order_id'] ?>>
                              <input type="submit" value="update">
                         </form>

                         <form action="/api/bookings/delete" method="post">
                              <input type="hidden" name="bookingId" value=<?= $booking['id'] ?>>
                              <input type="submit" value="delete">
                         </form>
                    </li>
          <?php
               }
          } else {
               echo "No buget bookings";
          }
          ?>
     </ul>

     <h2>standard bookings</h2>
     <ul>
          <?php
          if ($standardBooking) {
               foreach ($standardBooking as $booking) {
                    $order = $tableOrders->get($booking['order_id']);
          ?>
                    <li>
                         <h3><?= $order['user_name'] ?></h3>
                         <form action="/api/bookings/update" method="post">
                              <input type="hidden" name="bookingId" value=<?= $booking['id'] ?>>
                              <input type="hidden" name="room" value=<?= $booking['room'] ?>>
                              <input type="date" name="checkIn" id="checkIn" value=<?= $booking['check_in'] ?>>
                              <input type="date" name="checkOut" id="checkOut" value=<?= $booking['check_out'] ?>>
                              <input type="number" name="orderId" id="orderId" value=<?= $booking['order_id'] ?>>
                              <input type="submit" value="update">
                         </form>

                         <form action="/api/bookings/delete" method="post">
                              <input type="hidden" name="bookingId" value=<?= $booking['id'] ?>>
                              <input type="submit" value="delete">
                         </form>
                    </li>
          <?php
               }
          } else {
               echo "No standard bookings";
          }
          ?>
     </ul>

     <h2>luxury bookings</h2>
     <ul>
          <?php
          if ($luxuryBooking) {
               foreach ($luxuryBooking as $booking) {
                    $order = $tableOrders->get($booking['order_id']);
          ?>
                    <li>
                         <h3><?= $order['user_name'] ?></h3>
                         <form action="/api/bookings/update" method="post">
                              <input type="hidden" name="bookingId" value=<?= $booking['id'] ?>>
                              <input type="hidden" name="room" value=<?= $booking['room'] ?>>
                              <input type="date" name="checkIn" id="checkIn" value=<?= $booking['check_in'] ?>>
                              <input type="date" name="checkOut" id="checkOut" value=<?= $booking['check_out'] ?>>
                              <input type="number" name="orderId" id="orderId" value=<?= $booking['order_id'] ?>>
                              <input type="submit" value="update">
                         </form>

                         <form action="/api/bookings/delete" method="post">
                              <input type="hidden" name="bookingId" value=<?= $booking['id'] ?>>
                              <input type="submit" value="delete">
                         </form>
                    </li>
          <?php
               }
          } else {
               echo "No luxury bookings";
          }
          ?>
     </ul>

     <h2>orders</h2>
     <ul>
          <?php
          if ($allOrders)
               foreach ($allOrders as $order) {
                    $orderItems = $tableOrdersItems->allInOrder(intval($order['id']));
          ?>
               <li>
                    <h3><?= $order['id'] ?></h3>
                    <form action="/api/orders/update" method="post">
                         <input type="text" name="userName" id="userName" value=<?= $order['user_name'] ?>>
                         <input type="text" name="transferCode" id="transferCode" value=<?= $order['transfer_code'] ?>>
                         <input type="number" name="grossPrice" id="grossPrice" value=<?= $order['gross_price'] ?>>
                         <input type="number" name="discount" id="discount" value=<?= $order['discount'] ?>>
                         <input type="number" name="netPrice" id="netPrice" value=<?= $order['net_price'] ?>>
                         <input type="submit" value="update">
                    </form>

                    <?php
                    if ($orderItems)
                         foreach ($orderItems as $orderItem) {
                              $item = $tableItems->get($orderItem['item_id']);
                              echo "$item[name] $item[price]$<br>";
                         }

                    ?>

                    <form action="" method="post">
                         <input type="hidden" name="orderId">
                         <input type="submit" value="delete">
                    </form>
               </li>
          <?php
               }
          ?>
     </ul>
</body>

</html>
