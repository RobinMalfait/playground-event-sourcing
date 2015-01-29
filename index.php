<?php require 'vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', 'On');

use KBC\Accounts\Account;
use KBC\Accounts\ValueObjects\Name;
use KBC\EventSourcing\EventStore;
use KBC\Storages\FileStorage;

/* -- DO NOT DO THIS -- */
file_put_contents('storage/events.txt', '');
/* -- DO NOT DO THIS -- */

// Setup some stuff
$eventStore = new EventStore(new FileStorage());

// Open some accounts
$robin = Account::open(new Name('Robin', 'Malfait'));
$sarah = Account::open(new Name('Sarah', 'Dekeyzer'));

// Deposit some money
$robin->deposit(200);
$sarah->deposit(400);
$robin->deposit(100);

// Withdraw some money
$sarah->withdraw(20);
$robin->withdraw(30);

// Save the accounts
$eventStore->save($robin);
$eventStore->save($sarah);

$eventStore->replayAll();