<?php

namespace App\Components\Vault\Outbound\Services\Collector;

use App\Components\Vault\Outbound\Payment\Mutators\DTO\Mutator;
use App\Components\Vault\Outbound\Payment\Repositories\PaymentRepositoryContract;
use App\Components\Vault\Outbound\Payment\PaymentContract;
use App\Components\Vault\Outbound\Payment\PaymentDTO;
use App\Convention\Generators\Identity\IdentityGenerator;
use App\Convention\ValueObjects\Identity\Identity;

class CollectorService implements CollectorServiceContract
{
    /**
     * @var PaymentRepositoryContract
     */
    private $repository;

    /**
     * @param PaymentRepositoryContract $repository
     */
    public function __construct(PaymentRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $type
     * @param float $amount
     * @return PaymentDTO
     */
    public function collect(string $type, float $amount): PaymentDTO
    {
        $payment = app()->make(PaymentContract::class, ['id' => IdentityGenerator::next(), 'type' => $type, 'amount' => $amount]);

        $this->repository->persist($payment);

        return Mutator::toDTO($payment);
    }

    /**
     * @param string $identity
     * @param float $amount
     * @return PaymentDTO
     */
    public function change(string $identity, float $amount): PaymentDTO
    {
        $payment = $this->repository->byIdentity(new Identity($identity));
        $payment->updateAmount($amount);

        $this->repository->persist($payment);

        return Mutator::toDTO($payment);
    }

    /**
     * @param string $identity
     * @return bool
     */
    public function refund(string $identity): bool
    {
        $payment = $this->repository->byIdentity(new Identity($identity));

        return $this->repository->destroy($payment);
    }

    /**
     * @param string $identity
     * @return PaymentDTO
     */
    public function view(string $identity): PaymentDTO
    {
        $payment = $this->repository->byIdentity(new Identity($identity));

        return Mutator::toDTO($payment);
    }

}