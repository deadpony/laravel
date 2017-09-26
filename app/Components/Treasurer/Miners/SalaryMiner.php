<?php

namespace App\Components\Treasurer\Miners;

use App\Components\Treasurer\Miners\Repositories\Contracts\RepositoryContract;
use Carbon\Carbon;

class SalaryMiner extends AbstractMiner {

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

        $this->setType('salary');
    }

    /**
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return bool
     */
    public function earn(float $amount, Carbon $date = null): bool
    {
        return $this->repository->create(
            [
                'type'       => $this->getType(),
                'amount'     => $amount,
                'created_at' => $date ?? Carbon::now(),
            ]
        );
    }

    /**
     * @param int $id
     * @param float $amount
     * @param $date \Carbon\Carbon|null
     * @return bool
     */
    public function change(int $id, float $amount, Carbon $date = null): bool
    {
        $record = $this->repository->find($id);

        return $this->repository->update($record, [
            'type'       => $this->getType(),
            'amount'     => $amount,
            'created_at' => $date ?? Carbon::now(),
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function refund(int $id): bool
    {
        $record = $this->repository->find($id);

        return $this->repository->delete($record);
    }


}