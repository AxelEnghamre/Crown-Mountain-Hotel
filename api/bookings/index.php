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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

$client = new Client();

// $tableBookings->setup();
// $tableItems->setup();
// $tableOrders->setup();
// $tableOrdersItems->setup();

// check if form data exists
if (isset($_POST['checkIn'], $_POST['checkOut'], $_POST['transferCode'], $_POST['userName'], $_POST['room'])) {
     $checkIn = filter_var($_POST['checkIn'], FILTER_SANITIZE_SPECIAL_CHARS);
     $checkOut = filter_var($_POST['checkOut'], FILTER_SANITIZE_SPECIAL_CHARS);
     $transferCode = filter_var($_POST['transferCode'], FILTER_SANITIZE_SPECIAL_CHARS);
     $userName = filter_var($_POST['userName'], FILTER_SANITIZE_SPECIAL_CHARS);
     $room = filter_var($_POST['room'], FILTER_SANITIZE_SPECIAL_CHARS);
     // check if items is selected
     if (isset($_POST['items'])) {
          $items = filter_var_array($_POST['items']);
     } else {
          $items = false;
     }

     // ensure date data
     if (empty($checkIn) || empty($checkOut)) {
          echo json_encode(['error' => 'dates need to be set']);
          exit;
     }

     // create datetime objects for the booking
     $checkInDateTime = new DateTime($checkIn);
     $checkOutDateTime = new DateTime($checkOut);

     // compare dates chronologically
     if ($checkInDateTime > $checkOutDateTime) {
          echo json_encode(['error' => 'departure date can not be before arrival date']);
          exit;
     }

     // check if the room exists and set the room price
     switch ($room) {
          case 'buget':
               $roomPrice = $_ENV['BUGET_ROOM_PRICE'];
               break;
          case 'standard':
               $roomPrice = $_ENV['STANDARD_ROOM_PRICE'];
               break;
          case 'luxury':
               $roomPrice = $_ENV['LUXURY_ROOM_PRICE'];
               break;
          default:
               echo json_encode(['error' => 'found no room']);
               exit;
     }

     // check if the booking can be done
     $allRoomBookings = $tableBookings->allRoomBookings($room);

     // check for bookings
     if ($allRoomBookings != false) {
          foreach ($allRoomBookings as $bookedRoom) {
               // get the booked dates
               $bookedRoomCheckIn = $bookedRoom['check_in'];
               $bookedRoomCheckOut = $bookedRoom['check_out'];

               // make the booked dates to datetime objects
               $bookedRoomCheckIn = new DateTime($bookedRoomCheckIn);
               $bookedRoomCheckOut = new DateTime($bookedRoomCheckOut);



               // loop all the dates on the booked room
               for ($date = clone $bookedRoomCheckIn; $date <=  $bookedRoomCheckOut; $date->modify('+1 day')) {
                    for ($checkDate = clone $checkInDateTime; $checkDate <= $checkOutDateTime; $checkDate->modify('+1 day')) {
                         // check if the dates correlates
                         if ($date == $checkDate) {
                              echo json_encode(['error' => 'selected date is booked']);
                              exit;
                         }
                    }
               }
          }
     }

     // count the amount of days to book
     $amountOfDays = 0;
     for ($date = clone $checkInDateTime; $date <= $checkOutDateTime; $date->modify('+1 day')) {
          $amountOfDays++;
     }

     // initiate gross price with the amount of days in a room
     $grossPrice = $amountOfDays * $roomPrice;

     $itemsPrice = 0;
     $amountOfItems = 0;
     $features = [];
     // if there are items
     if (is_array($items)) {
          $amountOfItems = count($items);
          foreach ($items as $item) {
               $itemId = intval($item);

               $storedItem = $tableItems->get($itemId);

               if ($storedItem === false) {
                    echo json_encode(['error' => 'one of the items does no exist']);
                    exit;
               }

               array_push($features, [
                    'feature' => $storedItem['name'],
                    'cost' => $storedItem['price']
               ]);

               $itemsPrice += $storedItem['price'];
          }
     }

     // add items price to gross price
     $grossPrice += $itemsPrice;

     // discount
     $discount = $amountOfItems;

     // net price
     $netPrice = $grossPrice - $discount;


     try {
          $response = $client->request('POST', 'https://www.yrgopelago.se/centralbank/transferCode', [
               'form_params' => [
                    'transferCode' => $transferCode,
                    'totalCost' => $netPrice
               ],
          ]);
     } catch (ClientException $e) {
          echo json_encode(['error' => 'server error']);
          exit;
     }

     $canPay = false;
     if ($response->getBody()) {
          $data = json_decode($response->getBody()->getContents());

          if (!property_exists($data, 'error')) {
               if ($data->amount == $netPrice) {
                    $canPay = true;
               } else {
                    echo json_encode(['error' => 'not rigth amount of money on the transfer code']);
                    exit;
               }
          } else {
               echo json_encode(['error' => $data->error]);
               exit;
          }
     } else {
          echo json_encode(['error' => 'could not verlify transfer code']);
          exit;
     }

     if ($canPay) {
          try {
               $response = $client->request('POST', 'https://www.yrgopelago.se/centralbank/deposit', [
                    'form_params' => [
                         'user' => $_ENV['USER_NAME'],
                         'transferCode' => $transferCode
                    ],
               ]);
          } catch (ClientException $e) {
               echo json_encode(['error' => 'server error']);
               exit;
          }
     }

     // add the order
     $orderId = $tableOrders->create($userName, $transferCode, $grossPrice, $discount, $netPrice);

     // book the room
     $tableBookings->create($room, $checkIn, $checkOut, $orderId);

     // add the items
     if (is_array($items)) {
          foreach ($items as $item) {
               $itemId = intval($item);

               $tableOrdersItems->create($orderId, $itemId);
          }
     }



     echo json_encode([
          'island' => $_ENV['ISLAND_NAME'],
          'hotel' => $_ENV['HOTEL_NAME'],
          'arrival_date' => $checkIn,
          'departure_date' => $checkOut,
          'total_cost' => $netPrice,
          'stars' => $_ENV['STARS'],
          'features' => $features,
          'additional_info' => "Thank you for staying at $_ENV[HOTEL_NAME]"
     ]);
     exit;
} else {
     echo json_encode(['error' => 'missing data']);
     exit;
}

echo json_encode(['error' => 'server error']);
