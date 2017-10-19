<?php

namespace App\Components\Vault\Fractional\Agreement\Mutators\DTO;

use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Components\Vault\Fractional\Agreement\Term\TermDTO;
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
     * @param AgreementDTO $dto
     * @return AgreementContract
     */
    public static function fromDTO(AgreementDTO $dto): AgreementContract
    {
        $params = self::generateIdentity(collect($dto->toArray()));

        $agreement = app()->make(AgreementContract::class, $params->except('term')->toArray());

        $params = self::generateIdentity(collect($params->get('term', [])));

        if ($params->isNotEmpty()) {
            $params->put('agreement', $agreement);
            app()->make(TermContract::class, $params->toArray());
        }

        return $agreement;
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

        return $dto;
    }

}