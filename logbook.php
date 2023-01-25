<?php
require_once(__DIR__ . '/src/classes/app.php');
require_once(__DIR__ . '/src/classes/database.php');

$logbookData = file_get_contents(__DIR__ . '/logbook.json');
$logbookData = json_decode($logbookData, true);
$logbookData = $logbookData['vacation'];

$featureNames = array('breakfust', 'minibar', 'guided tour');
$featureCount = array(0, 0, 0);

$db = new database();
try {
    $ordersData = $db->fetch("orders");
    $bookingsData = $db->fetch("bookings");
    $orderItemsData = $db->fetch("orders_items");
} catch (Exception $e) {
    echo $e->getMessage();
}

$totalCost = 0;
$totalIncome = 0;

//Fetch total cost for display
foreach ($logbookData as $logbookEntry) {
    $totalCost += (float)$logbookEntry['total_cost'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/logbook.css">

    <title>Logbook</title>
</head>

<body>
    <header>
        <section class="fact-box-container">
            <h1>Fact box</h1>
            <section class="hotel-revenue-container">
                <h3>Hotel bookings</h3>
                <section class="hotel-revenue-card-container">
                    <!--
                        This loop creates a card for every booking in the database. For each booking it displays the name, feature and cost of that booking
                    -->
                    <?php foreach ($ordersData as $orderData) : ?>
                        <?php $totalIncome += $orderData['net_price'] ?>
                        <div>
                            <!--Name-->
                            <h3>User: <?= $orderData['user_name'] ?></h3>
                            <h3>Features:
                                <!--Feature/Features-->
                                <?php foreach ($orderItemsData as $orderItem) : ?>
                                    <?php
                                    if ($orderItem['order_id'] === $orderData['id']) {
                                        echo $featureNames[$orderItem['item_id'] - 1] . " ";
                                    }
                                    $featureCount[$orderItem['item_id'] - 1]++;
                                    ?>
                                <?php endforeach ?>
                            </h3>
                            <!--cost-->
                            <h3>Cost: $<?= $orderData['net_price'] ?></h3>
                        </div>
                    <?php endforeach ?>
                </section>
                <section class="hotel-fact-container">
                    <h3>Most used feature:
                        <?php $mostUsedFeature = array_search(max($featureCount), $featureCount);
                        echo $featureNames[$mostUsedFeature]
                        ?>
                    </h3>
                    <h3>Income: $<?= $totalIncome ?></h3>
                </section>
            </section>

        </section>
        <div>
            <h2>Logbook summary</h2>
        </div>
        <!--Display for total cost-->
        <h3>Total cost: $<?= $totalCost ?></h3>
    </header>
    <div class="logbook-container">
        <!--Loops the logbook entries, for each log-entry this extracts and displays the information -->
        <?php foreach ($logbookData as $logbookEntry) : ?>
            <section class="logbook-card">
                <h3><?= $logbookEntry['hotel'] ?></h3>
                <i><?= $logbookEntry['island'] ?></i>
                <h3>Stars</h3>
                <p>
                    <?php for ($i = 0; $i < (int)$logbookEntry['stars']; $i++) : ?>
                        <?= '*' ?>
                    <?php endfor ?>
                </p>
                <p>Arrival: <?= $logbookEntry['arrival_date'] ?></p>
                <p>Departure: <?= $logbookEntry['departure_date'] ?></p>
                <h3>Features</h3>
                <div>
                    <ul>
                        <?php foreach ($logbookEntry['features'] as $feature) : ?>
                            <li><?= $feature['name'] ?></li>
                        <?php endforeach ?>
                    </ul>

                    <?php if ($logbookEntry['features'] == null) {
                        echo "No features selected";
                    } ?>
                </div>
                <h3>Hotel message</h3>
                <article>
                    <?php if (is_array($logbookEntry['additional_info'][0])) : ?>
                        <?php foreach ($logbookEntry['additional_info'][0] as $info) : ?>
                            <q><?= $info ?></q>
                            <br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <q><?= $logbookEntry['additional_info'] ?></q>
                    <?php endif ?>
                </article>
                <h3>Cost</h3>
                <p>$<?= $logbookEntry['total_cost'] ?></p>
            </section>
        <?php endforeach ?>
    </div>
</body>

</html>