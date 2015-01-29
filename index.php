<?php require 'vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', 'On');

use KBC\Accounts\Account;
use KBC\Accounts\Name;
use KBC\EventSourcing\AggregateHistory;
use KBC\EventSourcing\EventStore;
use KBC\Storages\FileStorage;
use Rhumsaa\Uuid\Uuid;

/* -- DO NOT DO THIS -- */
file_put_contents('storage/events.txt', '');
/* -- DO NOT DO THIS -- */

// Setup some stuff
$eventStore = new EventStore(new FileStorage());

// Generate some UUIDs
$robinId = (String) Uuid::uuid4();
$sarahId = (String) Uuid::uuid4();

// Open some accounts
$robin = Account::open($robinId, new Name('Robin', 'Malfait'));
$sarah = Account::open($sarahId, new Name('Sarah', 'Dekeyzer'));

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

// Replay events that are stored.
$robinRestored = Account::replayEvents($eventStore->getEventsFor($robinId));
var_dump($robinRestored == $robin); // true

$sarahRestored = Account::replayEvents($eventStore->getEventsFor($sarahId));
var_dump($sarahRestored == $sarah); // true