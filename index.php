<?php require 'vendor/autoload.php';

use KBC\Accounts\Account;
use KBC\Accounts\AccountProjector;
use KBC\Accounts\Commands\CloseAccount;
use KBC\Accounts\Commands\DepositMoney;
use KBC\Accounts\Commands\OpenAccount;
use KBC\Accounts\Commands\WithdrawMoney;
use KBC\Accounts\Events\AccountWasClosed;
use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyWasWithdrawn;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Accounts\Listeners\WhenAccountWasClosed;
use KBC\Accounts\Listeners\WhenAccountWasOpened;
use KBC\Accounts\Listeners\WhenMoneyHasBeenCollected;
use KBC\Accounts\Listeners\WhenMoneyWasDeposited;
use KBC\Accounts\VO\AccountId;
use KBC\Accounts\VO\Amount;
use KBC\Accounts\VO\Name;
use KBC\Baskets\Basket;
use KBC\Baskets\BasketProjector;
use KBC\Baskets\Commands\AddProduct;
use KBC\Baskets\Commands\PickUpBasket;
use KBC\Baskets\Commands\RemoveItem;
use KBC\Baskets\Events\BasketWasCreated;
use KBC\Baskets\Listeners\WhenBasketWasCreated;
use KBC\Baskets\VO\BasketId;
use KBC\Baskets\VO\Product;
use KBC\Baskets\VO\ProductId;
use KBC\EventSourcing\Events\Dispatcher;
use KBC\EventSourcing\EventSourcingRepository;
use KBC\EventSourcing\EventStore;
use KBC\EventSourcing\EventStoreRepository;
use KBC\Storages\EventStorage;
use KBC\Storages\FileStorage;
use KBC\Storages\JsonDatabase;

error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set("Europe/Brussels");

// Some 'Databases'
$eventStorageDatabase = 'database/.events';
$accountsDatabase = 'database/accounts.db.json';
$basketsDatabase = 'database/baskets.db.json';

/* ---- DO NOT DO THIS IN PRODUCTION ---- */
setupDatabase($eventStorageDatabase);
setupDatabase($accountsDatabase);
setupDatabase($basketsDatabase);
/* ---- DO NOT DO THIS IN PRODUCTION ---- */

// Doing some bindings
app()->bind(EventStorage::class, function () use ($eventStorageDatabase) {
    return new FileStorage($eventStorageDatabase);
});

app()->bind(EventSourcingRepository::class, function () {
    return app()->make(EventStoreRepository::class);
});

app()->singleton(Dispatcher::class);

// Setup some stuff
$eventStore = app(EventStore::class);
$eventDispatcher = app(Dispatcher::class);

// Register some DomainEvent Listeners
$eventDispatcher->addListener(AccountWasOpened::class, new WhenAccountWasOpened());
$eventDispatcher->addListener(MoneyWasDeposited::class, new WhenMoneyWasDeposited());
$eventDispatcher->addListener(MoneyWasWithdrawn::class, new WhenMoneyHasBeenCollected());
$eventDispatcher->addListener(AccountWasClosed::class, new WhenAccountWasClosed());
$eventDispatcher->addListener(BasketWasCreated::class, new WhenBasketWasCreated());

// Register projectors
$eventDispatcher->addProjector(Account::class, new AccountProjector(new JsonDatabase($accountsDatabase)));
$eventDispatcher->addProjector(Basket::class, new BasketProjector(new JsonDatabase($basketsDatabase)));

/**
 * Accounts
 */
// Generate UUID
$johnDoe = AccountId::fromString(id());
$janeDoe = AccountId::fromString(id());

// Open Account
dispatch(new OpenAccount($johnDoe, new Name('John', 'Doe')));
dispatch(new OpenAccount($janeDoe, new Name('Jane', 'Doe')));

// Deposit some money
dispatch(new DepositMoney($johnDoe, new Amount(20)));
dispatch(new DepositMoney($johnDoe, new Amount(10)));
dispatch(new DepositMoney($johnDoe, new Amount(30)));

// Withdraw some money
dispatch(new WithdrawMoney($johnDoe, new Amount(50)));

// Delete account
dispatch(new CloseAccount($janeDoe));

/**
 * Baskets
 */
$basket = BasketId::fromString(id());

// Pick up a basket
dispatch(new PickUpBasket($basket));

// Generate some product ids
$macbook = ProductId::fromString(id());
$iphone = ProductId::fromString(id());
$ipad = ProductId::fromString(id());

// Add some items
dispatch(new AddProduct($basket, new Product($macbook, 'Macbook Pro')));
dispatch(new AddProduct($basket, new Product($iphone, 'iPhone 6')));
dispatch(new AddProduct($basket, new Product($ipad, 'iPad Air')));

// Removing an item
dispatch(new RemoveItem($basket, $macbook));
