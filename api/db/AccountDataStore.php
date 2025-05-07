<?php namespace Api\db;

use App\models\Account;

/**
 * global state class (state is key/value)
 * veeery simple approach for storing API state in memory
 */
class AccountDataStore
{
    /** @var array */
    private static $accounts = [];

    /**
     * Reset all state
     * @return bool
     */
    public static function reset(): bool
    {
        self::$accounts = [];
        return true;
    }

    /**
     * Store an account
     * @param string $id Account ID
     * @param Account $account account
     * @return int
     */
    public static function createAccount(string $id, Account $account): ?int
    {
        if (!isset($id)) {
            return null;
        }

        self::$accounts[$id] = $account;

        return $id;
    }

    /**
     * Get an account by ID
     * @param string $id Account ID
     * @return int|null Balance if account exists, null otherwise
     */
    public static function getAccountById(?int $id): ?int
    {
        if (is_null($id)) {
            return null;
        }

        return self::$accounts[$id] ?? null;
    }
}
