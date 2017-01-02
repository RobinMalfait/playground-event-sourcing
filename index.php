<?php require 'vendor/autoload.php';

use Acme\Accounts\Account;
use Acme\Accounts\AccountProjector;
use Acme\Accounts\Commands\CloseAccount;
use Acme\Accounts\Commands\DepositMoney;
use Acme\Accounts\Commands\OpenAccount;
use Acme\Accounts\Commands\WithdrawMoney;
use Acme\Accounts\Events\AccountWasClosed;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\Events\MoneyWasWithdrawn;
use Acme\Accounts\Events\MoneyWasDeposited;
use Acme\Accounts\Listeners\WhenAccountWasClosed;
use Acme\Accounts\Listeners\WhenAccountWasOpened;
use Acme\Accounts\Listeners\WhenMoneyHasBeenCollected;
use Acme\Accounts\Listeners\WhenMoneyWasDeposited;
use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\Accounts\VO\Name;
use Acme\Baskets\Basket;
use Acme\Baskets\BasketProjector;
use Acme\Baskets\Commands\AddProduct;
use Acme\Baskets\Commands\PickUpBasket;
use Acme\Baskets\Commands\RemoveItem;
use Acme\Baskets\Events\BasketWasCreated;
use Acme\Baskets\Listeners\WhenBasketWasCreated;
use Acme\Baskets\VO\BasketId;
use Acme\Baskets\VO\Product;
use Acme\Baskets\VO\ProductId;
use Acme\EventSourcing\Events\Dispatcher;
use Acme\EventSourcing\EventSourcingRepository;
use Acme\EventSourcing\EventStore;
use Acme\EventSourcing\EventStoreRepository;
use Acme\Storages\EventStorage;
use Acme\Storages\FileStorage;
use Acme\Storages\JsonDatabase;

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
dispatch(CloseAccount::of($janeDoe));

/**
 * Baskets
 */
$basket = BasketId::fromString(id());

// Pick up a basket
dispatch(PickUpBasket::withId($basket));

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
