<?php

namespace App\Components\Vault\Inbound\Wallet\Repositories;

use App\Components\Vault\Inbound\Wallet\WalletContract;
use App\Components\Vault\Inbound\Wallet\WalletEntity;
use App\Convention\ValueObjects\Identity\Identity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Collection;

class WalletRepositoryDoctrine implements WalletRepositoryContract
{
    /** @var EntityManagerInterface */
    private $manager;

    /** @var EntityRepository */
    private $entityRepository;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager          = $manager;
        $this->entityRepository = $this->manager->getRepository(WalletEntity::class);
    }

    /**
     * @param Identity $identity
     * @return WalletContract|null
     */
    public function byIdentity(Identity $identity)
    {
        /** @var WalletContract $entity */
        $entity = $this->entityRepository->find($identity);

        if ($entity === null) {
            throw new \Exception("Not Found Exception");
        }

        return $entity;
    }


    /**
     * @return WalletContract|null
     */
    public function getOne()
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
        // TODO: Implement delete() method.
    }

    /**
     * @param string $key
     * @param string $operator
     * @param $value
     * @return WalletRepositoryContract
     */
    public function filter(string $key, string $operator, $value): WalletRepositoryContract
    {
        $this->mapper->where($key, $operator, $value);

        return $this;
    }
}