<?php

namespace App\Components\Vault\Outbound\Wallet\Repositories;

use App\Components\Vault\Outbound\Wallet\Repositories\Exceptions\NotFoundException;
use App\Components\Vault\Outbound\Wallet\WalletContract;
use App\Convention\ValueObjects\Identity\Identity;
use Illuminate\Support\Collection;

interface WalletRepositoryContract
{
    /**
     * @param Identity $identity
     * @return WalletContract
     * @throws NotFoundException
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
     * @param WalletContract $wallet
     * @return WalletContract
     */
    public function persist(WalletContract $wallet): WalletContract;

    /**
     * @param WalletContract $wallet
     * @return bool
     */
    public function destroy(WalletContract $wallet): bool;

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @param bool $orCondition
     * @return WalletRepositoryContract
     */
    public function filter(string $key, string $operator, $value, bool $orCondition = false): WalletRepositoryContract;
}