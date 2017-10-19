<?php

namespace App\Components\Vault\Fractional\Services\Warden;

use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Components\Vault\Fractional\Agreement\Repositories\AgreementRepositoryContract;
use App\Components\Vault\Outbound\Wallet\WalletDTO;
use App\Components\Vault\Fractional\Agreement\Mutators\DTO\Mutator as AgreementMutator;
use App\Components\Vault\Outbound\Wallet\Mutators\DTO\Mutator as WalletMutator;

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
     * @param WalletDTO $paymentDTO
     * @return AgreementDTO
     */
    public function charge(AgreementDTO $agreementDTO, WalletDTO $paymentDTO): AgreementDTO
    {
        $agreement = AgreementMutator::fromDTO($agreementDTO);
        $agreement->pay(WalletMutator::fromDTO($paymentDTO));

        $this->repository->persist($agreement);

        return AgreementMutator::toDTO($agreement);
    }

    /**
     * @param AgreementDTO $agreementDTO
     * @param WalletDTO $paymentDTO
     * @return AgreementDTO
     */
    public function refund(AgreementDTO $agreementDTO, WalletDTO $paymentDTO): AgreementDTO
    {
        // TODO: Implement refund() method.
    }

    /**
     * @param AgreementDTO $agreementDTO
     * @return bool
     */
    public function isDeadlineReached(AgreementDTO $agreementDTO): bool
    {
        // TODO: Implement isDeadlineReached() method.
    }

    /**
     * @param AgreementDTO $agreementDTO
     * @return bool
     */
    public function isDeadlinePassed(AgreementDTO $agreementDTO): bool
    {
        // TODO: Implement isDeadlinePassed() method.
    }

    /**
     * @param AgreementDTO $agreementDTO
     * @return bool
     */
    public function isAgreementPassed(AgreementDTO $agreementDTO): bool
    {
        // TODO: Implement isAgreementPassed() method.
    }

}