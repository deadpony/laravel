<?php

namespace App\Components\Vault\Fractional\Services\Warden;

use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Components\Vault\Outbound\Payment\PaymentDTO;

interface WardenServiceContract
{
    /**
     * @param AgreementDTO $agreementDTO
     * @param PaymentDTO $paymentDTO
     * @return AgreementDTO
     */
    public function charge(AgreementDTO $agreementDTO, PaymentDTO $paymentDTO): AgreementDTO;

    /**
     * @param AgreementDTO $agreementDTO
     * @param PaymentDTO $paymentDTO
     * @return AgreementDTO
     */
    public function refund(AgreementDTO $agreementDTO, PaymentDTO $paymentDTO): AgreementDTO;

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