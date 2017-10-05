<?php

namespace App\Components\Vault\Incoming\Statement\Repositories;

use App\Components\Vault\Incoming\Statement\StatementContract;
use App\Convention\ValueObjects\Identity\Identity;
use Illuminate\Support\Collection;

interface StatementRepositoryContract
{
    /**
     * @param Identity $identity
     * @return StatementContract
     */
    public function byIdentity(Identity $identity): StatementContract;

    /**
     * @return StatementContract
     */
    public function getOne(): StatementContract;

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