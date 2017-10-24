<?php

namespace App\Components\Vault\Inbound\Payment\Mutators\DTO;

use App\Components\Vault\Inbound\Payment\PaymentContract;
use App\Components\Vault\Inbound\Payment\PaymentDTO;
use App\Components\Vault\Inbound\Payment\Repositories\Exceptions\NotFoundException;
use App\Components\Vault\Inbound\Payment\Repositories\PaymentRepositoryContract;
use App\Convention\ValueObjects\Identity\Identity;
use Illuminate\Support\Collection;

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
     * @param Collection $collection
     * @return Collection
     */
    private static function generateIdentity(Collection $collection)
    {
        return $collection->isEmpty() ? $collection : $collection->put('id', new Identity($collection->get('id')));
    }

    /**
     * @param PaymentDTO $dto
     * @return PaymentContract
     */
    public static function fromDTO(PaymentDTO $dto): PaymentContract
    {
        try {
            $entity = self::getInstance()->repository->byIdentity(self::generateIdentity(collect($dto->toArray()))->get('id'));
        } catch (NotFoundException $ex) {
            $entity = app()->make(PaymentContract::class, self::generateIdentity(collect($dto->toArray()))->toArray());

            self::getInstance()->repository->register($entity);
        }

        return $entity;
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