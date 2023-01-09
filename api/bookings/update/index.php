<?php

declare(strict_types=1);

header('Content-type: application/json');


require_once(__DIR__ . '/../../../src/classes/app.php');
require_once(__DIR__ . '/../../../src/classes/database/bookings.php');

$app = new app;
$tableBookings = new bookings;

if ($app->getIsSignedIn()) {
     if (isset($_POST['bookingId'], $_POST['checkIn'], $_POST['checkOut'], $_POST['orderId'])) {
          if (filter_var($_POST['bookingId'], FILTER_VALIDATE_INT) && filter_var($_POST['orderId'], FILTER_VALIDATE_INT)) {
               $tableBookings->update(intval($_POST['bookingId']), $_POST['room'], $_POST['checkIn'], $_POST['checkOut'], intval($_POST['orderId']));
               header("Location: /admin/login");
               exit;
          } else {
               echo json_encode(['error' => 'input data']);
               exit;
          }
     }
     echo json_encode(['error' => 'missing data']);
     exit;
}

echo json_encode(['error' => 'not signed in']);
exit;
