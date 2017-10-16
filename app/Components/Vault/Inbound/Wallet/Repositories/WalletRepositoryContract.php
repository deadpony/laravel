<?php

namespace App\Components\Vault\Inbound\Wallet\Repositories;

use App\Components\Vault\Inbound\Wallet\WalletContract;
use App\Convention\ValueObjects\Identity\Identity;
use Illuminate\Support\Collection;

interface WalletRepositoryContract
{
    /**
     * @param Identity $identity
     * @return WalletContract|null
     */
    public function byIdentity(Identity $identity);

    /**
     * @return WalletContract|null
     */
    public function getOne();

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param WalletContract $statement
     * @return WalletContract
     */
    public function persist(WalletContract $statement): WalletContract;

    /**
     * @param WalletContract $statement
     * @return bool
     */
    public function destroy(WalletContract $statement): bool;

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @return WalletRepositoryContract
     */
    public function filter(string $key, string $operator, $value): WalletRepositoryContract;
}