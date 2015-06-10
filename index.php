<?php require 'vendor/autoload.php';

use KBC\Accounts\Account;
use KBC\Accounts\AccountProjector;
use KBC\Accounts\Commands\DeleteAccount;
use KBC\Accounts\Commands\DepositMoney;
use KBC\Accounts\Commands\OpenAccount;
use KBC\Accounts\Commands\WithdrawMoney;
use KBC\Accounts\Events\AccountWasDeleted;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasWithdrawn;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\Listeners\WhenAccountWasDeleted;
use KBC\Accounts\Listeners\WhenAccountWasOpened;
use KBC\Accounts\Listeners\WhenMoneyHasBeenCollected;
use KBC\Accounts\Listeners\WhenMoneyWasDeposited;
use KBC\Accounts\Name;
use KBC\EventSourcing\Events\Dispatcher;
use KBC\EventSourcing\EventSourcingRepository;
use KBC\EventSourcing\EventStore;
use KBC\EventSourcing\EventStoreRepository;
use KBC\Storages\EventStorage;
use KBC\Storages\FileStorage;
use KBC\Storages\JsonDatabase;
use Rhumsaa\Uuid\Uuid;

error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set("Europe/Brussels");

// Some Databases
$projectionDatabase = 'database/accounts.db.json';
$eventStorageDatabase = 'database/.events';

/* ---- DO NOT DO THIS IN PRODUCTION ---- */
file_put_contents($eventStorageDatabase, '');
file_put_contents($projectionDatabase, ''); // json db
/* ---- DO NOT DO THIS IN PRODUCTION ---- */

// Doing some bindings
app()->bind(EventStorage::class, function () use ($eventStorageDatabase) {
    return new FileStorage($eventStorageDatabase);
});

app()->bind(EventSourcingRepository::class, function () {
   return app()->make(EventStoreRepository::class);
});

// Who doesn't like queues
$queue = new Queue('127.0.0.1', 'default');

app()->singleton(Dispatcher::class);

// Setup some stuff
$eventStore = app(EventStore::class);
$eventDispatcher = app(Dispatcher::class);

// Register some DomainEvent Listeners
$eventDispatcher->addListener(AccountWasOpened::class, new WhenAccountWasOpened());
$eventDispatcher->addListener(MoneyWasDeposited::class, new WhenMoneyWasDeposited());
$eventDispatcher->addListener(MoneyWasWithdrawn::class, new WhenMoneyHasBeenCollected());
$eventDispatcher->addListener(AccountWasDeleted::class, new WhenAccountWasDeleted());

// Register projectors
$eventDispatcher->addProjector(Account::class, new AccountProjector(new JsonDatabase($projectionDatabase)));

// Generate UUID
$johnDoeId = (String) Uuid::uuid4();
$janeDoeId = (String) Uuid::uuid4();

// Open Account
dispatch(new OpenAccount($johnDoeId, new Name('John', 'Doe')));
dispatch(new OpenAccount($janeDoeId, new Name('Jane', 'Doe')));

// Deposit some money
dispatch(new DepositMoney($johnDoeId, 20));
dispatch(new DepositMoney($johnDoeId, 10));
dispatch(new DepositMoney($johnDoeId, 30));

// Withdraw some money
dispatch(new WithdrawMoney($johnDoeId, 50));

// Delete account
dispatch(new DeleteAccount($janeDoeId));
