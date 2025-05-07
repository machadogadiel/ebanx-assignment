<?php
namespace Api\models;

use Api\db\AccountDataStore as DataStore;

class AccountModel
{
    private $id;
    private $balance;

    public function __construct(int $id, int $balance)
    {
        $this->id = $id;
        $this->balance = $balance ?? 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function withdraw(int $amount): int
    {
        return $this->balance -= $amount;
    }

    public function deposit(int $amount): int
    {
        return $this->balance += $amount;
    }

    public function transferTo(int $destinationAccountId, int $amount): ?int
    {
        $destAccount = DataStore::getAccountById($destinationAccountId);

        if ($destAccount) {
            // take from away from current account
            $this->withdraw($amount);
            // add to destination
            $destAccount->deposit($amount);
            return [$this, $destAccount];
        }

        return null;
    }
}
?>
