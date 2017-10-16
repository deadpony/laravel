<?php

namespace App\Components\Vault\Inbound\Services\Collector;

use App\Components\Vault\Inbound\Wallet\Repositories\WalletRepositoryContract;
use App\Components\Vault\Inbound\Wallet\WalletEntity;
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
     * @param string $type
     * @param float $amount
     * @return string
     */
    public function collect(string $type, float $amount): string
    {
        $entity = app()->make(WalletEntity::class, ['id' => IdentityGenerator::next(), 'type' => $type, 'amount' => $amount]);

        $wallet = $this->repository->persist($entity);

        return (string) $wallet->id();
    }

    /**
     * @param string $identity
     * @param float $amount
     * @return string
     */
    public function change(string $identity, float $amount): string
    {
        $wallet = $this->repository->byIdentity(new Identity($identity));
        $wallet->updateAmount($amount);

        $this->repository->persist($wallet);

        return (string) $wallet->id();
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
     * @return array
     */
    public function view(string $identity): array
    {
        $wallet = $this->repository->byIdentity(new Identity($identity));

        return [
            'id' => (string) $wallet->id(),
            'type' => $wallet->type(),
            'amount' => $wallet->amount(),
        ];
    }

}