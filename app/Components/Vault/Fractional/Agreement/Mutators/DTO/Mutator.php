<?php

namespace App\Components\Vault\Fractional\Agreement\Mutators\DTO;

use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Components\Vault\Fractional\Agreement\Repositories\AgreementRepositoryContract;
use App\Components\Vault\Fractional\Agreement\Term\TermDTO;
use App\Components\Vault\Outbound\Payment\PaymentContract;
use App\Convention\ValueObjects\Identity\Identity;

class Mutator
{
    /**
     * @var AgreementRepositoryContract
     */
    private $repository;

    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @param AgreementRepositoryContract $repository
     */
    private function __construct(AgreementRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     *
     */
    private function __wakeup()
    {
    }

    /**
     * @return Mutator
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self(app()->make(AgreementRepositoryContract::class));
        }

        return self::$instance;
    }

    /**
     * @param AgreementDTO $dto
     * @return AgreementContract
     */
    public static function fromDTO(AgreementDTO $dto): AgreementContract
    {
        return self::getInstance()->repository->byIdentity(new Identity($dto->id));
    }

    /**
     * @param AgreementContract $entity
     * @return AgreementDTO
     */
    public static function toDTO(AgreementContract $entity): AgreementDTO
    {
        $dto = new AgreementDTO();
        $dto->id = (string) $entity->id();
        $dto->amount = $entity->amount();
        $dto->createdAt = $entity->createdAt()->format('Y-m-d H:i:s');

        if ($entity->term() !== null) {
            $termDTO = new TermDTO();
            $termDTO->id = (string) $entity->term()->id();
            $termDTO->months = $entity->term()->months();
            $termDTO->deadlineDay = $entity->term()->deadlineDay();
            $termDTO->setupFee = $entity->term()->setupFee();
            $termDTO->monthlyFee = $entity->term()->monthlyFee();
            $termDTO->createdAt = $entity->term()->createdAt()->format('Y-m-d H:i:s');
            $termDTO->agreement = $dto;

            $dto->term = $termDTO;
        }

        if ($entity->payments()) {
            collect($entity->payments())->each(function(PaymentContract $payment) use ($dto) {
                $dto->payments[] = \App\Components\Vault\Outbound\Payment\Mutators\DTO\Mutator::toDTO($payment);
            });
        }

        return $dto;
    }

}