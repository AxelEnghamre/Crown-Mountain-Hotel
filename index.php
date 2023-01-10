<?php

declare(strict_types=1);

require_once(__DIR__ . '/src/classes/app.php');
require_once(__DIR__ . '/src/classes/database/items.php');
require_once(__DIR__ . '/src/classes/database/bookings.php');
require_once(__DIR__ . '/src/components/transferCodeForm.php');

$app = new app;
$tableItems = new items;
$tableBookings = new bookings;

use benhall14\phpCalendar\Calendar as Calendar;

// buget calendar
$bugetBookings = $tableBookings->allRoomBookings('buget');

$bugetCalendar = new Calendar;
$bugetCalendar->stylesheet();
$bugetCalendar->useMondayStartingDate();
if ($bugetBookings != false) {
     foreach ($bugetBookings as $booking) {
          $bugetCalendar->addEvent(
               $booking['check_in'],
               $booking['check_out'],
               '',
               true
          );
     }
}

// standard calendar
$standardBookings = $tableBookings->allRoomBookings('standard');

$standardCalendar = new Calendar;
$standardCalendar->stylesheet();
$standardCalendar->useMondayStartingDate();
if ($standardBookings != false) {
     foreach ($standardBookings as $booking) {
          $standardCalendar->addEvent(
               $booking['check_in'],
               $booking['check_out'],
               '',
               true
          );
     }
}

// luxury calendar
$luxuryBookings = $tableBookings->allRoomBookings('luxury');

$luxuryCalendar = new Calendar;
$luxuryCalendar->stylesheet();
$luxuryCalendar->useMondayStartingDate();
if ($luxuryBookings != false) {
     foreach ($luxuryBookings as $booking) {
          $luxuryCalendar->addEvent(
               $booking['check_in'],
               $booking['check_out'],
               '',
               true
          );
     }
}


$items = $tableItems->getAll();
?>


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= $_ENV['HOTEL_NAME'] ?></title>
     <link rel="stylesheet" href="style/main.css">
</head>

<body>
     <header>
          <h1><?= $_ENV['HOTEL_NAME'] ?></h1>
          <p>The exclusive hotel located on the island of <?= $_ENV['ISLAND_NAME'] ?></p>
     </header>
     <main>
          <section>
               <article>
                    <h2>buget</h2>
               </article>
               <?= $bugetCalendar->draw('2023-01-01', 'grey') ?>
          </section>
          <section>
               <article>
                    <h2>standard</h2>
               </article>
               <?= $standardCalendar->draw('2023-01-01', 'grey') ?>
          </section>
          <section>
               <article>
                    <h2>luxury</h2>
               </article>
               <?= $luxuryCalendar->draw('2023-01-01', 'grey') ?>
          </section>
          <?php
          transferCodeForm($items);
          ?>
     </main>
</body>

</html>
