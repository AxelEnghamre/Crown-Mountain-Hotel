<?php

declare(strict_types=1);

header('Content-type: application/json');

require_once(__DIR__ . '/../../src/classes/app.php');
require_once(__DIR__ . '/../../src/classes/database/bookings.php');
require_once(__DIR__ . '/../../src/classes/database/items.php');
require_once(__DIR__ . '/../../src/classes/database/orders.php');
require_once(__DIR__ . '/../../src/classes/database/ordersItems.php');


$app = new app;
$tableBookings = new bookings;
$tableItems = new items;
$tableOrders = new orders;
$tableOrdersItems = new ordersItems;

// check if form data exists
if (isset($_POST['checkIn'], $_POST['checkOut'], $_POST['transferCode'], $_POST['userName'], $_POST['room'], $_POST['items'])) {
     $checkIn = filter_var($_POST['checkIn'], FILTER_SANITIZE_SPECIAL_CHARS);
     $checkOut = filter_var($_POST['checkOut'], FILTER_SANITIZE_SPECIAL_CHARS);
     $transferCode = filter_var($_POST['transferCode'], FILTER_SANITIZE_SPECIAL_CHARS);
     $userName = filter_var($_POST['userName'], FILTER_SANITIZE_SPECIAL_CHARS);
     $room = filter_var($_POST['room'], FILTER_SANITIZE_SPECIAL_CHARS);
     $items = filter_var_array($_POST['items']);
     echo json_encode(['status' => 200]);
     exit;
} else {
     echo json_encode(['error' => 'missing data']);
     exit;
}

echo json_encode(['error' => 'server error']);
