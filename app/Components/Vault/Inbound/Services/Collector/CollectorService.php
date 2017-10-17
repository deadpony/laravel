<?php

namespace App\Components\Vault\Inbound\Services\Collector;

use App\Components\Vault\Inbound\Wallet\Repositories\WalletRepositoryContract;
use App\Components\Vault\Inbound\Wallet\WalletContract;
use App\Components\Vault\Inbound\Wallet\WalletDTO;
use App\Convention\Generators\Identity\IdentityGenerator;
use App\Convention\ValueObjects\Identity\Identity;

class CollectorService implements CollectorServiceContract
{
    /**
     * @var WalletRepositoryContract
     */
    private $repository;

    /**
     * @param WalletRepositoryContract $repository
     */
    public function __construct(WalletRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param WalletContract $entity
     * @return WalletDTO
     */
    private function toDTO(WalletContract $entity): WalletDTO
    {
        $dto = new WalletDTO();
        $dto->identity = (string) $entity->id();
        $dto->type = $entity->type();
        $dto->amount = $entity->amount();
        $dto->createdAt = $entity->createdAt()->format('Y-m-d H:i:s');

        return $dto;
    }

    /**
     * @param string $type
     * @param float $amount
     * @return WalletDTO
     */
    public function collect(string $type, float $amount): WalletDTO
    {
        $wallet = app()->make(WalletContract::class,
            ['id' => IdentityGenerator::next(), 'type' => $type, 'amount' => $amount]);

        $this->repository->persist($wallet);

        return $this->toDTO($wallet);
    }

    /**
     * @param string $identity
     * @param float $amount
     * @return WalletDTO
     */
    public function change(string $identity, float $amount): WalletDTO
    {
        $wallet = $this->repository->byIdentity(new Identity($identity));
        $wallet->updateAmount($amount);

        $this->repository->persist($wallet);

        return $this->toDTO($wallet);
    }

    /**
     * @param string $identity
     * @return bool
     */
    public function refund(string $identity): bool
    {
        $wallet = $this->repository->byIdentity(new Identity($identity));

        return $this->repository->destroy($wallet);
    }

    /**
     * @param string $identity
     * @return WalletDTO
     */
    public function view(string $identity): WalletDTO
    {
        $wallet = $this->repository->byIdentity(new Identity($identity));

        return $this->toDTO($wallet);
    }

}