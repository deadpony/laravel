<?php

namespace App\Components\Vault\Fractional\Agreement\Repositories;

use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Components\Vault\Fractional\Agreement\AgreementEntity;
use App\Components\Vault\Fractional\Agreement\Repositories\Exceptions\NotFoundException;
use App\Convention\ValueObjects\Identity\Identity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Support\Collection;

class AgreementRepositoryDoctrine implements AgreementRepositoryContract
{
    /** @var EntityManagerInterface */
    private $manager;

    /** @var EntityRepository */
    private $entityRepository;

    /**
     * @var QueryBuilder
     */
    private $builder;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager                    = $manager;
        $this->entityRepository = $this->manager->getRepository(AgreementEntity::class);

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
     * @return AgreementContract
     * @throws NotFoundException
     */
    public function byIdentity(Identity $identity)
    {
        /** @var AgreementEntity $entity */
        $entity = $this->entityRepository->find($identity);

        if ($entity === null) {
            throw new NotFoundException("Not Found Exception");
        }

        return $entity;
    }


    /**
     * @return AgreementContract|null
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
     * @param AgreementContract $agreement
     * @return AgreementContract
     */
    public function register(AgreementContract &$agreement): AgreementContract
    {
        if (!$this->manager->contains($agreement)) {
            $agreement = $this->manager->merge($agreement);
        }

        return $agreement;
    }

    /**
     * @param AgreementContract $agreement
     * @return AgreementContract
     */
    public function persist(AgreementContract $agreement): AgreementContract
    {
        $this->register($agreement);

        $this->manager->persist($agreement);
        $this->manager->flush();

        return $agreement;
    }


    /**
     * @param AgreementContract $agreement
     * @return bool
     */
    public function destroy(AgreementContract $agreement): bool
    {
        $this->register($agreement);

        $this->manager->remove($agreement);
        $this->manager->flush();

        return true;
    }

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @param bool $orCondition
     * @return AgreementRepositoryContract
     */
    public function filter(string $key, string $operator, $value, bool $orCondition = false): AgreementRepositoryContract
    {
        if ($orCondition) {
            $this->builder->orWhere("ow.{$key} {$operator} :{$key}");
        } else {
            $this->builder->andWhere("ow.{$key} {$operator} :{$key}");
        }

        $this->builder->setParameter($key, $value);

        return $this;
    }
}