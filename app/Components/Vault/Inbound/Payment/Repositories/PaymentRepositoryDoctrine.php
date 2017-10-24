<?php

namespace App\Components\Vault\Inbound\Payment\Repositories;

use App\Components\Vault\Inbound\Payment\Repositories\Exceptions\NotFoundException;
use App\Components\Vault\Inbound\Payment\PaymentContract;
use App\Components\Vault\Inbound\Payment\PaymentEntity;
use App\Convention\ValueObjects\Identity\Identity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Support\Collection;

class PaymentRepositoryDoctrine implements PaymentRepositoryContract
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
        $this->entityRepository = $this->manager->getRepository(PaymentEntity::class);
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
     * @return PaymentContract
     * @throws NotFoundException
     */
    public function byIdentity(Identity $identity)
    {
        /** @var PaymentContract $entity */
        $entity = $this->entityRepository->find($identity);

        if ($entity === null) {
            throw new NotFoundException("Not Found Exception");
        }

        return $entity;
    }


    /**
     * @return PaymentContract|null
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
     * @param PaymentContract $payment
     * @return PaymentContract
     */
    public function register(PaymentContract &$payment): PaymentContract
    {
        if (!$this->manager->contains($payment)) {
            $payment = $this->manager->merge($payment);
        }

        return $payment;
    }


    /**
     * @param PaymentContract $payment
     * @return PaymentContract
     */
    public function persist(PaymentContract $payment): PaymentContract
    {
        $this->register($payment);

        $this->manager->persist($payment);
        $this->manager->flush();

        return $payment;
    }


    /**
     * @param PaymentContract $payment
     * @return bool
     */
    public function destroy(PaymentContract $payment): bool
    {
        $this->register($payment);

        $this->manager->remove($payment);
        $this->manager->flush();

        return true;
    }

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @param bool $orCondition
     * @return PaymentRepositoryContract
     */
    public function filter(string $key, string $operator, $value, bool $orCondition = false): PaymentRepositoryContract
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