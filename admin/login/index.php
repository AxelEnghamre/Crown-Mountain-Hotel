<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../src/classes/app.php');

$app = new app;

if ($app->getIsSignedIn()) {
     header("Location: /admin/");
     exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>login</title>
</head>

<body>
     <form action="../../api/admin/login/" method="post">
          <input type="text" name="user" id="user">
          <input type="text" name="api_key" id="api_key">
          <input type="submit" value="login">
     </form>
</body>

</html>
