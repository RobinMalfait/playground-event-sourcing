<?php require 'vendor/autoload.php';

use KBC\Accounts\Account;
use KBC\Accounts\AccountProjector;
use KBC\Accounts\Events\AccountWasDeleted;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyHasBeenCollected;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\Listeners\WhenAccountWasDeleted;
use KBC\Accounts\Listeners\WhenAccountWasOpened;
use KBC\Accounts\Listeners\WhenMoneyHasBeenCollected;
use KBC\Accounts\Listeners\WhenMoneyWasDeposited;
use KBC\Accounts\Name;
use KBC\EventSourcing\Events\Dispatcher;
use KBC\EventSourcing\EventStore;
use KBC\Storages\FileStorage;
use KBC\Storages\JsonDatabase;
use Rhumsaa\Uuid\Uuid;

error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set("Europe/Brussels");

// Some Databases
$projectionDatabase = 'accounts.db.json';
$eventStorageDatabase = '.events';

/* ---- DO NOT DO THIS IN PRODUCTION ---- */
file_put_contents($eventStorageDatabase, '');
file_put_contents($projectionDatabase, ''); // json db
/* ---- DO NOT DO THIS IN PRODUCTION ---- */

// Who doesn't like queues
$queue = new Queue('127.0.0.1', 'default');

// Setup some stuff
$eventStore = new EventStore(new FileStorage($eventStorageDatabase), $dispatcher = new Dispatcher());

// Register some DomainEvent Listeners
$dispatcher->addListener(AccountWasOpened::class, new WhenAccountWasOpened());
$dispatcher->addListener(MoneyWasDeposited::class, new WhenMoneyWasDeposited());
$dispatcher->addListener(MoneyHasBeenCollected::class, new WhenMoneyHasBeenCollected());
$dispatcher->addListener(AccountWasDeleted::class, new WhenAccountWasDeleted());

// Register projectors
$dispatcher->addProjector(Account::class, new AccountProjector(new JsonDatabase($projectionDatabase)));

// Generate UUID
$johnDoeId = (String) Uuid::uuid4();
$janeDoeId = (String) Uuid::uuid4();

// Open Account
$johnDoe = Account::open($johnDoeId, new Name('John', 'Doe'));
it('should be the exact same id', $johnDoe->id ==  $johnDoeId);

$janeDoe = Account::open($janeDoeId, new Name('Jane', 'Doe'));

// Deposit some money
$johnDoe->deposit(20);
$johnDoe->deposit(10);
$johnDoe->deposit(30);

// Withdraw some money
$johnDoe->withdraw(50);

// Delete account
$janeDoe->delete();

// Save the account events
$eventStore->save($johnDoe);
$eventStore->save($janeDoe);

// Replay events that are stored.
$johnDoeRestored = Account::replayEvents($eventStore->getEventsFor($johnDoeId));

// Maybe some testing #TestFrameworkInATweet
it('should restore the object in the exact same state', $johnDoeRestored == $johnDoe);