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
$tableBookings = new bookings;
$tableOrders = new orders;

$bugetBooking = $tableBookings->allRoomBookings('buget');
$standardBooking = $tableBookings->allRoomBookings('standard');
$luxuryBooking = $tableBookings->allRoomBookings('luxury');

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

     <?php
     if ($bugetBooking) {
          foreach ($bugetBooking as $booking) {
               $order = $tableOrders->get($booking['order_id']);
     ?>
               <li>
                    <h3><?= $order['user_name'] ?></h3>
                    <form action="" method="post">
                         <input type="date" name="checkIn" id="checkIn" value=<?= $booking['check_in'] ?>>
                         <input type="date" name="checkOut" id="checkOut" value=<?= $booking['check_out'] ?>>
                         <input type="submit" value="update">
                    </form>

                    <form action="/api/bookings/delete" method="post">
                         <input type="hidden" name="booking_id" value=<?= $booking['id'] ?>>
                         <input type="submit" value="delete">
                    </form>
               </li>
     <?php
          }
     } else {
          echo "No buget bookings";
     }
     ?>
</body>

</html>
