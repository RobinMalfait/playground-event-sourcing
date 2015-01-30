<?php require 'vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', 'On');

use KBC\Accounts\Account;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\Events\TransactionHasBeenMade;
use KBC\Accounts\Listeners\whenAccountWasOpened;
use KBC\Accounts\Listeners\whenMoneyHasBeenCollected;
use KBC\Accounts\Listeners\whenMoneyWasDeposited;
use KBC\Accounts\Listeners\whenTransactionHasBeenMade;
use KBC\Accounts\Name;
use KBC\EventSourcing\AggregateHistory;
use KBC\EventSourcing\Events\Dispatcher;
use KBC\EventSourcing\EventStore;
use KBC\Storages\FileStorage;
use Rhumsaa\Uuid\Uuid;

/* ---- DO NOT DO THIS IN PRODUCTION ---- */
file_put_contents($storageFile = '.events', '');
/* ---- DO NOT DO THIS IN PRODUCTION ---- */

// Setup some stuff
$eventStore = new EventStore(new FileStorage($storageFile), $dispatcher = new Dispatcher());

// Register some DomainEvent Listeners
$dispatcher->addListener(AccountWasOpened::class, new whenAccountWasOpened());
$dispatcher->addListener(MoneyWasDeposited::class, new whenMoneyWasDeposited());

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
$robin->withdraw(100);

// Save the account events
$eventStore->save($robin);
$eventStore->save($sarah);

// Replay events that are stored.
$robinRestored = Account::replayEvents($eventStore->getEventsFor($robinId));
$sarahRestored = Account::replayEvents($eventStore->getEventsFor($sarahId));

// Maybe some testing #TestFrameworkInATweet
it('should restore the object in the exact same state', $robinRestored == $robin);
it('should restore the object in the exact same state', $sarahRestored == $sarah);
