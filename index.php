<?php

declare(strict_types=1);

require_once(__DIR__ . '/src/classes/app.php');

$app = new app;


?>


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= $_ENV['HOTEL_NAME'] ?></title>
</head>

<body>
     <form action="/api/bookings/" method="post">
          <input type="text" name="userName" id="userName">
          <input type="text" name="transferCode" id="transferCode">
          <input type="date" name="checkIn" id="checkIn" min="2023-01-01" max="2023-01-31">
          <input type="date" name="checkOut" id="checkOut" min="2023-01-01" max="2023-01-31">
          <select name="room" id="room">
               <option value="buget">buget <?= $_ENV['BUGET_ROOM_PRICE'] ?>$</option>
               <option value="standard">standard <?= $_ENV['STANDARD_ROOM_PRICE'] ?>$</option>
               <option value="luxury">luxury <?= $_ENV['LUXURY_ROOM_PRICE'] ?>$</option>
          </select>
          <input type="hidden" name="items[]">
          <input type="submit" value="Make a reservation">
     </form>
</body>

</html>
