<?php

namespace App\Components\Gringotts\Goblins;

class InstallmentGoblin extends AbstractGoblin
{
    /**
     * @var RepositoryContract
     */
    private $repository;

    /**
     * SalaryMiner constructor.
     * @param RepositoryContract $repository
     */
    public function __construct(RepositoryContract $repository)
    {
        $this->repository = $repository;

        $this->setType('installment');
    }
}