<?php

namespace App\Components\Vault\Outbound\Payment\Repositories;

use App\Components\Vault\Outbound\Payment\Repositories\Exceptions\NotFoundException;
use App\Components\Vault\Outbound\Payment\PaymentContract;
use App\Convention\ValueObjects\Identity\Identity;
use Illuminate\Support\Collection;

interface PaymentRepositoryContract
{
    /**
     * @param Identity $identity
     * @return PaymentContract
     * @throws NotFoundException
     */
    public function byIdentity(Identity $identity);

    /**
     * @return PaymentContract|null
     */
    public function getOne();

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param PaymentContract $payment
     * @return PaymentContract
     */
    public function persist(PaymentContract $payment): PaymentContract;

    /**
     * @param PaymentContract $payment
     * @return bool
     */
    public function destroy(PaymentContract $payment): bool;

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @param bool $orCondition
     * @return PaymentRepositoryContract
     */
    public function filter(string $key, string $operator, $value, bool $orCondition = false): PaymentRepositoryContract;
}