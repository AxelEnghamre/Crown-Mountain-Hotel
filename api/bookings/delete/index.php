<?php

declare(strict_types=1);

header('Content-type: application/json');


require_once(__DIR__ . '/../../../src/classes/app.php');
require_once(__DIR__ . '/../../../src/classes/database/bookings.php');

$app = new app;
$tableBookings = new bookings;

if ($app->getIsSignedIn()) {
     if (isset($_POST['booking_id'])) {
          if (filter_var($_POST['booking_id'], FILTER_VALIDATE_INT)) {
               $tableBookings->delete(intval($_POST['booking_id']));
               header("Location: /admin/login");
               exit;
          } else {
               echo json_encode(['error' => 'input data must be int']);
               exit;
          }
     }
     echo json_encode(['error' => 'missing data']);
     exit;
}

echo json_encode(['error' => 'not signed in']);
exit;
