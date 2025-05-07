<?php
namespace Api\db;

use Api\models\AccountModel as Account;

/*
 * JSON data store, had to implement this because Slim's uses stateless API design,
 * and data in-memory was not viable
 */
class AccountDataStore
{
    private static $accounts = null;
    private static $dataFile = __DIR__ . "/data/accounts.json";

    private static function load(): void
    {
        // Only load once per request
        if (self::$accounts !== null) {
            return;
        }

        // Ensure directory exists
        $dir = dirname(self::$dataFile);

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        // Try to load existing data
        if (file_exists(self::$dataFile)) {
            $data = json_decode(file_get_contents(self::$dataFile), true) ?: [];
            self::$accounts = [];

            // Convert back to AccountModel objects
            foreach ($data as $id => $accountData) {
                self::$accounts[$id] = new Account(
                    $id,
                    $accountData["balance"]
                );
            }
        } else {
            self::$accounts = [];
        }
    }

    /**
     * Save accounts to storage
     */
    private static function save(): void
    {
        if (is_null(self::$accounts)) {
            self::load();
        }

        $data = [];
        foreach (self::$accounts as $id => $account) {
            $data[$id] = [
                "id" => $account->getId(),
                "balance" => $account->getBalance(),
            ];
        }

        file_put_contents(self::$dataFile, json_encode($data));
    }

    public static function reset(): bool
    {
        self::$accounts = [];

        file_put_contents(self::$dataFile, json_encode([]));

        return true;
    }

    public static function createAccount(string $id, ?Account $account): ?int
    {
        self::load();

        if (!isset($id) || is_null($account)) {
            return null;
        }

        self::$accounts[$id] = $account;
        self::save();

        return $id;
    }

    public static function getAccountById(string $id): ?Account
    {
        self::load();

        if (is_null($id)) {
            return null;
        }

        return self::$accounts[$id] ?? null;
    }

    /**
     * Update an existing account (needed to preserve balance changes)
     */
    public static function updateAccount(string $id, Account $account): bool
    {
        self::load();

        if (isset(self::$accounts[$id])) {
            self::$accounts[$id] = $account;
            self::save();
            return true;
        }

        return false;
    }
}
