<?php namespace Api\db;

use App\models\Account;

/**
 * global state class
 * veeery simple approach for storing API state in memory
 */
class AccountDataStore
{
    private static $accounts = [];

    public static function reset(): bool
    {
        self::$accounts = [];
        return true;
    }

    public static function createAccount(string $id, Account $account): ?int
    {
        if (!isset($id)) {
            return null;
        }

        self::$accounts[$id] = $account;

        return $id;
    }

    public static function getAccountById(?int $id): ?int
    {
        if (is_null($id)) {
            return null;
        }

        return self::$accounts[$id] ?? null;
    }
}
