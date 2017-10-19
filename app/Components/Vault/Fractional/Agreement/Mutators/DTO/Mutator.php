<?php

namespace App\Components\Vault\Fractional\Agreement\Mutators\DTO;

use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Components\Vault\Fractional\Agreement\Term\TermDTO;
use App\Components\Vault\Outbound\Wallet\WalletContract;
use App\Components\Vault\Outbound\Wallet\WalletDTO;
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
        $aggRoot  = self::generateIdentity(collect($dto->toArray()));
        $term     = self::generateIdentity(collect($aggRoot->pull('term', [])));
        $payments = self::generateIdentity(collect($aggRoot->pull('payments', [])));

        $agreement = app()->make(AgreementContract::class, $aggRoot->toArray());

        if ($term->isNotEmpty()) {
            $term->put('agreement', $agreement);
            app()->make(TermContract::class, $term->toArray());
        }

        if ($payments->isNotEmpty()) {
            $payments->each(function(WalletDTO $paymentDTO) use ($agreement) {
                $agreement->pay(\App\Components\Vault\Outbound\Wallet\Mutators\DTO\Mutator::fromDTO($paymentDTO));
            });
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

        if ($entity->payments()) {
            collect($entity->payments())->each(function(WalletContract $payment) use ($dto) {
                $dto->payments[] = \App\Components\Vault\Outbound\Wallet\Mutators\DTO\Mutator::toDTO($payment);
            });
        }

        return $dto;
    }

}