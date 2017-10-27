<?php

namespace App\Components\Vault\Fractional\Services\Warden;

use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Components\Vault\Fractional\Agreement\Repositories\AgreementRepositoryContract;
use App\Components\Vault\Outbound\Payment\PaymentDTO;
use App\Components\Vault\Fractional\Agreement\Mutators\DTO\Mutator as AgreementMutator;
use App\Components\Vault\Outbound\Payment\Mutators\DTO\Mutator as PaymentMutator;

class WardenService implements WardenServiceContract
{

    /**
     * @var AgreementRepositoryContract
     */
    private $repository;

    /**
     * @param AgreementRepositoryContract $repository
     */
    public function __construct(AgreementRepositoryContract $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param AgreementDTO $agreementDTO
     * @param PaymentDTO $paymentDTO
     * @return AgreementDTO
     */
    public function charge(AgreementDTO $agreementDTO, PaymentDTO $paymentDTO): AgreementDTO
    {
        $agreement = AgreementMutator::fromDTO($agreementDTO);
        $agreement->pay(PaymentMutator::fromDTO($paymentDTO));

        $this->repository->persist($agreement);

        return AgreementMutator::toDTO($agreement);
    }

    /**
     * @param AgreementDTO $agreementDTO
     * @param PaymentDTO $paymentDTO
     * @return AgreementDTO
     */
    public function refund(AgreementDTO $agreementDTO, PaymentDTO $paymentDTO): AgreementDTO
    {
        $agreement = AgreementMutator::fromDTO($agreementDTO);
        $agreement->refund(PaymentMutator::fromDTO($paymentDTO));

        $this->repository->persist($agreement);

        return AgreementMutator::toDTO($agreement);
    }

    /**
     * @param AgreementDTO $agreementDTO
     * @return bool
     */
    public function isDeadlinePassed(AgreementDTO $agreementDTO): bool
    {
        $agreement = AgreementMutator::fromDTO($agreementDTO);

        return $agreement->isDeadlinePassed();
    }

    /**
     * @param AgreementDTO $agreementDTO
     * @return bool
     */
    public function isAgreementPassed(AgreementDTO $agreementDTO): bool
    {
        $agreement = AgreementMutator::fromDTO($agreementDTO);

        return $agreement->isAgreementPassed();
    }

}