<?php

declare(strict_types=1);

require_once(__DIR__ . '/src/classes/app.php');

$app = new app;

// TESTS
require_once(__DIR__ . '/src/classes/database/bookings.php');
$bookings = new bookings;

//$bookings->create('low', '20230101', '20230103', 1);

//$bookings->update(1, 'mid', '20230101', '20230103', 1);


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

</body>

</html>
