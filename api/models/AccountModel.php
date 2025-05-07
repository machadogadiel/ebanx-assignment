<?php
namespace Api\models;

use Api\db\AccountDataStore as DataStore;

class AccountModel
{
    private $id;
    private $balance;

    public function __construct(string $id, int $balance)
    {
        $this->id = $id;
        $this->balance = $balance ?? 0;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function withdraw(int $amount): int
    {
        $this->balance -= $amount;

        return $this->balance;
    }

    public function deposit(int $amount): int
    {
        $this->balance += $amount;

        return $this->balance;
    }

    public function transferTo(
        string $destinationAccountId,
        int $amount
    ): ?array {
        $destAccount = DataStore::getAccountById($destinationAccountId);

        if ($destAccount) {
            // take from away from current account
            $withdrawnAmount = $this->withdraw($amount);
            // add to destination
            $destAccount->deposit($withdrawnAmount);

            return [$this, $destAccount];
        }

        return null;
    }
}
?>
