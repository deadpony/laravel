<?php

namespace App\Components\Vault\Incoming\Statement\Repositories;

use App\Components\Vault\Incoming\Statement\StatementContract;
use App\Convention\ValueObjects\Identity\Identity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Collection;

class StatementRepositoryDoctrine implements StatementRepositoryContract
{
    /** @var EntityManagerInterface */
    private $manager;

    /** @var EntityRepository */
    private $statementsEntityRepository;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager    = $manager;
        $this->statementsEntityRepository = $this->manager->getRepository(StatementContract::class);
    }

    /**
     * @param Identity $identity
     * @return StatementContract
     */
    public function byIdentity(Identity $identity): StatementContract
    {
        $entity = $this->statementsEntityRepository->find($identity->id());

        dd($entity);

        if ($entity === null) {
            throw new \Exception("Not Found Exception");
        }

        return $entity;
    }


    /**
     * @return StatementContract
     */
    public function getOne(): StatementContract
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param StatementContract $statement
     * @return StatementContract
     */
    public function persist(StatementContract $statement): StatementContract
    {
        $this->manager->persist($statement);

        return $statement;
    }


    /**
     * @param StatementContract $statement
     * @return bool
     */
    public function destroy(StatementContract $statement): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @return StatementRepositoryContract
     */
    public function filter(string $key, string $operator, $value): StatementRepositoryContract
    {
        $this->mapper->where($key, $operator, $value);

        return $this;
    }
}