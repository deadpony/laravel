<?php

namespace App\Components\Vault\Inbound\Wallet\Mutators\DTO;

use App\Components\Vault\Inbound\Wallet\WalletContract;
use App\Components\Vault\Inbound\Wallet\WalletDTO;
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
     * @param WalletDTO $dto
     * @return WalletContract
     */
    public static function fromDTO(WalletDTO $dto): WalletContract
    {
        return app()->make(WalletContract::class, self::generateIdentity(collect($dto->toArray()))->toArray());
    }

    /**
     * @param WalletContract $entity
     * @return WalletDTO
     */
    public static function toDTO(WalletContract $entity): WalletDTO
    {
        $dto = new WalletDTO();
        $dto->id = (string) $entity->id();
        $dto->type = $entity->type();
        $dto->amount = $entity->amount();
        $dto->createdAt = $entity->createdAt()->format('Y-m-d H:i:s');

        return $dto;
    }

}