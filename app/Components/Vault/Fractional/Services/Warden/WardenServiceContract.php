<?php

namespace App\Components\Vault\Fractional\Services\Warden;

use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Components\Vault\Outbound\Wallet\WalletDTO;

interface WardenServiceContract
{
    /**
     * @param AgreementDTO $agreementDTO
     * @param WalletDTO $paymentDTO
     * @return AgreementDTO
     */
    public function charge(AgreementDTO $agreementDTO, WalletDTO $paymentDTO): AgreementDTO;

    /**
     * @param AgreementDTO $agreementDTO
     * @param WalletDTO $paymentDTO
     * @return AgreementDTO
     */
    public function refund(AgreementDTO $agreementDTO, WalletDTO $paymentDTO): AgreementDTO;

    /**
     * @param AgreementDTO $agreementDTO
     * @return bool
     */
    public function isDeadlineReached(AgreementDTO $agreementDTO): bool;

    /**
     * @param AgreementDTO $agreementDTO
     * @return bool
     */
    public function isDeadlinePassed(AgreementDTO $agreementDTO): bool;

    /**
     * @param AgreementDTO $agreementDTO
     * @return bool
     */
    public function isAgreementPassed(AgreementDTO $agreementDTO): bool;
}