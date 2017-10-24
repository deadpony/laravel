<?php

namespace App\Components\Vault\Fractional\Agreement\Repositories;

use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Components\Vault\Fractional\Agreement\Repositories\Exceptions\NotFoundException;
use App\Convention\ValueObjects\Identity\Identity;
use Illuminate\Support\Collection;

interface AgreementRepositoryContract
{
    /**
     * @param Identity $identity
     * @return AgreementContract
     * @throws NotFoundException
     */
    public function byIdentity(Identity $identity);

    /**
     * @return AgreementContract|null
     */
    public function getOne();

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param AgreementContract $agreement
     * @return AgreementContract
     */
    public function register(AgreementContract &$agreement): AgreementContract;

    /**
     * @param AgreementContract $agreement
     * @return AgreementContract
     */
    public function persist(AgreementContract $agreement): AgreementContract;

    /**
     * @param AgreementContract $agreement
     * @return bool
     */
    public function destroy(AgreementContract $agreement): bool;

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @param bool $orCondition
     * @return AgreementRepositoryContract
     */
    public function filter(string $key, string $operator, $value, bool $orCondition = false): AgreementRepositoryContract;
}