<?php

declare(strict_types=1);

header('Content-type: application/json');

require_once(__DIR__ . '/../../../src/classes/app.php');

$app = new app;

if (isset($_POST['user'], $_POST['api_key'])) {
     $user = filter_var($_POST['user'], FILTER_SANITIZE_SPECIAL_CHARS);
     $apiKey = filter_var($_POST['api_key'], FILTER_SANITIZE_SPECIAL_CHARS);

     if ($user === $_ENV['USER_NAME'] && $apiKey === $_ENV['API_KEY']) {
          $_SESSION['isSignedIn'] = true;
          $_SESSION['userName'] = $user;
          $_SESSION['userAccess'] = 'admin';

          header("Location: /admin/login");
          exit;
     } else {
          echo json_encode(['error' => 'user and api key does not match']);
          exit;
     }
} else {
     echo json_encode(['error' => 'missing data']);
     exit;
}

echo json_encode(['error' => 'server error']);
exit;
