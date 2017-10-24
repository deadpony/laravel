<?php

namespace App\Components\Vault\Fractional\Services\Collector;

use App\Components\Vault\Fractional\Agreement\AgreementDTO;
use App\Components\Vault\Fractional\Agreement\Mutators\DTO\Mutator;
use App\Components\Vault\Fractional\Agreement\Repositories\AgreementRepositoryContract;
use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Convention\Generators\Identity\IdentityGenerator;
use App\Convention\ValueObjects\Identity\Identity;

class CollectorService implements CollectorServiceContract
{
    /**
     * @var AgreementRepositoryContract
     */
    private $repository;

    /** @var array */
    private $untrackedTerm;

    /**
     * @param AgreementRepositoryContract $repository
     */
    public function __construct(AgreementRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AgreementContract $agreement
     * @return AgreementContract
     */
    private function trackTermUpdates(AgreementContract $agreement)
    {
        if ($this->untrackedTerm) {
            $params = collect($this->untrackedTerm);

            if ($agreement->term() !== null) {
                $agreement->term()->updateMonths($params->get('months'));
                $agreement->term()->updateDeadlineDay($params->get('deadlineDay'));
                $agreement->term()->updateMonthlyFee($params->get('monthlyFee'));
                $agreement->term()->updateSetupFee($params->get('setupFee'));
            } else {
                app()->make(TermContract::class, $params->prepend(IdentityGenerator::next(), 'id')->put('agreement', $agreement)->toArray());
            }

            $this->untrackedTerm = [];
        }

        return $agreement;
    }

    /**
     * @param float $amount
     * @return AgreementDTO
     */
    public function collect(float $amount): AgreementDTO
    {
        $agreement = app()->make(AgreementContract::class, [
            'id' => IdentityGenerator::next(),
            'amount' => $amount
        ]);

        $this->trackTermUpdates($agreement);

        $this->repository->persist($agreement);

        return Mutator::toDTO($agreement);
    }

    /**
     * @param string $identity
     * @param float $amount
     * @return AgreementDTO
     */
    public function change(string $identity, float $amount): AgreementDTO
    {
        $agreement = $this->repository->byIdentity(new Identity($identity));

        $agreement->updateAmount($amount);

        $this->trackTermUpdates($agreement);

        $this->repository->persist($agreement);

        return Mutator::toDTO($agreement);
    }

    /**
     * @param string $identity
     * @return bool
     */
    public function refund(string $identity): bool
    {
        $agreement = $this->repository->byIdentity(new Identity($identity));

        $this->repository->destroy($agreement);

        return true;
    }

    /**
     * @param string $identity
     * @return AgreementDTO
     */
    public function view(string $identity): AgreementDTO
    {
        $agreement = $this->repository->byIdentity(new Identity($identity));

        return Mutator::toDTO($agreement);
    }

    /**
     * @param int $months
     * @param int $paymentDeadlineDay
     * @param float $setupFee
     * @param float $monthlyFee
     * @return CollectorServiceContract
     */
    public function assignTerm(
        int $months,
        int $paymentDeadlineDay,
        float $setupFee = 0.00,
        float $monthlyFee = 0.00
    ): CollectorServiceContract {
        $this->untrackedTerm = [
            'months' => $months,
            'deadlineDay' => $paymentDeadlineDay,
            'setupFee' => $setupFee,
            'monthlyFee' => $monthlyFee,
        ];

        return $this;
    }
}