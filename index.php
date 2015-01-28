<?php require 'vendor/autoload.php';

error_reporting(-1);
ini_set('display_errors', 'On');

use KBC\Accounts\Account;
use KBC\Accounts\AccountRepository;
use KBC\Accounts\ValueObjects\Name;
use KBC\Storages\FileStorage;

// Clear the events, never ever do this in production
file_put_contents('storage/events.txt', '');

// Setup some stuff
$accountsRepository = new AccountRepository(new FileStorage());

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
$accountsRepository->save($robin);
$accountsRepository->save($sarah);

$accountsRepository->replayAll();