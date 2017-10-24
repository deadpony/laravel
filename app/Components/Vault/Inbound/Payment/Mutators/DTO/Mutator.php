<?php

namespace App\Components\Vault\Inbound\Payment\Mutators\DTO;

use App\Components\Vault\Inbound\Payment\PaymentContract;
use App\Components\Vault\Inbound\Payment\PaymentDTO;
use App\Components\Vault\Inbound\Payment\Repositories\PaymentRepositoryContract;
use App\Convention\ValueObjects\Identity\Identity;

class Mutator
{
    /**
     * @var PaymentRepositoryContract
     */
    private $repository;

    /**
     * @var self|null
     */
    private static $instance;

    /**
     * @param PaymentRepositoryContract $repository
     */
    private function __construct(PaymentRepositoryContract $repository)
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
            self::$instance = new self(app()->make(PaymentRepositoryContract::class));
        }

        return self::$instance;
    }

    /**
     * @param PaymentDTO $dto
     * @return PaymentContract
     */
    public static function fromDTO(PaymentDTO $dto): PaymentContract
    {
        return self::getInstance()->repository->byIdentity(new Identity($dto->id));
    }

    /**
     * @param PaymentContract $entity
     * @return PaymentDTO
     */
    public static function toDTO(PaymentContract $entity): PaymentDTO
    {
        $dto = new PaymentDTO();
        $dto->id = (string)$entity->id();
        $dto->type = $entity->type();
        $dto->amount = $entity->amount();
        $dto->createdAt = $entity->createdAt()->format('Y-m-d H:i:s');

        return $dto;
    }

}