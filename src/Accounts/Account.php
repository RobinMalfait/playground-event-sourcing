<?php namespace Acme\Accounts;

use Acme\Accounts\Events\AccountWasClosed;
use Acme\Accounts\Events\AccountWasOpened;
use Acme\Accounts\Events\MoneyWasWithdrawn;
use Acme\Accounts\Events\MoneyWasDeposited;
use Acme\Accounts\VO\AccountId;
use Acme\Accounts\VO\Amount;
use Acme\Accounts\VO\Name;
use Acme\Core\AggregateRoot;

final class Account extends AggregateRoot
{

    /** @var \Acme\Accounts\VO\Name */
    public $name;

    /** @var \Acme\Accounts\VO\Amount */
    public $balance;

    /** @var \Acme\Accounts\VO\AccountId */
    public $id;

    /** @var bool */
    public $closed;

    public static function open(AccountId $id, Name $name)
    {
        $me = new static();

        $me->apply(new AccountWasOpened($id, $name, new Amount(0)));

        return $me;
    }

    public function close()
    {
        $this->apply(new AccountWasClosed($this->id));
    }

    public function deposit($balance)
    {
        if ($this->closed) {
            throw new AccountClosedException();
        }

        $this->apply(new MoneyWasDeposited($this->id, $balance));
    }

    public function withdraw($balance)
    {
        if ($this->closed) {
            throw new AccountClosedException();
        }

        $this->apply(new MoneyWasWithdrawn($this->id, $balance));
    }

    /* Respond to events */
    public function applyAccountWasOpened(AccountWasOpened $event)
    {
        $this->id = $event->getAccountId();
        $this->balance = $event->getBalance();
        $this->name = $event->getName();
        $this->closed = false;
    }

    public function applyMoneyWasDeposited(MoneyWasDeposited $event)
    {
        $this->balance = new Amount(
            $this->balance->getAmount() + $event->getBalance()->getAmount()
        );
    }

    public function applyMoneyWasWithdrawn(MoneyWasWithdrawn $event)
    {
        $this->balance = new Amount(
            $this->balance->getAmount() - $event->getBalance()->getAmount()
        );
    }

    public function applyAccountWasClosed(AccountWasClosed $event)
    {
        $this->closed = true;
    }
}
