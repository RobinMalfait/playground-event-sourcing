<?php namespace KBC\Accounts;

use KBC\Accounts\Events\AccountWasOpened;
use KBC\Accounts\Events\MoneyHasBeenCollected;
use KBC\Accounts\Events\MoneyWasDeposited;
use KBC\Core\BaseModel;
use Rhumsaa\Uuid\Uuid;

class Account extends BaseModel {

    protected $name;
    protected $id;

    private function __construct(Name $name)
    {
        $this->id = (String) Uuid::uuid4();
        $this->name = $name;
    }

    public static function open(Name $name)
    {
        $account = new Static($name);

        $account->recordThat(new AccountWasOpened($account));

        return $account;
    }

    public function deposit($amount)
    {
        $this->recordThat(new MoneyWasDeposited($this->id, $amount));
    }

    public function withdraw($amount)
    {
        $this->recordThat(new MoneyHasBeenCollected($this->id, $amount));
    }

}