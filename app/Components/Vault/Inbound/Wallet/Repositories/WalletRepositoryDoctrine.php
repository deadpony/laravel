<?php

namespace App\Components\Vault\Inbound\Wallet\Repositories;

use App\Components\Vault\Inbound\Wallet\Repositories\Exceptions\NotFoundException;
use App\Components\Vault\Inbound\Wallet\WalletContract;
use App\Components\Vault\Inbound\Wallet\WalletEntity;
use App\Convention\ValueObjects\Identity\Identity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Support\Collection;

class WalletRepositoryDoctrine implements WalletRepositoryContract
{
    /** @var EntityManagerInterface */
    private $manager;

    /** @var EntityRepository */
    private $entityRepository;

    /**
     * @var QueryBuilder
     */
    private $builder;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager          = $manager;
        $this->entityRepository = $this->manager->getRepository(WalletEntity::class);
        $this->refreshBuilder();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function refreshBuilder() {

        $this->builder = $this->entityRepository->createQueryBuilder('iw');

        return $this->builder;
    }

    /**
     * @param Identity $identity
     * @return WalletContract
     * @throws NotFoundException
     */
    public function byIdentity(Identity $identity)
    {
        /** @var WalletContract $entity */
        $entity = $this->entityRepository->find($identity);

        if ($entity === null) {
            throw new NotFoundException("Not Found Exception");
        }

        return $entity;
    }


    /**
     * @return WalletContract|null
     */
    public function getOne()
    {
        $result = $this->builder->getQuery()->getOneOrNullResult();

        $this->refreshBuilder();

        return $result;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        $results = $this->builder->getQuery()->getResult();

        $this->refreshBuilder();

        return collect($results);
    }

    /**
     * @param WalletContract $statement
     * @return WalletContract
     */
    public function persist(WalletContract $statement): WalletContract
    {
        $this->manager->persist($statement);
        $this->manager->flush();
        $this->manager->clear();

        return $statement;
    }


    /**
     * @param WalletContract $statement
     * @return bool
     */
    public function destroy(WalletContract $statement): bool
    {
        $this->manager->remove($statement);
        $this->manager->flush();
        $this->manager->clear();

        return true;
    }

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @param bool $orCondition
     * @return WalletRepositoryContract
     */
    public function filter(string $key, string $operator, $value, bool $orCondition = false): WalletRepositoryContract
    {
        if ($orCondition) {
            $this->builder->orWhere("iw.{$key} {$operator} :{$key}");
        } else {
            $this->builder->andWhere("iw.{$key} {$operator} :{$key}");
        }

        $this->builder->setParameter($key, $value);

        return $this;
    }
}