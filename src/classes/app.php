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
     private int $userId;


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
                    $this->userId = $_SESSION['userId'];
               }
          } else {
               $this->isSignedIn = false;
               $this->userName = "";
               $this->userAccess = "";
               $this->userId = 0;
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
     public function getUserId(): int
     {
          return $this->userId;
     }

     // retrieve error data
     public function getErrors(): array
     {
          return $this->errors;
     }
}
