<?php

declare(strict_types=1);

// vendor autoload
require_once(__DIR__ . '/../../vendor/autoload.php');

use Dotenv\Dotenv;

class app
{
     private array $errors;
     private bool $isSignedIn;
     private string $userName;
     private string $userAccess;


     function __construct()
     {
          // "Connect" to .env and load it's content into $_ENV
          $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
          $dotenv->load();

          // ensure session
          if (session_status() === PHP_SESSION_NONE) {
               session_start();
          }

          //  ensure user status
          $this->signIn();

          //  ensure errors
          $this->setErrors();
     }

     // sign in the user based on session
     private function signIn(): void
     {
          if (isset($_SESSION['isSignedIn'])) {
               if ($_SESSION['isSignedIn'] === true) {
                    $this->isSignedIn = true;
                    $this->userName = $_SESSION['userName'];
                    $this->userAccess = $_SESSION['userAccess'];
               }
          } else {
               $this->isSignedIn = false;
               $this->userName = "";
               $this->userAccess = "";
          }
     }

     // error handeling based on session
     private function setErrors(): void
     {
          if (isset($_SESSION['errors'])) {
               $this->errors = $_SESSION['errors'];
          } else {
               $this->errors = [];
          }

          // create or reset the session errors
          $_SESSION['errors'] = [];
     }


     // retrieve user data
     public function getIsSignedIn(): bool
     {
          return $this->isSignedIn;
     }
     public function getUserName(): string
     {
          return $this->userName;
     }
     public function getUserAccess(): string
     {
          return $this->userAccess;
     }

     // retrieve error data
     public function getErrors(): array
     {
          return $this->errors;
     }


     public function guidv4(string $data = null): string
     {
          // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
          $data = $data ?? random_bytes(16);
          assert(strlen($data) == 16);

          // Set version to 0100
          $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
          // Set bits 6-7 to 10
          $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

          // Output the 36 character UUID.
          return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
     }

     public function isValidUuid(string $uuid): bool
     {
          if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
               return false;
          }
          return true;
     }
}
