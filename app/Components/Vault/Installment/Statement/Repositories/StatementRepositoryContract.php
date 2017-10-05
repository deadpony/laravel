<?php

namespace App\Components\Vault\Installment\Statement\Repositories;

use App\Components\Vault\Installment\Statement\StatementContract;
use App\Convention\ValueObjects\Identity\Identity;
use Illuminate\Support\Collection;

interface StatementRepositoryContract
{
    /**
     * @param Identity $identity
     * @return StatementContract|null
     */
    public function byIdentity(Identity $identity);

    /**
     * @return StatementContract|null
     */
    public function getOne();

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param StatementContract $statement
     * @return StatementContract
     */
    public function persist(StatementContract $statement): StatementContract;

    /**
     * @param StatementContract $statement
     * @return bool
     */
    public function destroy(StatementContract $statement): bool;

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @return StatementRepositoryContract
     */
    public function filter(string $key, string $operator, $value): StatementRepositoryContract;
}