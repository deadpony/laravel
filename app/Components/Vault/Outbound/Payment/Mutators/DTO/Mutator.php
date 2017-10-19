<?php

namespace App\Components\Vault\Outbound\Payment\Mutators\DTO;

use App\Components\Vault\Outbound\Payment\PaymentContract;
use App\Components\Vault\Outbound\Payment\PaymentDTO;
use App\Convention\ValueObjects\Identity\Identity;
use Illuminate\Support\Collection;

class Mutator
{
    /**
     * @param Collection $collection
     * @return Collection
     */
    private static function generateIdentity(Collection $collection) {
        return $collection->isEmpty() ? $collection : $collection->put('id', new Identity($collection->get('id')));
    }

    /**
     * @param PaymentDTO $dto
     * @return PaymentContract
     */
    public static function fromDTO(PaymentDTO $dto): PaymentContract
    {
        return app()->make(PaymentContract::class, self::generateIdentity(collect($dto->toArray()))->toArray());
    }

    /**
     * @param PaymentContract $entity
     * @return PaymentDTO
     */
    public static function toDTO(PaymentContract $entity): PaymentDTO
    {
        $dto = new PaymentDTO();
        $dto->id = (string) $entity->id();
        $dto->type = $entity->type();
        $dto->amount = $entity->amount();
        $dto->createdAt = $entity->createdAt()->format('Y-m-d H:i:s');

        return $dto;
    }

}